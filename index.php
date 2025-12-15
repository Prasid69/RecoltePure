<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();


$page = $_GET['page'] ?? 'home'; 

switch ($page) {
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
        $controller->loadProduct(); 
        break;

    case 'cart':
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
    
    
}
?>