<?php
/**
 * PartyPass SL - Core Configuration
 * Database: partypass_sl
 */

// 1. Start the session securely
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    session_start();
}

// 2. Set Timezone for Sierra Leone
date_default_timezone_set('Africa/Freetown');

// 3. Database Connection Details
$host = 'localhost';
$db   = 'partypass_sl';
$user = 'root'; 
$pass = '';    
$charset = 'utf8mb4';

// 4. Set up the PDO Connection
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     // Ensure MySQL session also uses the correct timezone
     $pdo->exec("SET time_zone = '+00:00'"); 
} catch (\PDOException $e) {
     error_log($e->getMessage());
     die("Database connection failed. Please ensure XAMPP MySQL is running.");
}

// 5. Global Constants
define('PLATFORM_SECRET', 'SL_PRTY_2026_#!'); 
define('ADMIN_MASTER_KEY', 'E1d2w3@4r5@6'); 

/**
 * HELPER: Database Reset Function
 */
function reset_system($pdo) {
    try {
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $tables = ['event_prices', 'equipment', 'payments', 'tickets', 'events', 'organizers', 'users'];
        foreach ($tables as $table) {
            $pdo->exec("TRUNCATE TABLE `$table` ");
        }
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>