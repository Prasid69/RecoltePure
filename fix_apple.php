<?php
require_once 'config/db_connection.php';

echo "<h1>Fixing Apple Products</h1>";

// 1. Check for duplicate Apples
$sql = "SELECT * FROM products WHERE product_name LIKE '%Apple%'";
$result = $db->query($sql);
$apples = $result->fetch_all(MYSQLI_ASSOC);

echo "<pre>";
print_r($apples);
echo "</pre>";

if (count($apples) > 1) {
    echo "<p>Found " . count($apples) . " Apple products. Cleaning up...</p>";

    foreach ($apples as $apple) {
        // If it's the specific dummy ID 1 with no image, delete it
        if ($apple['product_id'] == 1 && empty($apple['image'])) {
            $del = $db->query("DELETE FROM products WHERE product_id = 1");
            echo ($del) ? "<p style='color:green'>Deleted dummy product ID 1</p>" : "<p style='color:red'>Failed to delete ID 1</p>";
        } else {
            // For other Apples, check image
            if (empty($apple['image']) || $apple['image'] == 'a.png') {
                // Update to the known good image
                $newImage = '1765527729_apple.png';
                $id = $apple['product_id'];
                $upd = $db->query("UPDATE products SET image = '$newImage' WHERE product_id = $id");
                echo ($upd) ? "<p style='color:green'>Updated image for Product ID $id to $newImage</p>" : "<p style='color:red'>Failed to update ID $id</p>";
            } else {
                echo "<p>Product ID " . $apple['product_id'] . " seems fine (Image: " . $apple['image'] . ")</p>";
            }
        }
    }
} else {
    echo "<p>No duplicates found (or only 1 Apple exists).</p>";
    if (count($apples) == 1 && empty($apples[0]['image'])) {
        $id = $apples[0]['product_id'];
        $newImage = '1765527729_apple.png';
        $db->query("UPDATE products SET image = '$newImage' WHERE product_id = $id");
        echo "<p style='color:green'>Fixed missing image for the single Apple product.</p>";
    }
}

echo "<p>Done.</p>";
?>