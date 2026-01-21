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
            header("Location: /RecoltePure/login");
            exit();
        }

        if (empty($_SESSION['cart'])) {
            header("Location: /RecoltePure/cart?error=empty_cart");
            exit();
        }
        require_once __DIR__ . '/StripePayment.php';
        $cartItems = array_values($_SESSION['cart']);
        $successUrl = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?page=payment_success";
        $cancelUrl = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?page=cart&error=payment_cancelled";
        $stripeUrl = StripePayment::createCheckoutSession($cartItems, $successUrl, $cancelUrl);
        header("Location: $stripeUrl");
        exit();
    }

    public function handleActions() {
    if (session_status() === PHP_SESSION_NONE) session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      
        if (isset($_POST['product_id']) && !isset($_POST['action'])) {
            $this->cartModel->add(
                $_POST['product_id'],
                $_POST['product_name'],
                (float)$_POST['price'],
                (int)$_POST['quantity'],
                $_POST['image']
            );
            header("Location: /RecoltePure/cart");
            exit;
        }

        if (isset($_POST['action'], $_POST['product_id'])) {
            $id = $_POST['product_id'];
            $action = $_POST['action'];

            if ($action === 'remove') {
                $this->cartModel->remove($id);
            } elseif ($action === 'increase' || $action === 'decrease') {
                $this->cartModel->updateQuantity($id, $action);
            }

            header("Location: /RecoltePure/cart");
            exit;
        }

     
        if (isset($_POST['action']) && $_POST['action'] === 'apply_coupon' && !empty($_POST['coupon_code'])) {
            $couponCode = trim($_POST['coupon_code']);
            $discount = $this->cartModel->applyCoupon($couponCode);

            if ($discount > 0) {
                $_SESSION['coupon'] = [
                    'code' => $couponCode,
                    'discount' => $discount
                ];
                $_SESSION['success_message'] = "Coupon applied! You got $discount% off.";
            } else {
                unset($_SESSION['coupon']);
                $_SESSION['error_message'] = "Invalid coupon code.";
            }

            header("Location: /RecoltePure/cart");
            exit;
        }

        if (isset($_POST['action']) && $_POST['action'] === 'remove_coupon') {
            unset($_SESSION['coupon']);
            $_SESSION['success_message'] = "Coupon removed.";
            header("Location: /RecoltePure/cart");
            exit;
        }
    }

    if (isset($_GET['action']) && $_GET['action'] === 'clear') {
        $this->cartModel->clear();
        header("Location: /RecoltePure/cart");
        exit;
    }

    $cartItems = $this->cartModel->getItems();
    $grandTotalBeforeDiscount = $this->cartModel->calculateTotal();
    $totalItems = $this->cartModel->countItems();

    if (!empty($_SESSION['coupon'])) {
        $discountPercent = $_SESSION['coupon']['discount'];
        $discountAmount = $grandTotalBeforeDiscount * ($discountPercent / 100);
        $grandTotal = $grandTotalBeforeDiscount - $discountAmount;
    } else {
        $grandTotal = $grandTotalBeforeDiscount;
    }

    require_once __DIR__ . "/../view/cart.php";
}


}
?>