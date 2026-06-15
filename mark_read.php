<?php
include 'db_config.php';
session_start();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE notif_id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $_SESSION['user_id']]);
}
header("Location: dashboard.php");
exit();
?>