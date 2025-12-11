<?php
// db_connection.php - Make sure your file looks similar to this

// Database configuration
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password (empty)
$database = "recoltepure"; // Your database name

// Create connection
$db = new mysqli($servername, $username, $password, $database);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Set charset to utf8mb4 (important for special characters)
$db->set_charset("utf8mb4");

// Optional: Display success message (remove in production)
// echo "Connected successfully";
?>