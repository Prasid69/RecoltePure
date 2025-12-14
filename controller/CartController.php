<?php
require_once 'model/Cart.php'; 

class CartController {
    private $cartModel;

    public function __construct() {
        $this->cartModel = new Cart();
    }

    public function handleActions() {
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

            // Redirect to self (clean PRG pattern)
            header("Location: index.php?page=cart");
            exit;
        }

        // 2. Handle GET Actions (Clear Cart)
        if (isset($_GET['action']) && $_GET['action'] === 'clear') {
            $this->cartModel->clear();
            header("Location: index.php?page=cart");
            exit;
        }

        // 3. Prepare Data for View
        $cartItems   = $this->cartModel->getItems();
        $grandTotal  = $this->cartModel->calculateTotal();
        $totalItems  = $this->cartModel->countItems();

        
        require_once __DIR__ . "/../view/cart.php";
    }
}
?>