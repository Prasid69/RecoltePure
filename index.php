<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once __DIR__ . '/config/db_connection.php';


$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'login':
        require_once "controller/AuthController.php";
        $controller = new AuthController($db);
        $controller->login();
        break;

    case 'logout':
        require_once "controller/AuthController.php";
        $authCtrl = new AuthController($db);
        $authCtrl->logout();
        break;


    case 'home':
    default:
        require_once "controller/HomeController.php";
        $controller = new HomeController($db);
        $controller->index();
        break;

    case 'categories':
        require_once "controller/CategoryController.php";
        $controller = new CategoryController($db);
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
        $controller = new CartController($db);
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
        $controller = new UserController($db);
        $controller->profile();
        break;


    case 'edit_profile':
        require_once 'controller/UserController.php';
        $controller = new UserController($db);
        $controller->edit();
        break;

    case 'update_profile':
        require_once 'controller/UserController.php';
        $controller = new UserController($db);
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
        // LOG: Start of checkout case
        error_log("=== CHECKOUT FLOW START ===");
        error_log("GET params: " . print_r($_GET, true));
        error_log("Session user_id: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'NOT SET'));
        error_log("Session cart: " . (isset($_SESSION['cart']) ? count($_SESSION['cart']) . ' items' : 'EMPTY'));

        // Check if StripeController exists
        $controllerPath = "controller/StripeController.php";
        if (!file_exists($controllerPath)) {
            error_log("ERROR: StripeController.php NOT FOUND at: " . $controllerPath);
            die("Error: StripeController not found");
        }
        error_log("StripeController.php found");

        try {
            require_once $controllerPath;
            error_log("StripeController.php loaded successfully");

            if (!class_exists('StripeController')) {
                error_log("ERROR: StripeController class NOT FOUND after loading file");
                die("Error: StripeController class not found");
            }
            error_log("StripeController class exists");

            $controller = new StripeController($db);
            error_log("StripeController instantiated");

            // Handle payment status callbacks from Stripe
            if (isset($_GET['status'])) {
                error_log("Handling status: " . $_GET['status']);
                if ($_GET['status'] === 'success') {
                    error_log("Calling handleSuccess()");
                    $controller->handleSuccess();
                } elseif ($_GET['status'] === 'cancelled') {
                    error_log("Calling handleCancel()");
                    $controller->handleCancel();
                }
            } else {
                // Create new checkout session and redirect to Stripe
                error_log("Creating new checkout session");
                $controller->createCheckoutSession();
            }
        } catch (Exception $e) {
            error_log("EXCEPTION in checkout: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            die("Checkout Error: " . $e->getMessage());
        }
        error_log("=== CHECKOUT FLOW END ===");
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