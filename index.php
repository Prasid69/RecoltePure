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
}
?>