<?php
// Database credentials
$servername = "127.0.0.1"; // Replace with your MySQL server hostname
$port = "8889";
$username = "mamp"; // Replace with your MySQL username 
$password = ""; // Replace with your MySQL password 
$dbname = "trekkingtale_db"; // Replace with your MySQL database name

function generate_uuid() {
    if (function_exists('com_create_guid') === true) {
        return trim(com_create_guid(), '{}');
    }

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // Set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // Set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

// Start the session without a custom ID initially
session_start();

// Check if the cookie with the correct name exists
if (isset($_COOKIE['user_id'])) {
    if (session_id() != $_COOKIE['user_id']) {
        session_id($_COOKIE['user_id']); // Set the session ID from the cookie
        session_start(); // Restart the session with the new ID
    }
    $_SESSION['user_id'] = $_COOKIE['user_id']; // Set the session variable
} else {
    $uuid = generate_uuid(); // Generate a unique UUID
    session_id($uuid); // Set the generated UUID as the session ID
    session_start(); // Start the session with the custom session ID
    setcookie("user_id", $uuid, time() + (86400 * 30), "/"); // Set the cookie
    $_SESSION['user_id'] = $uuid; // Set the session variable
}

?>