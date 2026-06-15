<?php 
include 'db_config.php'; 
include 'header.php'; 
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Only let logged-in users access
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$user_id = $_SESSION['user_id'];

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_venue'])) {
    $name = $_POST['venue_name'];
    $loc = $_POST['location'];
    $cap = $_POST['capacity'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO venues (owner_id, venue_name, location, capacity, price_per_night, description) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $name, $loc, $cap, $price, $desc])) {
        echo "<script>alert('Venue Listed Successfully!'); window.location='venue_dashboard.php';</script>";
    }
}
?>

<div class="p-8 max-w-4xl mx-auto">
    <div class="glass p-10 rounded-[40px] border border-white/10">
        <h2 class="text-3xl font-black text-white uppercase italic mb-2">List Your <span class="text-purple-500">Space</span></h2>
        <p class="text-gray-400 mb-8 text-sm">Earn money by hosting events at your venue.</p>

        <form method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-[10px] font-black uppercase text-purple-400 ml-2">Venue Name</label>
                    <input type="text" name="venue_name" required class="w-full bg-white/5 border border-white/10 p-4 rounded-2xl text-white focus:border-purple-500 outline-none transition" placeholder="e.g. Blue Lagoon Garden">
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-purple-400 ml-2">Location</label>
                    <input type="text" name="location" required class="w-full bg-white/5 border border-white/10 p-4 rounded-2xl text-white focus:border-purple-500 outline-none transition" placeholder="e.g. Lumley, Freetown">
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-purple-400 ml-2">Max Capacity</label>
                    <input type="number" name="capacity" required class="w-full bg-white/5 border border-white/10 p-4 rounded-2xl text-white focus:border-purple-500 outline-none transition" placeholder="e.g. 500">
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-purple-400 ml-2">Price per Night (SLE)</label>
                    <input type="number" name="price" required class="w-full bg-white/5 border border-white/10 p-4 rounded-2xl text-white focus:border-purple-500 outline-none transition" placeholder="e.g. 5000">
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black uppercase text-purple-400 ml-2">Description</label>
                <textarea name="description" rows="4" class="w-full bg-white/5 border border-white/10 p-4 rounded-2xl text-white focus:border-purple-500 outline-none transition" placeholder="Describe facilities (AC, Parking, Security...)"></textarea>
            </div>

            <button type="submit" name="add_venue" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-black py-5 rounded-2xl uppercase tracking-widest shadow-lg shadow-purple-500/20 transition-all">
                Publish Venue Listing
            </button>
        </form>
    </div>
</div>