<?php

require_once 'config/db_connection.php';
require_once 'model/product.php';

class CategoryController {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $userData = [
            'is_logged_in' => isset($_SESSION['login_user']),
            'initial' => isset($_SESSION['login_user']) ? strtoupper(substr($_SESSION['login_user'], 0, 1)) : ''
        ];

        // Get Filters from URL
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
        $page = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $page = max(1, $page); // safety

        $limit = 12; // Items per page

        // Initialize Model
        $productModel = new Product($this->db);

        // Get Data
        $categories = $productModel->getAllCategories();
        $totalItems = $productModel->countProducts($search, $categoryId);
        
        // Calculate Pagination
        $totalPages = ceil($totalItems / $limit);
        $offset = ($page - 1) * $limit;

        // Fetch Products
        $products = $productModel->getProducts($search, $categoryId, $sort, $offset, $limit);

        // Load View
        require_once __DIR__ . '/../view/categories.php';
    }
}
?>