<?php 
include 'db_config.php'; 
include 'header.php'; 

if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$user_id = $_SESSION['user_id'];
$role_id = $_SESSION['role_id']; // 1 for Attendee, 2 for Organizer

// Fetch user data with fallback name detection
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$name = $user['name'] ?? $user['username'] ?? $user['full_name'] ?? 'User';
$is_verified = $user['is_verified'] ?? 0;
?>

<div class="p-8 max-w-2xl mx-auto">
    <div class="mb-8">
        <a href="dashboard.php" class="text-gray-400 text-xs font-bold uppercase hover:text-white transition">← Dashboard</a>
    </div>

    <div class="glass p-10 rounded-[40px] border border-white/10 relative overflow-hidden">
        
        <?php if($role_id == 2): ?>
        <div class="absolute top-8 right-8">
            <?php if($is_verified == 1): ?>
                <span class="bg-green-500/20 text-green-400 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-green-500/30 shadow-lg shadow-green-500/20">✓ Verified Organizer</span>
            <?php else: ?>
                <span class="bg-yellow-500/20 text-yellow-400 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-yellow-500/30">Pending Verification</span>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <h1 class="text-4xl font-black text-white italic uppercase tracking-tighter mb-2">
            Account <span class="text-purple-500">Settings</span>
        </h1>
        <p class="text-gray-400 text-sm mb-10">
            Logged in as: <span class="text-white font-bold uppercase text-[10px]"><?php echo ($role_id == 2) ? 'Event Organizer' : 'Attendee'; ?></span>
        </p>

        <div class="space-y-6">
            <div class="bg-white/5 p-6 rounded-3xl border border-white/5">
                <label class="text-[10px] font-black text-purple-400 uppercase tracking-widest block mb-1">Display Name</label>
                <p class="text-white text-xl font-bold"><?php echo htmlspecialchars($name); ?></p>
            </div>

            <div class="bg-white/5 p-6 rounded-3xl border border-white/5">
                <label class="text-[10px] font-black text-purple-400 uppercase tracking-widest block mb-1">Email Address</label>
                <p class="text-white font-medium"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>

            <?php if($role_id == 2 && $is_verified == 0): ?>
                <div class="p-6 rounded-3xl bg-yellow-500/10 border border-yellow-500/20 text-yellow-200 text-xs italic leading-relaxed">
                    <strong>Notice:</strong> Your organizer features are currently locked. An administrator must verify your account before you can create events or scan tickets.
                </div>
            <?php endif; ?>

            <?php if($role_id == 1): ?>
                <div class="p-6 rounded-3xl bg-blue-500/10 border border-blue-500/20 text-blue-200 text-xs italic">
                    Your tickets are securely stored in your wallet. To change your password, please contact support.
                </div>
            <?php endif; ?>

            <div class="pt-6">
                <a href="logout.php" class="block w-full text-center py-4 bg-red-500/10 hover:bg-red-500/20 border border-red-500/30 rounded-2xl text-red-500 text-xs font-black uppercase tracking-widest transition">
                    Logout of PartyPass
                </a>
            </div>
        </div>
    </div>
</div>