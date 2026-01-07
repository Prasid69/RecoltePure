<?php

require_once 'config/db_connection.php';
require_once 'model/Cart.php'; 
require_once 'model/Orders.php'; 

class CartController {
    private $db;
    private $cartModel;
    private $cart;
    private $orderModel;

    public function __construct($db) {
        $this->db = $db;
        $this->cartModel = new Cart();
        $this->cart = new Cart(); 
        $this->orderModel = new OrderModel($this->db);
    }

    public function checkout() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        if (empty($_SESSION['cart'])) {
            header("Location: index.php?page=cart&error=empty_cart");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $cartItems = $_SESSION['cart'];

        if ($this->orderModel->createOrder($userId, $cartItems)) {
            
            unset($_SESSION['cart']);

            header("Location: index.php?page=my_orders&success=order_placed");
            exit();
        } else {
            echo "Failed to place order. Please try again.";
        }
    }

    public function handleActions() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Add Item
            if (isset($_POST['product_id']) && !isset($_POST['action'])) {
                $this->cartModel->add(
                    $_POST['product_id'],
                    $_POST['product_name'],
                    (float)$_POST['price'],
                    (int)$_POST['quantity'],
                    $_POST['image']
                );
            }
            
            // Update/Remove Item
            if (isset($_POST['action']) && isset($_POST['product_id'])) {
                $action = $_POST['action'];
                $id = $_POST['product_id'];
                
                if ($action === 'remove') {
                    $this->cartModel->remove($id);
                } elseif ($action === 'increase' || $action === 'decrease') {
                    $this->cartModel->updateQuantity($id, $action);
                }
            }

            header("Location: index.php?page=cart");
            exit;
        }

        if (isset($_GET['action']) && $_GET['action'] === 'clear') {
            $this->cartModel->clear(); 
            header("Location: index.php?page=cart");
            exit;
        }
    
        $cartItems   = $this->cartModel->getItems();
        $grandTotal  = $this->cartModel->calculateTotal();
        $totalItems  = $this->cartModel->countItems();
        
        require_once __DIR__ . "/../view/cart.php";
    }
}
?>