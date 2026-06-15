<?php 
include 'db_config.php'; 
include 'header.php'; 

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$ticket_id = $_GET['id'];
$stmt = $pdo->prepare("
    SELECT t.*, e.title, e.event_date, e.location, ep.ticket_type 
    FROM tickets t
    JOIN events e ON t.event_id = e.event_id
    JOIN event_prices ep ON t.price_id = ep.price_id
    WHERE t.ticket_id = ? AND t.user_id = ?
");
$stmt->execute([$ticket_id, $_SESSION['user_id']]);
$ticket = $stmt->fetch();

if (!$ticket) { die("Ticket not found."); }
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<div class="p-8 max-w-md mx-auto">
    <div class="flex items-center justify-between mb-6">
        <a href="dashboard.php" class="flex items-center text-white/70 hover:text-white transition group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="text-[10px] font-black uppercase tracking-widest text-white">Dashboard</span>
        </a>
    </div>

    <div id="ticket-card" class="bg-white text-black rounded-3xl overflow-hidden shadow-2xl">
        <div class="bg-purple-600 p-6 text-white text-center">
            <h2 class="text-2xl font-black italic tracking-tighter text-white">PartyPass SL</h2>
            <p class="text-[10px] uppercase tracking-widest opacity-80 font-bold text-white">Official Entry Pass</p>
        </div>
        
        <div class="p-8 border-b-2 border-dashed border-gray-200 relative">
            <div class="absolute -left-3 -bottom-3 w-6 h-6 bg-black rounded-full"></div>
            <div class="absolute -right-3 -bottom-3 w-6 h-6 bg-black rounded-full"></div>
            
            <h3 class="text-xl font-bold mb-1 tracking-tight"><?php echo htmlspecialchars($ticket['title']); ?></h3>
            <p class="text-gray-500 text-xs mb-6 font-medium italic">📍 <?php echo htmlspecialchars($ticket['location']); ?></p>
            
            <div class="flex justify-between">
                <div>
                    <p class="text-[9px] uppercase font-black text-gray-400 tracking-tighter">Event Date</p>
                    <p class="font-bold text-sm"><?php echo date('M d, Y', strtotime($ticket['event_date'])); ?></p>
                </div>
                <div class="text-right">
                    <p class="text-[9px] uppercase font-black text-gray-400 tracking-tighter">Access</p>
                    <p class="font-bold text-sm text-purple-600 uppercase"><?php echo htmlspecialchars($ticket['ticket_type']); ?></p>
                </div>
            </div>
        </div>

        <div class="p-8 text-center bg-gray-50 flex flex-col items-center">
            <div id="qrcode" class="bg-white p-4 inline-block rounded-2xl shadow-sm border border-gray-100 mb-4"></div>
            
            <p class="text-[10px] font-mono text-gray-400 font-bold tracking-widest uppercase">
                <?php echo htmlspecialchars($ticket['ticket_code']); ?>
            </p>
        </div>
    </div>
    
    <button id="save-btn" onclick="saveTicketImage()" class="w-full mt-6 bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 rounded-2xl transition shadow-lg flex items-center justify-center space-x-2">
        <span id="btn-text" class="text-xs uppercase tracking-widest">Save to Gallery (Image)</span>
    </button>
</div>

<script>
// 1. Generate QR Code Client-Side
const qrcode = new QRCode(document.getElementById("qrcode"), {
    text: "<?php echo $ticket['ticket_code']; ?>",
    width: 200,
    height: 200,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
});

// 2. Function to Save as Image
function saveTicketImage() {
    const ticket = document.getElementById('ticket-card');
    const btnText = document.getElementById('btn-text');

    btnText.innerText = "Processing Image...";

    html2canvas(ticket, {
        scale: 3,
        backgroundColor: "#000000",
        logging: false,
        useCORS: true
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'PartyPass-<?php echo $ticket['ticket_code']; ?>.png';
        link.href = canvas.toDataURL("image/png");
        link.click();
        
        btnText.innerText = "Save to Gallery (Image)";
    });
}
</script>