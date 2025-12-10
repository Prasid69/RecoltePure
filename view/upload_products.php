<?php
session_start();

include "../db_connection.php";

if (!isset($_SESSION['login_user'])) {
    die("You must be logged in to access this page.");
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'farmer') {
    die("You must be logged in as a farmer to upload products.");
}

$user_email = $_SESSION['login_user'];


$get_farmer = "SELECT farmer_id FROM farmer WHERE email = '$user_email' LIMIT 1"; 
$res_farmer = mysqli_query($db, $get_farmer);

if (mysqli_num_rows($res_farmer) == 0) {
    die("Farmer record not found. Please complete your farmer profile.");
}

$row_farmer = mysqli_fetch_assoc($res_farmer);
$farmer_id = $row_farmer['farmer_id'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Panel | Upload Product</title>
    <link rel="stylesheet" href="../assets/css/upload_products.css">
</head>
<body>

<div class="upload-container">
    <h2>Upload New Product</h2>

    <?php if (isset($success)) : ?>
        <div class="alert success" style="color: green;"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (isset($error)) : ?>
        <div class="alert error" style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">

        <label>Product Name</label>
        <input type="text" name="product_name" required>

        <label>Description</label>
        <textarea name="description" rows="4" required></textarea>

        <div class="row">
            <div class="column">
                <label>Price</label>
                <input type="number" step="0.01" name="price" required>
            </div>
            <div class="column">
                <label>Old Price (Optional)</label>
                <input type="number" step="0.01" name="old_price">
            </div>
        </div>

        <label>Stock Quantity</label>
        <input type="number" name="stock_quantity" required>

        <label>Select Category</label>
        <select name="category_id" required>
            <option value="">-- Choose category --</option>
            <?php if($categories && mysqli_num_rows($categories) > 0): ?>
                <?php while($cat = mysqli_fetch_assoc($categories)) : ?>
                    <option value="<?php echo $cat['category_id']; ?>"> <?php echo ucfirst($cat['category_name']); ?>
                    </option>
                <?php endwhile; ?>
            <?php endif; ?>
        </select>

        <label>Upload Product Image</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit" name="upload" class="upload-btn">Upload Product</button>

    </form>
</div>

</body>
</html>