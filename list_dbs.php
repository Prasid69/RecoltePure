<?php
$conn = new mysqli('localhost', 'root', '');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SHOW DATABASES");
while ($row = $result->fetch_row()) {
    echo $row[0] . "\n";
}
?>