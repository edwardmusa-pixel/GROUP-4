<?php 
include 'db_config.php'; 
include 'header.php'; 

if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Access control: Only Role 3 (Organizers) allowed
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 3) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<div class="p-8 max-w-7xl mx-auto min-h-screen">
    <div class="mb-8">
        <a href="dashboard.php" class="inline-flex items-center gap-2 px-5 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-white text-xs font-bold uppercase transition group">
            <span class="group-hover:-translate-x-1 transition-transform">←</span> 
            Back to Dashboard
        </a>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-4xl font-black text-white italic tracking-tighter uppercase">Event <span class="text-purple-500">Command</span></h1>
            <p class="text-gray-400 text-sm mt-1 font-medium italic">Monitor real-time check-ins and manage your ticket inventory.</p>
        </div>
        <a href="create_event.php" class="bg-purple-600 hover:bg-purple-500 text-white px-8 py-3 rounded-2xl font-bold text-xs uppercase transition shadow-lg shadow-purple-500/20">
            Create New Event
        </a>
    </div>

    <div class="grid grid-cols-1 gap-8">
        <?php
        try {
            $stmt = $pdo->prepare("
                SELECT e.*, 
                (SELECT COUNT(*) FROM tickets WHERE event_id = e.event_id) as sold,
                (SELECT COUNT(*) FROM tickets WHERE event_id = e.event_id AND status = 'used') as checked_in,
                (SELECT SUM(COALESCE(price_paid, 0)) FROM tickets WHERE event_id = e.event_id) as total_revenue
                FROM events e WHERE e.organizer_id = ? 
                ORDER BY e.event_date DESC
            ");
            $stmt->execute([$user_id]);
            $events = $stmt->fetchAll();

            if ($events):
                foreach ($events as $event): 
                    $sold = $event['sold'] ?? 0;
                    $checked = $event['checked_in'] ?? 0;
                    $revenue = $event['total_revenue'] ?? 0;
                    $percent = ($sold > 0) ? round(($checked / $sold) * 100) : 0;
                    
                    $event_date = date('Y-m-d', strtotime($event['event_date']));
                    $is_today = ($event_date == date('Y-m-d'));
            ?>
                <div class="glass p-8 rounded-[40px] border border-white/10 flex flex-col lg:flex-row justify-between items-center gap-8 group hover:border-purple-500/30 transition-all duration-500 relative overflow-hidden">
                    
                    <div class="flex-1 w-full">
                        <div class="flex items-center gap-3 mb-2">
                            <?php if($is_today): ?>
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-[9px] font-black uppercase tracking-widest animate-pulse border border-green-500/30">Live Now</span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-white/5 text-gray-500 rounded-full text-[9px] font-black uppercase tracking-widest border border-white/5">Upcoming</span>
                            <?php endif; ?>
                            <h2 class="text-2xl font-black text-white italic"><?php echo htmlspecialchars($event['title']); ?></h2>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-y-2 gap-x-4 text-gray-400 text-xs font-bold uppercase tracking-wide">
                            <span class="flex items-center gap-1 text-purple-400"><span class="text-sm">📍</span> <?php echo htmlspecialchars($event['location']); ?></span>
                            <span class="flex items-center gap-1"><span class="text-sm">📅</span> <?php echo date('M d, Y', strtotime($event['event_date'])); ?></span>
                            <span class="flex items-center gap-1"><span class="text-sm">⏰</span> <?php echo date('h:i A', strtotime($event['event_time'] ?? '20:00:00')); ?></span>
                            <span class="flex items-center gap-1 text-green-400"><span class="text-sm">💰</span> <?php echo number_format($event['price'], 2); ?> SLE</span>
                        </div>

                        <div class="mt-6">
                            <div class="flex justify-between mb-2">
                                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Arrival Rate</p>
                                <p class="text-[10px] font-black text-white uppercase"><?php echo $percent; ?>% Checked In</p>
                            </div>
                            <div class="w-full bg-white/5 h-2 rounded-full overflow-hidden p-[1px]">
                                <div class="bg-gradient-to-r from-purple-600 to-blue-500 h-full rounded-full transition-all duration-1000" style="width: <?php echo $percent; ?>%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 w-full lg:w-auto">
                        <div class="bg-white/5 p-4 rounded-3xl text-center border border-white/5">
                            <p class="text-[8px] font-black text-gray-500 uppercase tracking-widest mb-1">Sold</p>
                            <p class="text-xl font-black text-white"><?php echo $sold; ?></p>
                        </div>
                        <div class="bg-white/5 p-4 rounded-3xl text-center border border-white/5">
                            <p class="text-[8px] font-black text-gray-500 uppercase tracking-widest mb-1">In House</p>
                            <p class="text-xl font-black text-green-400"><?php echo $checked; ?></p>
                        </div>
                        <div class="bg-purple-500/10 p-4 rounded-3xl text-center border border-purple-500/10">
                            <p class="text-[8px] font-black text-purple-400 uppercase tracking-widest mb-1">Revenue</p>
                            <p class="text-xl font-black text-white"><?php echo number_format($revenue, 0); ?></p>
                        </div>
                    </div>

                    <div class="flex lg:flex-col gap-3 w-full lg:w-auto border-t lg:border-t-0 lg:border-l border-white/10 pt-6 lg:pt-0 lg:pl-8">
                        <a href="scanner.php?event_id=<?php echo $event['event_id']; ?>" class="flex-1 lg:w-12 lg:h-12 bg-purple-600 hover:bg-purple-500 text-white rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20 transition-all hover:scale-110" title="Scanner">
                            <span class="text-lg">📱</span>
                        </a>
                        <a href="view_attendees.php?event_id=<?php echo $event['event_id']; ?>" class="flex-1 lg:w-12 lg:h-12 bg-white/5 hover:bg-blue-500/20 text-blue-400 rounded-xl border border-white/10 flex items-center justify-center transition-all hover:scale-110" title="Guest List">
                            <span class="text-lg">👥</span>
                        </a>
                        <a href="edit_event.php?event_id=<?php echo $event['event_id']; ?>" class="flex-1 lg:w-12 lg:h-12 bg-white/5 hover:bg-white/10 text-white rounded-xl border border-white/10 flex items-center justify-center transition-all hover:scale-110" title="Edit Event">
                            <span class="text-lg">⚙️</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; 
            else: ?>
                <div class="glass p-20 rounded-[40px] text-center border border-dashed border-white/10">
                    <p class="text-gray-500 font-medium italic uppercase tracking-widest text-xs">No events found. Start by creating one!</p>
                </div>
            <?php endif;
        } catch (PDOException $e) {
            echo "<div class='glass p-6 text-red-400 text-xs italic uppercase'>System Error. Ensure database columns 'price_paid' and 'scanned_at' exist.</div>";
        }
        ?>
    </div>
</div>