<?php 
include 'db_config.php'; 
include 'header.php'; 

if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit();
}

$event_id = (int)($_GET['event_id'] ?? 0);
$user_id = $_SESSION['user_id'];

// --- UPDATE LOGIC ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_event'])) {
    $post_event_id = $_POST['event_id'];
    $title = $_POST['title'];
    $location = $_POST['location'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $description = $_POST['description'];
    
    // Image Handling
    $image_name = $_POST['existing_image']; 
    if (!empty($_FILES['event_image']['name'])) {
        $target_dir = "uploads/";
        $image_name = time() . "_" . basename($_FILES["event_image"]["name"]);
        move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_dir . $image_name);
    }

    try {
        $pdo->beginTransaction();

        // 1. Update the 'events' table
        $sql = "UPDATE events SET title=?, location=?, event_date=?, event_time=?, description=?, event_image=? WHERE event_id=? AND organizer_id=?";
        $update_stmt = $pdo->prepare($sql);
        $update_stmt->execute([$title, $location, $event_date, $event_time, $description, $image_name, $post_event_id, $user_id]);

        // 2. Update 'ticket_types' table for Regular, VIP, and VVIP
        // We use a specific query for each to ensure we don't overwrite the wrong category
        $ticket_updates = [
            'Regular Access' => (float)$_POST['price'],
            'VIP Access'     => (float)$_POST['price_vip'],
            'VVIP Access'    => (float)$_POST['price_vvip']
        ];

        $stmt_ticket = $pdo->prepare("UPDATE ticket_types SET price = ? WHERE event_id = ? AND name = ?");
        foreach ($ticket_updates as $name => $new_price) {
            $stmt_ticket->execute([$new_price, $post_event_id, $name]);
        }

        $pdo->commit();
        echo "<script>alert('Event and Ticket Prices Updated!'); window.location.href='manage_events.php';</script>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}

// Fetch Event Data
$stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ? AND organizer_id = ?");
$stmt->execute([$event_id, $user_id]);
$event = $stmt->fetch();

// Fetch Ticket Data from 'ticket_types' to populate the form
$stmt_prices = $pdo->prepare("SELECT name, price FROM ticket_types WHERE event_id = ?");
$stmt_prices->execute([$event_id]);
$db_prices = $stmt_prices->fetchAll(PDO::FETCH_KEY_PAIR);

if (!$event) { die("Event not found or access denied."); }

$formatted_time = !empty($event['event_time']) ? date('H:i', strtotime($event['event_time'])) : '20:00';

// Helper to get prices even if they don't exist in DB yet
$price_reg = $db_prices['Regular Access'] ?? 0;
$price_vip = $db_prices['VIP Access'] ?? 0;
$price_vvip = $db_prices['VVIP Access'] ?? 0;
?>

<div class="p-8 max-w-4xl mx-auto min-h-screen">
    <div class="glass p-10 rounded-[40px] border border-white/10 relative overflow-hidden">
        <h1 class="text-4xl font-black text-white italic tracking-tighter uppercase mb-8">Edit <span class="text-purple-500">Event</span></h1>

        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
            <input type="hidden" name="existing_image" value="<?php echo $event['event_image']; ?>">

            <div class="flex items-center gap-6 p-6 bg-white/5 rounded-3xl border border-white/10">
                <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-purple-500/50">
                    <img src="uploads/<?php echo $event['event_image'] ?? 'default.jpg'; ?>" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest block mb-2">Event Poster</label>
                    <input type="file" name="event_image" class="text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-purple-600 file:text-white cursor-pointer">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-2">Event Title</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white outline-none focus:border-purple-500 mt-2">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-2">Event Date</label>
                    <input type="date" name="event_date" value="<?php echo $event['event_date']; ?>" class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white mt-2">
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-2">Start Time</label>
                    <input type="time" name="event_time" value="<?php echo $formatted_time; ?>" class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white mt-2">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="text-[10px] font-black text-blue-400 uppercase tracking-widest ml-2">Regular (SLE)</label>
                    <input type="number" step="0.01" name="price" value="<?php echo $price_reg; ?>" class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white mt-2">
                </div>
                <div>
                    <label class="text-[10px] font-black text-purple-400 uppercase tracking-widest ml-2">VIP (SLE)</label>
                    <input type="number" step="0.01" name="price_vip" value="<?php echo $price_vip; ?>" class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white mt-2">
                </div>
                <div>
                    <label class="text-[10px] font-black text-yellow-500 uppercase tracking-widest ml-2">VVIP (SLE)</label>
                    <input type="number" step="0.01" name="price_vvip" value="<?php echo $price_vvip; ?>" class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white mt-2">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-2">Venue Location</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white mt-2">
            </div>

            <textarea name="description" rows="4" class="w-full bg-white/5 border border-white/10 rounded-2xl p-4 text-white italic"><?php echo htmlspecialchars($event['description']); ?></textarea>

            <div class="flex gap-4 pt-4">
                <button type="submit" name="update_event" class="flex-1 bg-green-600 hover:bg-green-500 text-white font-black uppercase text-xs p-5 rounded-2xl transition shadow-lg shadow-green-500/20">Save All Changes</button>
                <a href="manage_events.php" class="flex-1 bg-white/5 text-center text-gray-400 font-black uppercase text-xs p-5 rounded-2xl border border-white/10">Cancel</a>
            </div>
        </form>
    </div>
</div>