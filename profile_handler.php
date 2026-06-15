<?php
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $company = $_POST['company_name'];
    $address = $_POST['address'];
    $bio = $_POST['bio'];

    try {
        $stmt = $pdo->prepare("UPDATE organizers SET company_name = ?, business_address = ?, bio = ? WHERE organizer_id = ?");
        $stmt->execute([$company, $address, $bio, $user_id]);
        
        header("Location: dashboard.php?msg=Profile updated successfully");
    } catch (PDOException $e) {
        die("Error updating profile: " . $e->getMessage());
    }
}
?>