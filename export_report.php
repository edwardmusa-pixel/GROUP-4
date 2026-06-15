<?php
include 'db_config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Security Check: Only organizers can export
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 2) {
    die("Unauthorized access.");
}

$organizer_id = $_SESSION['user_id'];
// Optional: Filter by specific event if ID is passed
$event_id = $_GET['event_id'] ?? null;

// Set headers to force download as CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=PartyPass_GuestList_' . date('Y-m-d') . '.csv');

$output = fopen('php://output', 'w');

// Set the column headings
fputcsv($output, ['Guest Name', 'Ticket Code', 'Event Title', 'Scan Time', 'Status']);

try {
    // FIX: Using u.* to avoid "Column not found" errors seen in screenshots
    $query = "
        SELECT u.*, t.ticket_code, e.title, t.scanned_at, t.status 
        FROM tickets t
        JOIN events e ON t.event_id = e.event_id
        JOIN users u ON t.user_id = u.user_id
        WHERE e.organizer_id = ?
    ";
    
    // If an event_id was provided from the Manage Events page, filter by it
    if ($event_id) {
        $query .= " AND e.event_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$organizer_id, $event_id]);
    } else {
        $stmt = $pdo->prepare($query);
        $stmt->execute([$organizer_id]);
    }

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Fallback detection for the Name column
        $guestName = $row['name'] ?? $row['username'] ?? $row['full_name'] ?? 'Unknown';
        
        // Format the date for the CSV
        $scanTime = $row['scanned_at'] ? date('Y-m-d H:i:s', strtotime($row['scanned_at'])) : 'Not Scanned';
        
        // Prepare the row for the CSV file
        $csvRow = [
            $guestName,
            $row['ticket_code'],
            $row['title'],
            $scanTime,
            strtoupper($row['status'] ?: 'ACTIVE')
        ];
        
        fputcsv($output, $csvRow);
    }
} catch (PDOException $e) {
    // If it fails, the error will be written inside the CSV file for debugging
    fputcsv($output, ['Error', $e->getMessage()]);
}

fclose($output);
exit();
?>