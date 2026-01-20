<?php
$envUrl = getenv('DATABASE_URL') ?: getenv('MYSQL_URL');

if ($envUrl) {
    // Parse the connection string (e.g. mysql://user:pass@host:port/db)
    $urlParts = parse_url($envUrl);

    $servername = $urlParts['host'] ?? 'localhost';
    $username = $urlParts['user'] ?? 'root';
    $password = $urlParts['pass'] ?? '';
    // Path comes as '/dbname', so we strip the slash
    $database = isset($urlParts['path']) ? ltrim($urlParts['path'], '/') : 'recoltepure';
    $port = $urlParts['port'] ?? 3306;
} else {
    // Fallback to individual variables
    $servername = getenv('DB_HOST') ?: getenv('MYSQLHOST') ?: 'localhost';
    $username = getenv('DB_USER') ?: getenv('MYSQLUSER') ?: 'root';
    $password = getenv('DB_PASS') ?: getenv('MYSQLPASSWORD') ?: '';
    $database = getenv('DB_NAME') ?: getenv('MYSQLDATABASE') ?: 'recoltepure';
    $port = getenv('MYSQLPORT') ?: getenv('DB_PORT') ?: 3306;

    $servername = str_replace('tcp://', '', $servername);
    if (strpos($servername, ':') !== false) {
        list($host, $p) = explode(':', $servername);
        $servername = $host;
        $port = $p;
    }

    // Safety check for HTTP port misconfiguration
    if ($port == 80) {
        $port = 3306;
    }
}

$db = new mysqli($servername, $username, $password, $database, (int) $port);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$db->set_charset("utf8mb4");
?>