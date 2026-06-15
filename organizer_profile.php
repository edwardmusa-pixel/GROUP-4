<?php 
include 'db_config.php'; 
include 'header.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current organizer profile data
$stmt = $pdo->prepare("SELECT u.full_name, u.email, o.company_name, o.business_address, o.bio 
                       FROM users u 
                       JOIN organizers o ON u.user_id = o.organizer_id 
                       WHERE u.user_id = ?");
$stmt->execute([$user_id]);
$profile = $stmt->fetch();
?>

<div class="p-8 max-w-4xl mx-auto">
    <div class="glass p-10 shadow-2xl">
        <h2 class="text-3xl font-extrabold mb-6">Business Profile</h2>
        
        <form action="profile_handler.php" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs uppercase font-bold text-purple-400 mb-2">Full Name (Private)</label>
                    <input type="text" value="<?php echo htmlspecialchars($profile['full_name']); ?>" class="glass-input w-full p-4 rounded-xl opacity-70" readonly>
                </div>
                <div>
                    <label class="block text-xs uppercase font-bold text-purple-400 mb-2">Company / Stage Name</label>
                    <input type="text" name="company_name" value="<?php echo htmlspecialchars($profile['company_name']); ?>" class="glass-input w-full p-4 rounded-xl" required>
                </div>
            </div>

            <div>
                <label class="block text-xs uppercase font-bold text-purple-400 mb-2">Business Address</label>
                <input type="text" name="address" value="<?php echo htmlspecialchars($profile['business_address']); ?>" class="glass-input w-full p-4 rounded-xl" placeholder="e.g. Wilkinson Road, Freetown">
            </div>

            <div>
                <label class="block text-xs uppercase font-bold text-purple-400 mb-2">Organizer Bio</label>
                <textarea name="bio" rows="4" class="glass-input w-full p-4 rounded-xl"><?php echo htmlspecialchars($profile['bio']); ?></textarea>
            </div>

            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-black py-4 rounded-xl transition uppercase tracking-widest">
                Update Profile
            </button>
        </form>
    </div>
</div>