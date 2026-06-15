<?php
/**
 * Triggers a Monime Payment Request
 * @param float $amount The ticket price
 * @param string $customer_email For receipting
 * @param string $order_id Your internal DB reference
 */
function initiateMonimePayment($amount, $customer_email, $order_id) {
    // Replace with the token you just generated in the Monime Dashboard
    $api_token = "YOUR_MONIME_PERSONAL_ACCESS_TOKEN"; 
    
    // The Monime API Endpoint (Check their latest docs for the /checkout or /payments path)
    $url = "https://api.monime.io/v1/checkout"; 

    $data = [
        "amount" => $amount,
        "currency" => "SLE", // New Leones
        "description" => "Ticket Purchase for Order #" . $order_id,
        "customer_email" => $customer_email,
        "reference" => $order_id,
        "redirect_url" => "https://yourdomain.com/payment_success.php",
        "cancel_url" => "https://yourdomain.com/browse_events.php"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $api_token,
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // If successful, Monime returns a payment_url
    if (isset($result['payment_url'])) {
        return $result['payment_url'];
    } else {
        return false;
    }
}
?>