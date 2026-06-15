<?php
require 'db_config.php';
require 'monime_config.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$user_id = $_SESSION['user_id'];

// Check both role and verification status
$stmt = $conn->prepare("SELECT role, is_verified, available_balance FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// 1. Block anyone who isn't an organizer
if ($user['role'] !== 'organizer') {
    die("Access Denied.");
}

// 2. Block unverified organizers
if ($user['is_verified'] == 0) {
    die("You must be verified to withdraw funds. Please contact support.");
}

// 3. Proceed with Monime Transfer if balance is sufficient
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['amount'])) {
    $requested_amount = (float)$_POST['amount'];
    
    if ($requested_amount > $user['available_balance']) {
        die("Insufficient funds.");
    }

    // Monime API Transfer Code goes here...
}
?>