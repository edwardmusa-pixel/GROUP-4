<?php 
include 'db_config.php'; 
include 'header.php'; 

// We keep the header and config, but ensure no "auto-redirect" 
// logic is added here so you can always see the form.
?>

<style>
    html, body {
        margin: 0; padding: 0; min-height: 100vh; width: 100%;
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                    url('bg.jpg') no-repeat center center fixed !important;
        background-size: cover !important;
    }
    .glass-input {
        background: rgba(0, 0, 0, 0.6) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
        backdrop-filter: blur(15px);
        transition: all 0.3s ease;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 40px; border-radius: 40px;
        width: 100%; max-width: 450px;
        margin: 20px;
    }
</style>

<div class="flex items-center justify-center min-h-screen">
    <div class="glass-card">
        <div class="text-center mb-6">
            <h2 class="text-4xl font-extrabold text-white uppercase italic">PartyPass <span class="text-purple-500">SL</span></h2>
            <p class="text-gray-400 mt-2 font-bold uppercase text-[10px] tracking-[0.2em]">Join the Nexus</p>
        </div>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="bg-red-500/20 border border-red-500/50 text-red-200 p-4 rounded-2xl mb-6 text-[10px] font-bold uppercase text-center">
                ⚠️ <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <form action="auth_handler.php" method="POST" class="space-y-4">
            <input type="hidden" name="action" value="register">
            
            <div>
                <label class="block text-[10px] uppercase font-black mb-1 text-purple-400">Full Name</label>
                <input type="text" name="full_name" class="glass-input w-full p-3 rounded-2xl text-sm" placeholder="Kelvin Sesay" required>
            </div>

            <div>
                <label class="block text-[10px] uppercase font-black mb-1 text-purple-400">Email Address</label>
                <input type="email" name="email" class="glass-input w-full p-3 rounded-2xl text-sm" placeholder="name@email.com" required>
            </div>

            <div>
                <label class="block text-[10px] uppercase font-black mb-1 text-purple-400">Phone Number</label>
                <input type="text" name="phone" class="glass-input w-full p-3 rounded-2xl text-sm" placeholder="+232..." required>
            </div>

            <div>
                <label class="block text-[10px] uppercase font-black mb-1 text-purple-400">Account Role</label>
                <select name="role_id" class="glass-input w-full p-3 rounded-2xl text-sm font-bold" required>
                    <option value="2">Attendee (Buy Tickets)</option>
                    <option value="3">Organizer (Host Events)</option>
                </select>
            </div>

            <div class="pt-2 border-t border-white/5">
                <label class="block text-[9px] uppercase font-black text-red-500 italic">Admin Master Key (Optional)</label>
                <input type="password" name="admin_key" class="glass-input w-full p-3 rounded-2xl text-sm" placeholder="••••••••">
            </div>

            <div>
                <label class="block text-[10px] uppercase font-black mb-1 text-purple-400">Security Password</label>
                <input type="password" name="password" class="glass-input w-full p-3 rounded-2xl text-sm" placeholder="••••••••" required>
            </div>

            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-black py-4 rounded-2xl uppercase text-xs tracking-widest mt-2">
                Initialize Account
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-[10px] text-gray-500 uppercase font-black tracking-widest">
                Already registered? <a href="login.php" class="text-white hover:text-purple-400 ml-1">Go to Login</a>
            </p>
        </div>
    </div>
</div>