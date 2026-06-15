<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// 1. Define pages that should NOT show the navigation header
$excluded_pages = ['login.php', 'register.php', 'verify_organizers.php'];
$current_page = basename($_SERVER['PHP_SELF']);

// 2. Logic for Admin Notification Badge
$pending_count = 0;
if (!in_array($current_page, $excluded_pages)) {
    // Role 1 = Admin
    if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1) {
        if (isset($pdo)) {
            try {
                // Organizers are Role 3 - count those waiting for verification
                $pending_count = $pdo->query("SELECT COUNT(*) FROM users WHERE role_id = 3 AND is_verified = 0")->fetchColumn();
            } catch (Exception $e) { $pending_count = 0; }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PartyPass SL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 100vh;
            margin: 0;
        }
        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 28px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
        }
        .nav-link { position: relative; transition: all 0.3s ease; }
        .nav-link::after {
            content: ''; position: absolute; bottom: -4px; left: 0;
            width: 0; height: 2px; background: #a855f7; transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }
    </style>
</head>
<body>

<?php 
// 3. Only render the <nav> if the current page is NOT in the excluded list
if (!in_array($current_page, $excluded_pages)): 
?>
<nav class="px-6 py-4 mb-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center glass px-8 py-4">
        <a href="dashboard.php" class="text-xl font-black italic tracking-tighter uppercase">
            PartyPass <span class="text-purple-500">SL</span>
        </a>

        <div class="hidden md:flex items-center gap-8">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="nav-link text-[10px] font-black uppercase tracking-widest opacity-70 hover:opacity-100">Home</a>
                
                <?php if($_SESSION['role_id'] == 1): // ADMIN VIEW ?>
                    <a href="admin_dashboard.php" class="relative bg-red-500/10 text-red-500 border border-red-500/20 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all flex items-center gap-2">
                        🛡️ Admin Nexus
                        <?php if($pending_count > 0): ?>
                            <span class="absolute -top-2 -right-2 bg-white text-red-600 w-5 h-5 rounded-full flex items-center justify-center text-[10px] font-bold shadow-lg animate-bounce"><?php echo $pending_count; ?></span>
                        <?php endif; ?>
                    </a>

                <?php elseif($_SESSION['role_id'] == 3): // ORGANIZER VIEW ?>
                    <a href="manage_events.php" class="nav-link text-[10px] font-black uppercase tracking-widest opacity-70 hover:opacity-100">Manage Events</a>
                    <a href="organizer_wallet.php" class="nav-link text-[10px] font-black uppercase tracking-widest opacity-70 hover:opacity-100">Wallet</a>

                <?php elseif($_SESSION['role_id'] == 2): // ATTENDEE VIEW ?>
                    <a href="my_tickets.php" class="nav-link text-[10px] font-black uppercase tracking-widest opacity-70 hover:opacity-100">My Tickets</a>
                <?php endif; ?>

                <div class="h-4 w-[1px] bg-white/10 mx-2"></div>
                
                <a href="profile.php" class="text-[10px] font-black uppercase tracking-widest opacity-70 hover:opacity-100">Account</a>
                
                <a href="logout.php" class="text-gray-500 hover:text-red-400 text-[10px] font-black uppercase tracking-widest transition">Logout</a>
            
            <?php else: ?>
                <a href="login.php" class="text-[10px] font-black uppercase tracking-widest opacity-70">Login</a>
                <a href="register.php" class="bg-white/10 px-5 py-2 rounded-xl text-[10px] font-black uppercase hover:bg-white/20 transition">Join Now</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php endif; ?>