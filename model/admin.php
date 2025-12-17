<?php
class AdminModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function getDashboardStats() {
        return [
            'users'    => $this->getCount('users'),
            'farmers'  => $this->getCount('farmer'),
            'products' => $this->getCount('products'),
            'orders'   => $this->getCount('order_or_cart'),
        ];
    }
    private function getCount($table) {
        $sql = "SELECT COUNT(*) AS c FROM " . $table;
        $result = $this->db->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['c'];
        }
        return 0;
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY customer_id DESC";
        $result = $this->db->query($sql);
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    public function getAdminByEmail($email) {
        $this->db->query('CREATE TABLE IF NOT EXISTS admins (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) UNIQUE NOT NULL, password_hash VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)');
        
        $stmt = $this->db->prepare('SELECT email, password_hash FROM admins WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function registerAdmin($email, $hash) {
        $this->db->query('CREATE TABLE IF NOT EXISTS admins (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) UNIQUE NOT NULL, password_hash VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)');
        
        $stmt = $this->db->prepare('INSERT INTO admins (email, password_hash) VALUES (?, ?)');
        $stmt->bind_param('ss', $email, $hash);
        return $stmt->execute();
    }


    public function getAllFarmers() {
        $sql = "SELECT * FROM farmer ORDER BY farmer_id DESC";
        $result = $this->db->query($sql);
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function verifyFarmer($farmerId) {
        $stmt = $this->db->prepare("UPDATE farmer SET account_status = 'Verified' WHERE farmer_id = ?");
        $stmt->bind_param("i", $farmerId);
        return $stmt->execute();
    }


    public function getCategoryStats() {
    $sql = "SELECT 
                c.category_name, 
                COUNT(p.product_id) as total_products,
                GROUP_CONCAT(DISTINCT f.name SEPARATOR ', ') as farmers_list
            FROM categories c
            LEFT JOIN products p ON c.category_id = p.category_id
            LEFT JOIN farmer f ON p.farmer_id = f.farmer_id
            GROUP BY c.category_id, c.category_name
            ORDER BY total_products DESC";
            
    $result = $this->db->query($sql);
    
    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    return [];
}
}
?>