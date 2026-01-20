<?php
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$database = getenv('DB_NAME') ?: 'recoltepure';
$port = getenv('DB_PORT') ?: getenv('MYSQLPORT') ?: 3306;

$db = new mysqli($servername, $username, $password, $database, (int) $port);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$db->set_charset("utf8mb4");
?>