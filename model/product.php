<?php


class Product
{
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function getBestSellingProducts($limit = 10)
    {
        $sql = "
        SELECT 
            p.product_id,
            p.product_name,
            p.price,
            p.old_price,
            p.stock_quantity,
            p.image,
            c.category_name,
            -- Sum the quantity from 'order_or_cart'
            COALESCE(SUM(oc.quantity), 0) AS total_sold
        FROM products p
        -- JOIN with the correct table name
        LEFT JOIN order_or_cart oc 
            ON p.product_id = oc.product_id 
        JOIN categories c 
            ON p.category_id = c.category_id
        GROUP BY p.product_id
        ORDER BY total_sold DESC
        LIMIT ?
    ";

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            // Table likely missing or SQL error
            error_log("DB Error in getBestSellingProducts: " . $this->db->error);
            return [];
        }

        $stmt->bind_param("i", $limit);
        if (!$stmt->execute()) {
            error_log("Execute failed in getBestSellingProducts: " . $stmt->error);
            return [];
        }

        $result = $stmt->get_result();
        if (!$result) {
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getAllCategories()
    {
        $result = $this->db->query("SELECT * FROM categories");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countProducts($search, $categoryId)
    {
        $sql = "SELECT COUNT(*) as total FROM products WHERE 1=1";
        $params = [];
        $types = "";

        if (!empty($search)) {
            $sql .= " AND (product_name LIKE ? OR product_description LIKE ?)";
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

<<<<<<< HEAD
    public function getProducts($search = '', $categoryId = null, $sort = '', $offset = 0, $limit = 12) {
    $sql = "SELECT * FROM products WHERE 1=1";
=======
    public function getProducts($search, $categoryId, $sort, $offset, $limit)
    {
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];
        $types = "";
>>>>>>> 48a96ddb6036066e08f78c207bf86e544e837861

    $params = [];
    $types = '';

<<<<<<< HEAD
    if ($categoryId !== null) {
        $sql .= " AND category_id = ?";
        $params[] = $categoryId;
        $types .= 'i';
=======
        if ($categoryId > 0) {
            $sql .= " AND category_id = ?";
            $params[] = $categoryId;
            $types .= "i";
        }

        // Sorting
        switch ($sort) {
            case 'low':
                $sql .= " ORDER BY price ASC";
                break;
            case 'high':
                $sql .= " ORDER BY price DESC";
                break;
            case 'newest':
                $sql .= " ORDER BY created_on DESC";
                break;
            case 'oldest':
                $sql .= " ORDER BY created_on ASC";
                break;
            default:
                $sql .= " ORDER BY product_id DESC";
                break;
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
>>>>>>> 48a96ddb6036066e08f78c207bf86e544e837861
    }

    if (!empty($search)) {
        $sql .= " AND (product_name LIKE ? OR product_description LIKE ?)";
        $searchTerm = "%$search%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $types .= 'ss';
    }

    // Sorting
    if ($sort === 'price_asc') $sql .= " ORDER BY price ASC";
    elseif ($sort === 'price_desc') $sql .= " ORDER BY price DESC";
    else $sql .= " ORDER BY product_name ASC";

    $sql .= " LIMIT ?, ?";
    $params[] = $offset;
    $params[] = $limit;
    $types .= 'ii';

    $stmt = $this->db->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $this->db->error);
    }

    // Bind parameters dynamically
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

}
?>