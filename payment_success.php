<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'db_config.php';

$ticket_id = $_GET['ticket_id'] ?? null;
$success = false;

if ($ticket_id) {
    // 1. Fetch ticket and EVERY user detail (including role_id)
    $stmt = $pdo->prepare("SELECT t.*, u.user_id, u.email, u.role_id 
                           FROM tickets t 
                           JOIN users u ON t.user_id = u.user_id 
                           WHERE t.ticket_id = ?");
    $stmt->execute([$ticket_id]);
    $data = $stmt->fetch();

    if ($data) {
        // 2. COMPLETE SESSION RECOVERY: Restore everything the header needs
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['user_email'] = $data['email'];
        $_SESSION['role_id'] = $data['role_id']; // FIXES THE "UNDEFINED ROLE_ID" ERROR
        
        // 3. Ensure the ticket is marked valid in the DB
        if ($data['status'] !== 'valid') {
            $pdo->prepare("UPDATE tickets SET status = 'valid' WHERE ticket_id = ?")->execute([$ticket_id]);
        }
        $success = true;
    }
}

include 'header.php'; 
?>

<div class="min-h-screen flex items-center justify-center p-6 bg-black text-white">
    <div class="glass p-12 max-w-md w-full text-center border <?php echo $success ? 'border-green-500/30' : 'border-red-500/30'; ?> rounded-[40px] bg-zinc-900/40 backdrop-blur-2xl">
        <?php if ($success): ?>
            <div class="text-6xl mb-6">🎫</div>
            <h1 class="text-3xl font-black uppercase italic mb-2">SUCCESS!</h1>
            <p class="text-gray-400 text-sm font-bold uppercase mb-10">Session Restored. Ticket #<?php echo $ticket_id; ?> is Ready.</p>
            <a href="my_ticket_view.php?ticket_id=<?php echo $ticket_id; ?>" class="inline-block w-full py-5 bg-green-500 text-black font-black uppercase rounded-2xl hover:scale-105 transition-transform">VIEW MY TICKET</a>
        <?php else: ?>
            <div class="text-6xl mb-6">❌</div>
            <h1 class="text-2xl font-black uppercase italic mb-2">Process Failed</h1>
            <p class="text-red-400 text-xs font-mono p-4 bg-red-500/10 border border-red-500/20 rounded-xl mb-8">No valid ticket reference found.</p>
            <a href="dashboard.php" class="text-gray-500 hover:text-white underline text-xs font-bold uppercase">Back to Dashboard</a>
        <?php endif; ?>
    </div>
</div>