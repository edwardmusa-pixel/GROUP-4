<?php
include 'db_config.php';
session_start();

// 1. Find your specific email
$email = 'musaedwardsahr@gmail.com';
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user) {
    // 2. Manually set the session as if you logged in
    $_SESSION['user_id']   = $user['user_id'];
    $_SESSION['role_id']   = 1; // Force Admin Role
    $_SESSION['full_name'] = $user['full_name'];

    echo "Login Forced! Redirecting to Admin Nexus...";
    header("Refresh: 2; url=admin_dashboard.php");
} else {
    echo "User not found in database. Please run the SQL insert first.";
}
?>