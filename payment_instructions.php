<?php 
include 'db_config.php';
include 'header.php';

if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Safety: Check if ref exists in URL
if (!isset($_GET['ref'])) {
    header("Location: browse_events.php");
    exit();
}

$ref = $_GET['ref'];

// Fetch payment details using the correct table 'payments' and column 'reference'
$stmt = $pdo->prepare("SELECT * FROM payments WHERE reference = ?");
$stmt->execute([$ref]);
$pay = $stmt->fetch();

// If payment reference is invalid
if (!$pay) {
    die("<div class='text-white p-10 text-center'>Error: Invalid payment reference.</div>");
}
?>

<div class="flex items-center justify-center min-h-screen p-6">
    <div class="glass w-full max-w-xl p-10 rounded-[40px] border border-white/10 shadow-2xl">
        <h2 class="text-3xl font-black text-white uppercase italic mb-2">Complete <span class="text-purple-500">Payment</span></h2>
        <p class="text-gray-400 text-xs uppercase mb-8 tracking-widest">Follow the instructions below to secure your ticket.</p>
        
        <div class="bg-purple-600/20 p-6 rounded-2xl mb-8 border border-purple-500/30">
            <p class="text-gray-300 text-[10px] uppercase font-bold tracking-widest">Total Amount to Pay</p>
            <h3 class="text-4xl font-black text-white">SLE <?php echo number_format($pay['amount'], 2); ?></h3>
            <div class="mt-4 inline-block px-3 py-1 bg-white/10 rounded-lg">
                <p class="text-purple-400 text-xs font-bold">Reference: <span class="text-white"><?php echo $ref; ?></span></p>
            </div>
        </div>

        <div class="space-y-4 mb-8">
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-xs font-black">OM</div>
                    <span class="text-white font-bold">Orange Money</span>
                </div>
                <span class="text-orange-500 font-black tracking-tighter">076-XXX-XXX</span>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-xs font-black">AM</div>
                    <span class="text-white font-bold">Afrimoney</span>
                </div>
                <span class="text-blue-400 font-black tracking-tighter">077-XXX-XXX</span>
            </div>
            
            <p class="text-[9px] text-gray-500 uppercase italic leading-relaxed">
                * Important: Ensure you enter the reference code <strong><?php echo $ref; ?></strong> in the transaction reason/note field so we can verify it faster.
            </p>
        </div>

        <form action="upload_handler.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            <input type="hidden" name="ref" value="<?php echo $ref; ?>">
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-purple-400 uppercase tracking-widest">Upload Proof (Screenshot or Receipt)</label>
                <div class="relative group">
                    <input type="file" name="proof" 
                        class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-purple-600 file:text-white hover:file:bg-purple-700 cursor-pointer bg-white/5 p-4 rounded-2xl border border-dashed border-white/20 group-hover:border-purple-500/50 transition-all" 
                        required>
                </div>
            </div>

            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-black py-5 rounded-2xl uppercase tracking-widest transition-all transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-purple-600/20">
                Submit Proof of Payment
            </button>
        </form>
    </div>
</div>