<?php
session_start();
// If they are already logged in, send them straight to their dashboard
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'organizer') {
        header("Location: admin_dashboard.php"); // Existing file
    } else {
        header("Location: dashboard.php"); // Existing file
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PartyPass SL | Elite Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #000; }
        .hero-glow {
            background: radial-gradient(circle at 50% 50%, #9333ea22 0%, #000000 70%);
        }
        .nav-glass {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="text-white">

    <header class="nav-glass fixed top-0 w-full z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center p-5">
            <h1 class="text-2xl font-black italic tracking-tighter text-purple-500">PARTYPASS SL</h1>
            <div class="flex items-center space-x-6">
                <a href="login.php" class="text-sm font-bold uppercase tracking-widest hover:text-purple-400 transition">Log-in</a>
                <a href="register.php" class="bg-purple-600 hover:bg-purple-700 px-6 py-2 rounded-xl text-sm font-black uppercase tracking-widest transition">Sign-up</a>
            </div>
        </div>
    </header>

    <section class="hero-glow min-h-screen flex flex-col justify-center items-center text-center px-6 pt-20">
        <div class="max-w-4xl">
            <span class="inline-block px-4 py-1 border border-purple-500/30 rounded-full text-purple-400 text-[10px] font-black uppercase tracking-[0.3em] mb-6">
                Sierra Leone's #1 Event Platform
            </span>
            <h2 class="text-6xl md:text-8xl font-black italic uppercase tracking-tighter leading-none mb-8">
                The City <br><span class="text-purple-600">In Your Pocket</span>
            </h2>
            <p class="text-gray-400 text-lg md:text-xl font-medium mb-12 max-w-2xl mx-auto leading-relaxed">
                Unlock exclusive events, secure digital tickets, and experience the ultimate nightlife with the only pass you'll ever need.
            </p>
            
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="login.php" class="bg-white text-black px-10 py-5 rounded-2xl font-black uppercase tracking-widest text-xs hover:scale-105 transition-transform shadow-2xl shadow-purple-500/20">
                    Login to Start Purchasing
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-32 max-w-6xl w-full">
            <div class="bg-white/5 p-8 rounded-[40px] border border-white/10 hover:border-purple-500/50 transition-colors">
                <div class="w-12 h-12 bg-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-600/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
                <h3 class="text-xl font-black uppercase italic italic">Instant Passes</h3>
                <p class="text-gray-500 text-sm mt-3 leading-relaxed font-medium">No more waiting. Get your digital pass with a local QR code instantly after purchase.</p>
            </div>

            <div class="bg-white/5 p-8 rounded-[40px] border border-white/10 hover:border-purple-500/50 transition-colors">
                <div class="w-12 h-12 bg-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-600/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-xl font-black uppercase italic">Safe Entry</h3>
                <p class="text-gray-500 text-sm mt-3 leading-relaxed font-medium">Organizers verify every pass. You stay safe, the party stays exclusive.</p>
            </div>

            <div class="bg-white/5 p-8 rounded-[40px] border border-white/10 hover:border-purple-500/50 transition-colors">
                <div class="w-12 h-12 bg-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-600/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-xl font-black uppercase italic">Flash Sales</h3>
                <p class="text-gray-500 text-sm mt-3 leading-relaxed font-medium">Be the first to know about early bird tickets and flash discounts for the hottest events.</p>
            </div>
        </div>
    </section>

    <footer class="p-10 text-center text-gray-600 text-[10px] font-black uppercase tracking-[0.5em]">
        &copy; 2026 PARTYPASS SL. All Rights Reserved.
    </footer>

</body>
</html>