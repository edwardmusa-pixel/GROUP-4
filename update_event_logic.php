<?php
include 'db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['role_id'] == 2) {
    $event_id    = $_POST['event_id'];
    $title       = $_POST['title'];
    $location    = $_POST['location'];
    $event_date  = $_POST['event_date'];
    $event_time  = $_POST['event_time'];
    $description = $_POST['description'];
    $user_id     = $_SESSION['user_id'];

    // 1. Update the main event info
    $stmt = $pdo->prepare("
        UPDATE events 
        SET title = ?, location = ?, event_date = ?, event_time = ?, description = ? 
        WHERE event_id = ? AND organizer_id = ?
    ");
    $stmt->execute([$title, $location, $event_date, $event_time, $description, $event_id, $user_id]);

    // 2. Update Ticket Categories (Regular, VIP, VVIP)
    if (isset($_POST['category_names']) && isset($_POST['category_prices'])) {
        $names = $_POST['category_names'];
        $prices = $_POST['category_prices'];

        foreach ($names as $index => $cat_name) {
            $cat_price = $prices[$index];

            // Check if this category already exists for this event
            $check_stmt = $pdo->prepare("SELECT category_id FROM ticket_categories WHERE event_id = ? AND category_name = ?");
            $check_stmt->execute([$event_id, $cat_name]);
            $exists = $check_stmt->fetch();

            if ($exists) {
                // Update existing category
                $upd_cat = $pdo->prepare("UPDATE ticket_categories SET price = ? WHERE event_id = ? AND category_name = ?");
                $upd_cat->execute([$cat_price, $event_id, $cat_name]);
            } else {
                // Insert new category if it wasn't there
                $ins_cat = $pdo->prepare("INSERT INTO ticket_categories (event_id, category_name, price) VALUES (?, ?, ?)");
                $ins_cat->execute([$event_id, $cat_name, $cat_price]);
            }
        }
    }

    // 3. Notify Attendees
    $notif_msg = "📢 UPDATE: Details & pricing for '" . $title . "' have been updated!";
    $notif_stmt = $pdo->prepare("
        INSERT INTO notifications (user_id, message)
        SELECT DISTINCT user_id, ? FROM tickets WHERE event_id = ?
    ");
    $notif_stmt->execute([$notif_msg, $event_id]);

    header("Location: manage_events.php?status=updated");
    exit();
}