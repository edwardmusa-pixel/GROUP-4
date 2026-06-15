<?php
session_start();
include 'db_config.php';
include 'monime_config.php';

if (!isset($_SESSION['user_id'])) {
    die("Error: Please log in first.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['event_id'])) {
    $user_id = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];
    $amount = $_POST['amount'];
    $user_email = $_SESSION['user_email'] ?? 'customer@example.com';
    $ticket_code = 'TIX-' . strtoupper(uniqid()); // Generate a unique code

    try {
        // 1. Create the ticket record in YOUR DB first using your specific columns
        $stmt = $pdo->prepare("INSERT INTO tickets (user_id, event_id, ticket_code, status, price_paid, created_at) VALUES (?, ?, ?, 'cancelled', ?, NOW())");
        $stmt->execute([$user_id, $event_id, $ticket_code, $amount]);
        $ticket_id = $pdo->lastInsertId();

        // 2. Format payload for Monime
        $minor_amount = (int)round($amount * 100); 

        $payload = [
            "amount" => ["currency" => "SLE", "value" => $minor_amount],
            "name" => "Ticket Purchase #" . $ticket_id,
            "success_url" => PAYMENT_SUCCESS_URL . "?ticket_id=$ticket_id&event_id=$event_id",
            "cancel_url" => PAYMENT_CANCEL_URL,
            "customer" => ["email" => $user_email],
            "metadata" => ["ticket_id" => (string)$ticket_id, "event_id" => (string)$event_id]
        ];

        // 3. API Call to Monime
        $ch = curl_init(MONIME_API_URL . "/checkout-sessions");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . MONIME_TOKEN,
            "Monime-Space-Id: " . MONIME_SPACE_ID,
            "Content-Type: application/json"
        ]);

        $response = curl_exec($ch);
        $data = json_decode($response, true);
        curl_close($ch);

        if (isset($data['result']['url'])) {
            header("Location: " . $data['result']['url']);
            exit();
        } else {
            echo "Monime Error: " . ($data['messages'][0] ?? "Failed to start session.");
        }
    } catch (Exception $e) {
        die("System Error: " . $e->getMessage());
    }
}
?>