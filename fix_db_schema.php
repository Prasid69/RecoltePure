<?php
require_once 'config/db_connection.php';

echo "<h1>Applying Database Schema Fixes</h1>";

// Function to safely run a query
function runQuery($db, $sql, $description)
{
    echo "<p>$description ... ";
    try {
        if ($db->query($sql)) {
            echo "<span style='color:green'>SUCCESS</span></p>";
        } else {
            // Ignore "Duplicate column" or similar harmless errors if possible, otherwise print
            echo "<span style='color:orange'>Info: " . $db->error . "</span></p>";
        }
    } catch (Exception $e) {
        echo "<span style='color:red'>Exception: " . $e->getMessage() . "</span></p>";
    }
}

// 1. Fix Users Table
runQuery($db, "ALTER TABLE users MODIFY customer_id INT(11) NOT NULL AUTO_INCREMENT", "Fixing customer_id AUTO_INCREMENT");
runQuery($db, "ALTER TABLE users MODIFY phone_number INT(10) NULL DEFAULT NULL", "Fixing phone_number NULLABLE");

// 1b. Fix Order Cart Table
runQuery($db, "ALTER TABLE order_or_cart MODIFY order_cart_id INT(11) NOT NULL AUTO_INCREMENT", "Fixing order_cart_id AUTO_INCREMENT");

// 2. Add Missing Payment Columns to order_or_cart
$columnsToAdd = [
    'payment_status' => "VARCHAR(50) DEFAULT 'Pending'",
    'payment_method' => "VARCHAR(50) DEFAULT NULL",
    'transaction_id' => "VARCHAR(255) DEFAULT NULL",
    'payment_date' => "DATETIME DEFAULT NULL",
    'amount_paid' => "DECIMAL(10,2) DEFAULT 0.00"
];

foreach ($columnsToAdd as $col => $def) {
    echo "<p>Checking column <code>$col</code> ... ";
    $checkResult = $db->query("SHOW COLUMNS FROM order_or_cart LIKE '$col'");

    if ($checkResult && $checkResult->num_rows > 0) {
        echo "<span style='color:blue'>Already Exists</span></p>";
    } else {
        $sql = "ALTER TABLE order_or_cart ADD COLUMN $col $def";
        runQuery($db, $sql, "Adding column $col");
    }
}

echo "<h3>Current Table Structure (order_or_cart):</h3>";
echo "<pre>";
$result = $db->query("DESCRIBE order_or_cart");
while ($row = $result->fetch_assoc()) {
    print_r($row);
}
echo "</pre>";

echo "<h3>Done. Try registering and ordering again.</h3>";
?>