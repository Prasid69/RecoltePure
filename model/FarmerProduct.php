<?php
class FarmerProduct {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Get farmer ID by email
    public function getFarmerIdByEmail($email) {
        $stmt = $this->db->prepare("SELECT farmer_id FROM farmer WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0 ? $res->fetch_assoc()['farmer_id'] : null;
    }

    // Get a single product by ID and farmer ID
    public function getProduct($product_id, $farmer_id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE product_id = ? AND farmer_id = ?");
        $stmt->bind_param("ii", $product_id, $farmer_id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows > 0   ? $res->fetch_assoc() : null;
    }

    // Get all categories
    public function getCategories() {
        $query = "SELECT category_id, category_name FROM categories ORDER BY category_name ASC";
        $result = mysqli_query($this->db, $query);
        $categories = [];
        while($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
        return $categories;
    }

    // Insert new product
    public function insertProduct($data) {
        $sql = "INSERT INTO products 
            (product_name, product_description, price, old_price, stock_quantity, category_id, farmer_id, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "ssddiiis",
            $data['product_name'],
            $data['description'],
            $data['price'],
            $data['old_price'],
            $data['stock_quantity'],
            $data['category_id'],
            $data['farmer_id'],
            $data['image']
        );
        return $stmt->execute();
    }

    // Update existing product
    public function updateProduct($data) {
        $sql = "UPDATE products SET 
            product_name=?, 
            product_description=?, 
            price=?, 
            old_price=?, 
            stock_quantity=?, 
            category_id=?, 
            image=? 
            WHERE product_id=? AND farmer_id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "ssddiiiii",
            $data['product_name'],
            $data['description'],
            $data['price'],
            $data['old_price'],
            $data['stock_quantity'],
            $data['category_id'],
            $data['image'],
            $data['product_id'],
            $data['farmer_id']
        );
        return $stmt->execute();
    }
}
