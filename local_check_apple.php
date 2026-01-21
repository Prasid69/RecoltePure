<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "recoltepure";

$db = new mysqli($servername, $username, $password, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$sql = "SELECT product_id, product_name, image, price, description FROM products WHERE product_name LIKE '%Apple%'";
$result = $db->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['product_id'] . "\n";
        echo "Name: " . $row['product_name'] . "\n";
        echo "Image: " . $row['image'] . "\n";
        echo "Price: " . $row['price'] . "\n";
        echo "Description: " . $row['description'] . "\n";
        echo "-----------------------------------\n";
    }
} else {
    echo "Error: " . $db->error;
}
?>