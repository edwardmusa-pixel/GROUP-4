<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'db_config.php'; 

echo "<h2 style='font-family:sans-serif;'>Admin Account Recovery Nexus</h2>";

try {
    // 1. Target the admin account using your explicit structural design (role_id = 1)
    $stmt = $pdo->query("SELECT user_id, full_name, email, role_id, password_hash FROM users WHERE role_id = 1 LIMIT 1");
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        echo "<div style='font-family:sans-serif; background:#111; color:#fff; padding:20px; margin-bottom:20px; border-radius:15px; border-left: 5px solid #a855f7;'>";
        echo "<h3 style='color:#a855f7; margin-top:0;'>🛡️ Admin Account Located</h3>";
        echo "<strong>Profile Name:</strong> " . htmlspecialchars($admin['full_name']) . "<br>";
        echo "<strong>Login Email:</strong> <span style='color:#a855f7; font-weight:bold;'>" . htmlspecialchars($admin['email']) . "</span><br>";
        echo "<strong>Database User ID:</strong> " . htmlspecialchars($admin['user_id']) . "<br>";
        echo "</div>";

        // 2. Set your custom new password using PASSWORD_DEFAULT (matching your auth_handler)
        $new_password_plain = "admin123"; 
        $new_hash = password_hash($new_password_plain, PASSWORD_DEFAULT); 

        // 3. Update using the correct password_hash column matching your file structure
        $update_stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
        $update_stmt->execute([$new_hash, $admin['user_id']]);

        echo "<div style='font-family:sans-serif; background:#e6f4ea; color:#137333; padding:15px; border-radius:10px;'>";
        echo "<strong>✅ Password Reset Success!</strong><br>";
        echo "Go to your <a href='login.php' style='color:#137333; font-weight:bold;'>Login Page</a> and use these credentials:<br><br>";
        echo "📧 <strong>Email Address:</strong> " . htmlspecialchars($admin['email']) . "<br>";
        echo "🔑 <strong>Password:</strong> " . $new_password_plain . "<br>";
        echo "</div>";
        
    } else {
        echo "<div style='font-family:sans-serif; background:#fce8e6; color:#c5221f; padding:15px; border-radius:10px;'>";
        echo "<strong>❌ No Admin Account Exists Yet</strong><br>";
        echo "No profile with <code>role_id = 1</code> was found in the user ecosystem database. Use your register page to make one.";
        echo "</div>";
    }

} catch (Exception $e) {
    echo "<p style='color:red; font-family:sans-serif;'><strong>System execution error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>