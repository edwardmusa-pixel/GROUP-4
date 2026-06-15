<?php
include 'db_config.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    
    // Default time if not provided in your form
    $event_time = $_POST['event_time'] ?? '20:00:00';

    // Ticket Prices
    $price_reg = $_POST['price_reg'] ?? 0;
    $price_vip = $_POST['price_vip'] ?? 0;
    $price_vvip = $_POST['price_vvip'] ?? 0;

    // 1. Handle Poster Upload
    // Check if 'poster' matches your <input name="poster">
    $image_name = 'default.jpg'; 
    if (isset($_FILES['poster']) && $_FILES['poster']['error'] === 0) {
        $upload_dir = 'uploads/';
        
        // Ensure directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_extension = pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION);
        $image_name = time() . "_" . bin2hex(random_bytes(4)) . "." . $file_extension;
        
        if (!move_uploaded_file($_FILES['poster']['tmp_name'], $upload_dir . $image_name)) {
            // If upload fails, fallback to default
            $image_name = 'default.jpg';
        }
    }

    try {
        $pdo->beginTransaction();

        // 2. Insert into 'events' using correct column 'event_image'
        $stmt = $pdo->prepare("INSERT INTO events (title, event_date, event_time, location, description, event_image, organizer_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $event_date, $event_time, $location, $description, $image_name, $user_id]);
        
        $new_event_id = $pdo->lastInsertId();

        // 3. Insert into 'ticket_types'
        $ticket_stmt = $pdo->prepare("INSERT INTO ticket_types (event_id, name, price, quantity_available, total_capacity) VALUES (?, ?, ?, ?, ?)");

        // Add Regular (Required)
        $ticket_stmt->execute([$new_event_id, 'Regular Access', $price_reg, 500, 500]);

        // Add VIP (Optional)
        if ($price_vip > 0) {
            $ticket_stmt->execute([$new_event_id, 'VIP Access', $price_vip, 100, 100]);
        }

        // Add VVIP (Optional)
        if ($price_vvip > 0) {
            $ticket_stmt->execute([$new_event_id, 'VVIP Access', $price_vvip, 50, 50]);
        }

        $pdo->commit();
        header("Location: dashboard.php?success=1");
        exit();
        
    } catch (Exception $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        die("Error creating event: " . $e->getMessage());
    }
}