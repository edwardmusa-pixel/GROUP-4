<?php 
include 'db_config.php'; 
include 'header.php'; 

$stmt = $pdo->query("SELECT * FROM venues WHERE status = 'available' ORDER BY created_at DESC");
$venues = $stmt->fetchAll();
?>

<div class="p-8 max-w-7xl mx-auto">
    <h2 class="text-3xl font-black text-white uppercase italic mb-10">Find a <span class="text-purple-500">Venue</span></h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php foreach($venues as $v): ?>
            <div class="glass group rounded-[35px] overflow-hidden border border-white/5 hover:border-purple-500/50 transition-all duration-500">
                <div class="h-48 bg-gray-800 relative">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-4 left-6">
                        <span class="bg-purple-600 text-[10px] font-black px-3 py-1 rounded-full text-white uppercase">SLE <?php echo number_format($v['price_per_night'], 0); ?> / Night</span>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-1"><?php echo htmlspecialchars($v['venue_name']); ?></h3>
                    <p class="text-gray-400 text-xs mb-4 italic">📍 <?php echo htmlspecialchars($v['location']); ?></p>
                    
                    <div class="flex justify-between items-center py-4 border-t border-white/5">
                        <div class="text-center">
                            <p class="text-[10px] text-gray-500 uppercase font-black">Capacity</p>
                            <p class="text-white font-bold"><?php echo $v['capacity']; ?></p>
                        </div>
                        <a href="venue_details.php?id=<?php echo $v['venue_id']; ?>" class="bg-white/5 hover:bg-white/10 px-6 py-2 rounded-xl text-xs font-black uppercase text-white transition">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>