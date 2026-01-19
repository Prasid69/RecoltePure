<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/config/db_connection.php';


$page = $_GET['page'] ?? 'home'; 

switch ($page) {

        case 'payment_success':
            // Handle Stripe payment success, create order, clear cart, redirect to orders
            if (session_status() === PHP_SESSION_NONE) session_start();
            if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
                header("Location: index.php?page=cart&error=payment_session");
                exit();
            }
            require_once 'controller/OrderController.php';
            $controller = new OrderController($db);
            $userId = $_SESSION['user_id'];
            $cartItems = $_SESSION['cart'];
            // Optionally get Stripe payment info from session if set
            $transactionId = $_SESSION['stripe_transaction_id'] ?? null;
            $paymentMethod = $_SESSION['stripe_payment_method'] ?? null;
            $amountPaid = $_SESSION['stripe_amount_paid'] ?? null;
            if ($controller->createOrder($userId, $cartItems, $transactionId, $paymentMethod, $amountPaid)) {
                unset($_SESSION['cart']);
                unset($_SESSION['stripe_transaction_id'], $_SESSION['stripe_payment_method'], $_SESSION['stripe_amount_paid']);
                header("Location: index.php?page=my_orders&success=order_placed");
                exit();
            } else {
                echo "Order creation failed after payment. Please contact support.";
            }
            break;
    case 'login':
        require_once "controller/AuthController.php";
        $controller = new AuthController();
        $controller->login();
        break;
    
    case 'logout':
        require_once "controller/AuthController.php";
        $authCtrl = new AuthController();
        $authCtrl->logout();
        break;


    case 'home':
    default:
        require_once "controller/HomeController.php";
        $controller = new HomeController();
        $controller->index();
        break;

    case 'categories':
        require_once "controller/CategoryController.php";
        $controller = new CategoryController();
        $controller->index();
        break;

    case 'upload_product':
        require_once "controller/ProductController.php";
        $controller = new ProductController($db); 
        $controller->showUploadForm();
        break;

    case 'cart':
        require_once "controller/CartController.php";
        $controller = new CartController($db);
        $controller->handleActions(); 
        break;

    case 'clear':
        require_once "controller/CartController.php";
        $controller = new CartController();
        $controller->handleActions(); 
        break;

    case 'contact':
        require_once 'controller/ContactController.php';
        $controller = new ContactController($db);
        $controller->index();
        break;

    case 'register':
        require_once 'controller/RegistrationController.php';
        $controller = new RegisterController($db);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->handleRequest();
        } else {
            $controller->index();
        }
        break;


    case 'password_recovery':
        require_once 'controller/PasswordRecoveryController.php';
        $controller = new RecoveryController($db);
        $controller->handleRequest();
        break;

    case 'reset_password':
        require_once 'controller/ResetPasswordController.php';
        $controller = new ResetPasswordController($db);
        $controller->handleRequest();
        break;

    case 'profile':
        require_once 'controller/UserController.php';
        $controller = new UserController();
        $controller->profile();
        break;


    case 'edit_profile':
        require_once 'controller/UserController.php';
        $controller = new UserController();
        $controller->edit();
        break;

    case 'update_profile':
        require_once 'controller/UserController.php';
        $controller = new UserController();
        $controller->update();
        break;

    case 'write_review':
        require_once 'controller/ReviewController.php';
        $controller = new ReviewController($db); 
        $controller->showReviewForm();
        break;

    case 'process_review':
        require_once 'controller/ReviewController.php';
        $controller = new ReviewController($db);
        $controller->submitReview();
        break;

    case 'my_orders':
        require_once 'controller/OrderController.php';
        $controller = new OrderController($db); 
        $controller->myOrders();
        break;
    
    case 'checkout':
    require_once "controller/CartController.php";
    $controller = new CartController($db); 
    $controller->checkout();
    break;

    case 'admin':
        require_once "controller/AdminController.php";
        $controller = new AdminController($db);
        $controller->route();
        break;

    case 'terms_and_conditions':
        require_once 'view/terms_and_conditions.php';
        break;

    case 'farmers':
        require_once 'controller/FarmerController.php';
        $controller = new FarmerController($db);
        $controller->index();
        break;
}
?>