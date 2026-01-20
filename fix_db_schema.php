<?php
require_once 'config/db_connection.php';

echo "<h1>Applying Database Schema Fixes</h1>";

// Array of SQL commands to run
$commands = [
    // 1. Fix: Ensure customer_id is AUTO_INCREMENT
    "ALTER TABLE users MODIFY customer_id INT(11) NOT NULL AUTO_INCREMENT",

    // 2. Fix: Make phone_number NULLABLE because it is not collected during registration
    "ALTER TABLE users MODIFY phone_number INT(10) NULL DEFAULT NULL",

    // 3. Fix: Add missing payment columns to order_or_cart table (required for Stripe orders)
    "ALTER TABLE order_or_cart ADD COLUMN IF NOT EXISTS payment_status VARCHAR(50) DEFAULT 'Pending'",
    "ALTER TABLE order_or_cart ADD COLUMN IF NOT EXISTS payment_method VARCHAR(50) DEFAULT NULL",
    "ALTER TABLE order_or_cart ADD COLUMN IF NOT EXISTS transaction_id VARCHAR(255) DEFAULT NULL",
    "ALTER TABLE order_or_cart ADD COLUMN IF NOT EXISTS payment_date DATETIME DEFAULT NULL",
    "ALTER TABLE order_or_cart ADD COLUMN IF NOT EXISTS amount_paid DECIMAL(10,2) DEFAULT 0.00"
];

foreach ($commands as $sql) {
    echo "<p>Executing: <code>$sql</code> ... ";
    if ($db->query($sql)) {
        echo "<span style='color:green'>SUCCESS</span></p>";
    } else {
        echo "<span style='color:red'>ERROR: " . $db->error . "</span></p>";
    }
}

echo "<h3>Done. Try registering again.</h3>";
?>