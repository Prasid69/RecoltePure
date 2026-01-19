<?php
class AdminModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getDashboardStats()
    {
        return [
            'users' => $this->getCount('users'),
            'farmers' => $this->getCount('farmer'),
            'products' => $this->getCount('products'),
            'orders' => $this->getCount('order_or_cart'),
        ];
    }
    private function getCount($table)
    {
        $sql = "SELECT COUNT(*) AS c FROM " . $table;
        $result = $this->db->query($sql);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row['c'];
        }
        return 0;
    }

    public function getAllUsers($search = '')
    {
        $sql = "SELECT * FROM users WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $sql .= " AND (name LIKE ? OR email LIKE ? OR phone_number LIKE ?)";
            $term = "%$search%";
            $params = [$term, $term, $term];
            $types = "sss";
        }

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public function getAdminByEmail($email)
    {
        $this->db->query('CREATE TABLE IF NOT EXISTS admins (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) UNIQUE NOT NULL, password_hash VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)');

        $stmt = $this->db->prepare('SELECT email, password_hash FROM admins WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function registerAdmin($email, $hash)
    {
        $this->db->query('CREATE TABLE IF NOT EXISTS admins (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) UNIQUE NOT NULL, password_hash VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)');

        $stmt = $this->db->prepare('INSERT INTO admins (email, password_hash) VALUES (?, ?)');
        $stmt->bind_param('ss', $email, $hash);
        return $stmt->execute();
    }


    public function getAllFarmers($search = '')
    {
        $sql = "SELECT * FROM farmer WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $sql .= " AND (name LIKE ? OR email LIKE ?)";
            $term = "%$search%";
            $params = [$term, $term];
            $types = "ss";
        }

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function verifyFarmer($farmerId)
    {
        $stmt = $this->db->prepare("UPDATE farmer SET account_status = 'Verified' WHERE farmer_id = ?");
        $stmt->bind_param("i", $farmerId);
        return $stmt->execute();
    }


    public function getCategoryStats()
    {
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


    public function updateUserStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE users SET status = ? WHERE customer_id = ?");
        $stmt->bind_param("si", $status, $id); // "s" for string, "i" for integer
        return $stmt->execute();
    }

    public function updateFarmerStatus($id, $status)
    {
        $stmt = $this->db->prepare("UPDATE farmer SET account_status = ? WHERE farmer_id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        // Note: Ensure the column name is correct (you used customer_id elsewhere)
        $stmt = $this->db->prepare("DELETE FROM users WHERE customer_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }



    public function getUserRegistrationStats()
    {
        $sql = "SELECT DATE_FORMAT(registration_date, '%b') as month, COUNT(*) as count 
            FROM users 
            GROUP BY MONTH(registration_date) 
            ORDER BY registration_date ASC LIMIT 6";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getAllFarmersWithPerformance($search = '')
    {
        $searchTerm = "%$search%";

        $sql = "SELECT 
                f.*, 
                COUNT(DISTINCT p.product_id) as total_products,
                COUNT(DISTINCT o.order_cart_id) as orders_completed,
                IFNULL(SUM(o.total_price), 0) as revenue
            FROM farmer f
            LEFT JOIN products p ON f.farmer_id = p.farmer_id
            LEFT JOIN order_or_cart o ON p.product_id = o.product_id
            WHERE f.name LIKE ? OR f.email LIKE ? OR f.address LIKE ?
            GROUP BY f.farmer_id
            ORDER BY revenue DESC";

        // Prepare the statement
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);

        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getProductsByFarmer($farmerId)
    {
        $id = (int) $farmerId;
        $sql = "SELECT * FROM products WHERE farmer_id = $id";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return [];
    }


    public function getLowStockAlerts()
    {
        $sql = "SELECT p.product_name, p.quantity, f.name as farmer_name 
            FROM products p 
            JOIN farmer f ON p.farmer_id = f.farmer_id 
            WHERE p.quantity < 10 
            ORDER BY p.quantity ASC";

        return $this->db->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllProductsWithDetails()
    {
        $sql = "SELECT p.*, f.name as farmer_name, f.address as farmer_location, c.category_name 
                FROM products p 
                JOIN farmer f ON p.farmer_id = f.farmer_id 
                JOIN categories c ON p.category_id = c.category_id
                ORDER BY p.product_id DESC";
        $result = $this->db->query($sql);
        return ($result) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }


    public function deleteProductById($id)
    {
        $id = (int) $id;
        $sql = "DELETE FROM products WHERE product_id = $id";

        return $this->db->query($sql);
    }


    public function getAllOrders($timeframe = 'all', $status = 'all')
    {
        $sql = "SELECT o.*, o.payment_status AS status, u.name as customer_name, p.product_name 
                FROM order_or_cart o
                JOIN users u ON o.customer_id = u.customer_id
                JOIN products p ON o.product_id = p.product_id
                WHERE 1=1";

        if ($timeframe == 'today')
            $sql .= " AND DATE(o.delivery_date) = CURDATE()";
        if ($status != 'all')
            $sql .= " AND o.payment_status = '$status'";

        $sql .= " ORDER BY o.delivery_date DESC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getOrderStatusStats()
    {
        $sql = "SELECT payment_status as status, COUNT(*) as count FROM order_or_cart GROUP BY payment_status";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function updateOrderStatus($orderId, $newStatus)
    {
        $stmt = $this->db->prepare("UPDATE order_or_cart SET payment_status = ? WHERE order_cart_id = ?");
        $stmt->bind_param("si", $newStatus, $orderId);
        return $stmt->execute();
    }

    public function getOrdersTrend()
    {
        $sql = "SELECT DATE(delivery_date) as order_date, COUNT(*) as total_orders 
            FROM order_or_cart 
            WHERE delivery_date >= DATE_SUB(CURDATE(), INTERVAL 45 DAY)
            GROUP BY DATE(delivery_date) 
            ORDER BY order_date ASC";

        $result = $this->db->query($sql);
        return ($result) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

}
?>