<?php
// Load environment helper and use it for DB credentials
require_once __DIR__ . '/env.php';

$servername = env('DB_HOST', 'localhost');
$username   = env('DB_USER', 'root');
$password   = env('DB_PASS', '');
$database   = env('DB_NAME', 'recoltepure');

$db = new mysqli($servername, $username, $password, $database);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$db->set_charset("utf8mb4");
?>