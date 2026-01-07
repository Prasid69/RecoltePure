<?php

require_once 'config/db_connection.php';
require_once 'model/Orders.php';

class OrderController {
    private $model;

    public function __construct($db) {
        $this->model = new OrderModel($db);
    }

    public function myOrders() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // 1. Security Check
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
            header("Location: index.php?page=login");
            exit();
        }

        $customerId = $_SESSION['user_id'];

        // 2. Fetch Data
        $orders = $this->model->getOrdersByCustomerId($customerId);

        // 3. Load View
        require_once 'view/my_orders.php';
    }
}
?>