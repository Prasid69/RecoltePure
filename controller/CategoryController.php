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

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $categoryId = !empty($_GET['category_id']) ? intval($_GET['category_id']) : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
        $page = isset($_GET['p']) ? intval($_GET['p']) : 1;
        $page = max(1, $page); 

        $limit = 12; 

        $productModel = new Product($this->db);

        $categories = $productModel->getAllCategories();
        $totalItems = $productModel->countProducts($search, $categoryId);
        
        $totalPages = ceil($totalItems / $limit);
        $offset = ($page - 1) * $limit;

        $products = $productModel->getProducts($search, $categoryId, $sort, $offset, $limit);

        require_once __DIR__ . '/../view/categories.php';
    }
}
?>