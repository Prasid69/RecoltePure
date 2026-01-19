<?php
/**
 * Database Connection
 * Uses environment variables from .env file
 */

// Load environment variables
require_once __DIR__ . '/env_loader.php';

// Get database credentials from environment
$servername = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASS') ?: "";
$database = getenv('DB_NAME') ?: "recoltepure";

// Create connection
$db = new mysqli($servername, $username, $password, $database);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Set charset to UTF-8
$db->set_charset("utf8mb4");
?>