<?php

require_once 'config/db_connection.php';
require_once 'model/Orders.php';

class OrderController {
        /**
         * Create order after successful Stripe payment
         * @param int $userId
         * @param array $cartItems
         * @param string|null $transactionId
         * @param string|null $paymentMethod
         * @param float|null $amountPaid
         * @return bool
         */
        public function createOrder($userId, $cartItems, $transactionId = null, $paymentMethod = null, $amountPaid = null) {
            try {
                // If payment info is provided, use createOrderWithPayment
                if ($transactionId && $paymentMethod && $amountPaid) {
                    $this->model->createOrderWithPayment($userId, $cartItems, $transactionId, $paymentMethod, $amountPaid);
                } else {
                    $this->model->createOrder($userId, $cartItems);
                }
                return true;
            } catch (Exception $e) {
                error_log('Order creation failed: ' . $e->getMessage());
                return false;
            }
        }
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