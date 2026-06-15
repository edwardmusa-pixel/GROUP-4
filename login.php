<?php 
include 'db_config.php'; 
include 'header.php'; 
?>

<style>
    /* Force bg.jpg background with full screen coverage */
    html, body {
        margin: 0; 
        padding: 0; 
        min-height: 100vh; 
        width: 100%;
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
                    url('bg.jpg') no-repeat center center fixed !important;
        background-size: cover !important;
        overflow-x: hidden;
    }

    /* Glass container styles */
    .glass {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .glass-input {
        background: rgba(0, 0, 0, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
        backdrop-filter: blur(15px);
        transition: all 0.3s ease;
    }

    .glass-input:focus {
        background: rgba(0, 0, 0, 0.8) !important;
        border-color: #a855f7 !important;
        box-shadow: 0 0 20px rgba(168, 85, 247, 0.4);
        outline: none;
    }

    .glass-input::placeholder {
        color: rgba(255, 255, 255, 0.3) !important;
    }
</style>

<div class="flex items-center justify-center min-h-screen p-6">
    <div class="glass w-full max-w-md p-10 rounded-[40px] shadow-2xl">
        <div class="text-center mb-10">
            <h2 class="text-4xl font-extrabold text-white uppercase italic leading-none">
                PartyPass <span class="text-purple-500">SL</span>
            </h2>
            <p class="text-gray-400 mt-2 font-bold uppercase text-[10px] tracking-[0.3em]">Access the Nexus</p>
        </div>
        
        <?php if (isset($_GET['status']) && $_GET['status'] === 'pending'): ?>
            <div class="bg-green-500/10 border-l-4 border-green-500 p-5 rounded-2xl mb-8 animate-pulse">
                <div class="flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <div>
                        <h4 class="text-white font-black uppercase italic text-[11px] tracking-tight">Request Successfully Made</h4>
                        <p class="text-gray-400 text-[9px] font-bold uppercase tracking-wider mt-1">
                            Awaiting admin approval. Please check back in <span class="text-green-500">12 - 24 hours</span>.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
            <div class="bg-red-500/10 border border-red-500/50 text-red-400 p-4 rounded-2xl mb-6 text-[10px] text-center font-bold uppercase tracking-wider">
                ⚠️ <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="auth_handler.php" method="POST" class="space-y-6">
            <input type="hidden" name="action" value="login">
            
            <div>
                <label class="block text-[10px] uppercase font-black mb-2 ml-1 text-purple-400 tracking-widest">Email Address</label>
                <input type="email" name="email" class="glass-input w-full p-4 rounded-2xl text-sm" placeholder="name@email.com" required>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label class="block text-[10px] uppercase font-black text-purple-400 tracking-widest">Password</label>
                    <a href="forgot_password.php" class="text-[9px] text-gray-500 hover:text-white uppercase font-black tracking-tighter">Forgot?</a>
                </div>
                <input type="password" name="password" class="glass-input w-full p-4 rounded-2xl text-sm" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-black py-5 rounded-2xl shadow-2xl transition duration-300 transform hover:scale-[1.02] mt-4 uppercase text-xs tracking-[0.2em]">
                Sign In
            </button>
        </form>
        
        <div class="mt-10 text-center border-t border-white/5 pt-6">
            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">
                Don't have an account? <a href="register.php" class="text-white hover:text-purple-400 transition-colors ml-1">Register Now</a>
            </p>
        </div>
    </div>
</div>