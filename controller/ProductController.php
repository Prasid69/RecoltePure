<?php
require_once "config/db_connection.php";
require_once "model/FarmerProduct.php";

class ProductController {
    private $db;
    private $model;
    private $farmer_id;
    public $error = '';
    public $success = ''; 
    public $edit_mode = false;
    public $product = [];
    public $categories = [];

    public function __construct($db) {
        $this->db = $db;
        $this->model = new FarmerProduct($db);
      
        // 1. Check Login
        if (!isset($_SESSION['login_user'])) {
            die("You must be logged in.");
        }
        
        // 2. Check Role
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'farmer') {
            die("You must be logged in as a farmer.");
        }
        
        // 3. Get Farmer ID
        $this->farmer_id = $this->model->getFarmerIdByEmail($_SESSION['login_user']);
        if (!$this->farmer_id) die("Farmer record not found.");

        // 4. Check Verification (Blocks access if Pending)
        $this->checkVerificationStatus();

        // 5. Load Categories 
        $this->categories = $this->model->getCategories();
    }

    // --- NEW: THIS IS THE MISSING FUNCTION ---
    public function showUploadForm() {
        // 1. If editing, load product data
        $this->loadProduct();

        // 2. Handle form submission (if POST)
        $this->handleUpload();

        // 3. Display the View (HTML)
        $this->render('upload_product'); 
    }
    // -----------------------------------------

    private function checkVerificationStatus() {
        $sql = "SELECT account_status FROM farmer WHERE farmer_id = " . (int)$this->farmer_id;
        $result = $this->db->query($sql);
        
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row['account_status'] !== 'Verified') {
                echo '<div style="font-family: Arial, sans-serif; text-align: center; margin-top: 50px;">';
                echo '<h1 style="color: #d9534f;">Access Denied</h1>';
                echo '<p style="font-size: 18px;">Your farmer account is currently <strong>Pending Verification</strong>.</p>';
                echo '<p>You cannot upload or edit products until an Admin verifies your details.</p>';
                echo '<a href="index.php" style="background: #333; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Return to Home</a>';
                echo '</div>';
                exit(); 
            }
        }
    }

    public function loadProduct() {
        if (isset($_GET['product_id'])) {
            $this->edit_mode = true;
            $product_id = (int)$_GET['product_id'];
            $this->product = $this->model->getProduct($product_id, $this->farmer_id);
            if (!$this->product) die("Product not found or permission denied.");
        }
    }

    public function handleUpload() {
        if (isset($_POST['upload'])) {
            // 1. Sanitize Inputs
            $product_name = mysqli_real_escape_string($this->db, $_POST['product_name']);
            $description = mysqli_real_escape_string($this->db, $_POST['description']);
            $price = (float)$_POST['price'];
            $old_price = !empty($_POST['old_price']) ? (float)$_POST['old_price'] : NULL;
            $stock = (int)$_POST['stock_quantity'];
            $category_id = (int)$_POST['category_id'];
            
            $file_names = $this->edit_mode ? json_decode($this->product['image'], true) : [];

            // 2. Handle Image Upload
            if (isset($_FILES['images'])) {
    $target_dir = __DIR__ . "/../assets/uploads/products/";

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $original_name = $_FILES['images']['name'][$key];
        $file_size     = $_FILES['images']['size'][$key];
        $file_error    = $_FILES['images']['error'][$key];
        $file_tmp      = $_FILES['images']['tmp_name'][$key];

        $generated_name = time() . "_" . $original_name;
        $target_file = $target_dir . $generated_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($file_tmp);

        if ($check === false) {
            $this->error[] = "$original_name is not an image.";
            continue;
        } elseif ($file_size > 5000000) {
            $this->error[] = "$original_name is too large.";
            continue;
        } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $this->error[] = "$original_name has invalid format.";
            continue;
        }

        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

        if (move_uploaded_file($file_tmp, $target_file)) {
            $file_names[] = $generated_name;
        } else {
            $this->error[] = "Failed to upload $original_name.";
        }
    }

            }

            // 3. Save to Database 
            if (empty($this->error)) {
                $data = [
                    'product_name' => $product_name,
                    'description' => $description,
                    'price' => $price,
                    'old_price' => $old_price,
                    'stock_quantity' => $stock,
                    'category_id' => $category_id,
                    'farmer_id' => $this->farmer_id,
                    'image' => json_encode($file_names),
                    'product_id' => $this->edit_mode ? (int)$_GET['product_id'] : null
                ];

                if ($this->edit_mode) {
                    $result = $this->model->updateProduct($data);
                    $this->success = $result ? "Product updated successfully!" : "Database error!";
                } else {
                    $result = $this->model->insertProduct($data);
                    $this->success = $result ? "Product uploaded successfully!" : "Database error!";
                    if ($result) $_POST = []; 
                }
            }
        }
    }

    public function render($view) {
        $controller = $this; 

        if (file_exists("../view/$view.php")) {
            include "../view/$view.php";
        } elseif (file_exists("view/$view.php")) {
             include "view/$view.php";
        } else {
            die("View file '$view.php' not found!");
        }
    }
}

?>