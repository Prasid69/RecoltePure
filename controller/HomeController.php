<?php
require_once 'config/db_connection.php';
require_once 'model/product.php';

class HomeController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userData = [
            'is_logged_in' => isset($_SESSION['login_user']),
            'email' => $_SESSION['login_user'] ?? null,
            'role' => $_SESSION['role'] ?? null,
            'initial' => isset($_SESSION['login_user']) ? strtoupper(substr($_SESSION['login_user'], 0, 1)) : ''
        ];

        $productModel = new Product($this->db);
        $bestSellingProducts = $productModel->getBestSellingProducts();

        require_once 'view/home.php';
    }
}
?>