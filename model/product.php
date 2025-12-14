<?php


class Product {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getBestSellingProducts($limit = 10) {
        $sql = "
            SELECT 
                p.product_id,
                p.product_name,
                p.price,
                p.old_price,
                p.image,
                c.category_name,
                COALESCE(SUM(o.quantity), 0) AS total_sold
            FROM products p
            LEFT JOIN order_items o 
                ON p.product_id = o.announcement_id
            JOIN categories c 
                ON p.category_id = c.category_id
            GROUP BY p.product_id
            ORDER BY total_sold DESC
            LIMIT ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        
        return $products;
    }


    public function getAllCategories() {
        $result = $this->db->query("SELECT * FROM categories");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countProducts($search, $categoryId) {
        $sql = "SELECT COUNT(*) as total FROM products WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $sql .= " AND (product_name LIKE ? OR description LIKE ?)";
            $searchTerm = "%$search%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= "ss";
        }

        if ($categoryId > 0) {
            $sql .= " AND category_id = ?";
            $params[] = $categoryId;
            $types .= "i";
        }

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    public function getProducts($search, $categoryId, $sort, $offset, $limit) {
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];
        $types = "";

        // Filters
        if (!empty($search)) {
            $sql .= " AND (product_name LIKE ? OR description LIKE ?)";
            $searchTerm = "%$search%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $types .= "ss";
        }

        if ($categoryId > 0) {
            $sql .= " AND category_id = ?";
            $params[] = $categoryId;
            $types .= "i";
        }

        // Sorting
        switch ($sort) {
            case 'low':    $sql .= " ORDER BY price ASC"; break;
            case 'high':   $sql .= " ORDER BY price DESC"; break;
            case 'newest': $sql .= " ORDER BY created_on DESC"; break;
            case 'oldest': $sql .= " ORDER BY created_on ASC"; break;
            default:       $sql .= " ORDER BY product_id DESC"; break;
        }

        // Pagination Limit
        $sql .= " LIMIT ?, ?";
        $params[] = $offset;
        $params[] = $limit;
        $types .= "ii";

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>