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


$stmt = $db->prepare("SELECT farmer_id FROM farmer WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$res_farmer = $stmt->get_result();

if ($res_farmer->num_rows == 0) {
    die("Farmer record not found. Please complete your farmer profile.");
}

$row_farmer = $res_farmer->fetch_assoc();
$farmer_id = $row_farmer['farmer_id'];


$edit_mode = false;
$product = [];

if (isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
    $edit_mode = true;

    $stmt = $db->prepare("SELECT * FROM products WHERE product_id = ? AND farmer_id = ?");
    $stmt->bind_param("ii", $product_id, $farmer_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 0) {
        die("Product not found or you don't have permission to edit it.");
    }

    $product = $res->fetch_assoc();
}


if (isset($_POST['upload'])) {

    $product_name = mysqli_real_escape_string($db, $_POST['product_name']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $price = (float)$_POST['price'];
    $old_price = !empty($_POST['old_price']) ? (float)$_POST['old_price'] : NULL;
    $stock = (int)$_POST['stock_quantity'];
    $category_id = (int)$_POST['category_id'];

    $file_name = $edit_mode ? $product['image'] : ''; // keep old image for edit

    if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
        $target_dir = "../assets/uploads/products/";
        $file_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $error = "File is not an image.";
        } elseif ($_FILES["image"]["size"] > 5000000) {
            $error = "File is too large.";
        } elseif (!in_array($imageFileType, ['jpg','jpeg','png','gif'])) {
            $error = "Only JPG, JPEG, PNG & GIF allowed.";
        } else {
            if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

            // Delete old image if editing
            if ($edit_mode && $product['image'] != '' && file_exists($target_dir . $product['image'])) {
                unlink($target_dir . $product['image']);
            }
        }
    }

    if (!isset($error)) {
        if ($edit_mode) {
            // Update existing product
            $sql = "UPDATE products SET product_name=?, product_description=?, price=?, old_price=?, stock_quantity=?, category_id=?, image=? WHERE product_id=? AND farmer_id=?";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ssddiiiii", $product_name, $description, $price, $old_price, $stock, $category_id, $file_name, $product_id, $farmer_id);
            $action = "updated";
        } else {
            // Insert new product
            $sql = "INSERT INTO products (product_name, product_description, price, old_price, stock_quantity, category_id, farmer_id, image) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ssddiiis", $product_name, $description, $price, $old_price, $stock, $category_id, $farmer_id, $file_name);
            $action = "uploaded";
        }

        if ($stmt->execute()) {
            $success = "Product $action successfully!";
            if (!$edit_mode) {
                // Clear form after new upload
                $_POST = [];
            }
        } else {
            $error = "Database Error: " . $stmt->error;
        }
    }
}


$categories_query = "SELECT category_id, category_name FROM categories ORDER BY category_name ASC";
$categories = mysqli_query($db, $categories_query);




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
        <div class="alert success" style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error)) : ?>
        <div class="alert error" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">

        <label>Product Name</label>
        <input type="text" name="product_name" 
       value="<?php echo $edit_mode ? htmlspecialchars($product['product_name']) : ''; ?>" 
       required>


        <label>Description</label>
        <textarea name="description" rows="4" required>
<?php echo $edit_mode ? htmlspecialchars($product['product_description']) : ''; ?>
</textarea>


        <div class="row">
            <div class="column">
                <label>Price</label>
                <input type="number" step="0.01" name="price" 
       value="<?php echo $edit_mode ? $product['price'] : ''; ?>" required>
            </div>
            <div class="column">
                <label>Old Price (Optional)</label>
                <input type="number" step="0.01" name="old_price" 
       value="<?php echo $edit_mode ? $product['old_price'] : ''; ?>">
            </div>
        </div>

        <label>Stock Quantity</label>
       <input type="number" name="stock_quantity" 
       value="<?php echo $edit_mode ? $product['stock_quantity'] : ''; ?>" required>


        <label>Select Category</label>
        <select name="category_id" required>
    <option value="">-- Choose category --</option>
    <?php while($cat = mysqli_fetch_assoc($categories)) : ?>
        <option value="<?php echo $cat['category_id']; ?>" 
            <?php echo ($edit_mode && $cat['category_id'] == $product['category_id']) ? 'selected' : ''; ?>>
            <?php echo ucfirst($cat['category_name']); ?>
        </option>
    <?php endwhile; ?>
</select>


        <label>Upload Product Image</label>
        <input type="file" name="image" accept="image/*" required>

        <button type="submit" name="upload" class="upload-btn">Upload Product</button>

    </form>
</div>

</body>
</html>