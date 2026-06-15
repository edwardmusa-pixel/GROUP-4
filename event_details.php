<?php 
include 'db_config.php'; 
include 'header.php'; 

// Use (int) for security
$event_id = (int)$_GET['id'];

// 1. Fetch Event Info - Using the correct column name for the image
$stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
$stmt->execute([$event_id]);
$event = $stmt->fetch();

// 2. Fetch Prices from 'ticket_types' instead of 'event_prices'
$priceStmt = $pdo->prepare("SELECT * FROM ticket_types WHERE event_id = ?");
$priceStmt->execute([$event_id]);
$prices = $priceStmt->fetchAll();

if (!$event) {
    die("<div class='p-20 text-center text-white font-black uppercase tracking-widest'>Event Not Found</div>");
}
?>

<div class="p-8 max-w-6xl mx-auto min-h-screen">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div class="glass p-3 rounded-[40px] border border-white/10 shadow-2xl">
            <img src="uploads/<?php echo htmlspecialchars($event['event_image']); ?>" 
                 class="w-full h-auto rounded-[32px] shadow-2xl object-cover"
                 alt="<?php echo htmlspecialchars($event['title']); ?>">
        </div>

        <div class="flex flex-col">
            <h1 class="text-5xl font-black mb-4 tracking-tighter uppercase italic text-white leading-none">
                <?php echo htmlspecialchars($event['title']); ?>
            </h1>
            
            <div class="flex items-center gap-2 text-purple-400 font-bold mb-8 uppercase tracking-widest text-sm italic">
                <span>📍 <?php echo htmlspecialchars($event['location']); ?></span>
                <span class="text-gray-600">|</span>
                <span>📅 <?php echo date('M d, Y', strtotime($event['event_date'])); ?></span>
            </div>
            
            <div class="bg-white/5 p-8 rounded-[32px] mb-10 border border-white/5 backdrop-blur-md">
                <p class="text-[10px] uppercase font-black text-gray-500 mb-3 tracking-[0.2em]">Description</p>
                <p class="text-gray-300 leading-relaxed italic"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
            </div>

            <h3 class="text-xs font-black uppercase text-white mb-6 tracking-[0.3em] ml-2">Select Your Access</h3>
            
            <div class="space-y-4">
                <?php if (empty($prices)): ?>
                    <p class="text-gray-500 italic text-sm ml-2">No tickets currently available for this event.</p>
                <?php else: ?>
                    <?php foreach($prices as $p): ?>
                        <div class="glass p-6 rounded-[30px] flex justify-between items-center border border-white/5 hover:border-purple-500/40 hover:bg-white/5 transition-all duration-300 group">
                            <div>
                                <span class="block text-[10px] font-black text-purple-500 uppercase tracking-widest mb-1">
                                    <?php echo htmlspecialchars($p['name']); ?>
                                </span>
                                <span class="text-2xl font-black text-white tracking-tighter">
                                    <span class="text-xs text-gray-500 font-medium mr-1">SLE</span><?php echo number_format($p['price'], 2); ?>
                                </span>
                            </div>
                            
                            <a href="checkout.php?event_id=<?php echo $event_id; ?>&price_id=<?php echo $p['ticket_type_id']; ?>" 
                               class="bg-purple-600 text-white text-[10px] font-black px-8 py-4 rounded-2xl uppercase tracking-widest hover:bg-white hover:text-purple-600 transition-all duration-300 shadow-xl shadow-purple-900/20 group-hover:scale-105">
                                Buy Now
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>