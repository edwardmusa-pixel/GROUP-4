<?php
include 'db_config.php';
session_start();

// Only Admins can run this script
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    die("Unauthorized access.");
}

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if ($id && $action) {
    try {
        if ($action == 'verify') {
            // This updates the status so Tangase can finally log in
            $stmt = $pdo->prepare("UPDATE users SET is_verified = 1 WHERE user_id = ?");
            $stmt->execute([$id]);
            $msg = "Organizer verified successfully!";
        } 
        elseif ($action == 'delete') {
            $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = ?");
            $stmt->execute([$id]);
            $msg = "User removed from system.";
        }

        header("Location: admin_dashboard.php?success=" . urlencode($msg));
        exit();
    } catch (PDOException $e) {
        header("Location: admin_dashboard.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>