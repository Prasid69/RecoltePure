<?php
$envUrl = getenv('MYSQL_URL') ?: getenv('DATABASE_URL');

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
    // Prioritize MYSQL* variables (Railway standard) over DB_* as DB_HOST might be misconfigured
    $servername = getenv('MYSQLHOST') ?: getenv('DB_HOST') ?: 'localhost';
    $username = getenv('MYSQLUSER') ?: getenv('DB_USER') ?: 'root';
    $password = getenv('MYSQLPASSWORD') ?: getenv('DB_PASS') ?: '';
    $database = getenv('MYSQLDATABASE') ?: getenv('DB_NAME') ?: 'recoltepure';
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