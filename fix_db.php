<?php
require_once 'config/db_connection.php';

echo "<h2>Database Synchronization</h2>";

// 1. Fix farmer table - farmer_id
$sql1 = "ALTER TABLE farmer MODIFY COLUMN farmer_id INT AUTO_INCREMENT PRIMARY KEY";
// If it's already a primary key, we might need a different approach.
// Let's try to just add AUTO_INCREMENT if possible.
// A safer way if PRIMARY KEY exists:
$sql1Safe = "ALTER TABLE farmer MODIFY farmer_id INT AUTO_INCREMENT";

if ($db->query($sql1Safe)) {
    echo "✅ Successfully updated 'farmer' table: farmer_id is now AUTO_INCREMENT.<br>";
} else {
    echo "❌ Error updating 'farmer' table: " . $db->error . "<br>";
    echo "Trying alternative (adding PRIMARY KEY check)...<br>";
    $sql1Alt = "ALTER TABLE farmer MODIFY farmer_id INT AUTO_INCREMENT PRIMARY KEY";
    if ($db->query($sql1Alt)) {
        echo "✅ Successfully updated 'farmer' table with PRIMARY KEY and AUTO_INCREMENT.<br>";
    } else {
        echo "❌ Final error for 'farmer' table: " . $db->error . "<br>";
    }
}

// 2. Fix users table - customer_id
$sql2Safe = "ALTER TABLE users MODIFY customer_id INT AUTO_INCREMENT";
if ($db->query($sql2Safe)) {
    echo "✅ Successfully updated 'users' table: customer_id is now AUTO_INCREMENT.<br>";
} else {
    echo "❌ Error updating 'users' table: " . $db->error . "<br>";
}

// 3. Ensure admins table exists and has correct structure (as seen in AdminModel)
$sql3 = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    email VARCHAR(255) UNIQUE NOT NULL, 
    password_hash VARCHAR(255) NOT NULL, 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)";
if ($db->query($sql3)) {
    echo "✅ 'admins' table check passed.<br>";
} else {
    echo "❌ Error check/creating 'admins' table: " . $db->error . "<br>";
}

// 4. Check for 'password' vs 'password_hash' in farmer table
// The code expects 'password' for farmers and users, but 'password_hash' for admins.
$res = $db->query("SHOW COLUMNS FROM farmer LIKE 'password_hash'");
if ($res && $res->num_rows > 0) {
    echo "Detected 'password_hash' in farmer table. Renaming to 'password'...<br>";
    if ($db->query("ALTER TABLE farmer CHANGE password_hash password VARCHAR(255)")) {
        echo "✅ Successfully renamed 'password_hash' to 'password' in farmer table.<br>";
    } else {
        echo "❌ Error renaming column: " . $db->error . "<br>";
    }
}

echo "<br><p>Database fix complete. Please delete this file after use for security.</p>";
?>