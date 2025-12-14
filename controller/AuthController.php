<?php

require_once "config/db_connection.php";
require_once "model/Farmers.php";
require_once "model/Users.php";

class AuthController {

    public function login() {
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $email = $_POST['username'];
            $password = $_POST['password'];

            $farmerModel = new Farmer($GLOBALS['db']);
            $userModel   = new User($GLOBALS['db']);

            // Try farmer login
            $farmer = $farmerModel->findByEmail($email);
            if ($farmer && password_verify($password, $farmer['password'])) {
                $_SESSION['login_user'] = $farmer['email'];
                $_SESSION['role'] = "farmer";
                $_SESSION['user_name'] = $farmer['name'];
                header("Location: index.php?page=home");
                exit;
            }

            // Try customer login
            $user = $userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['login_user'] = $user['email'];
                $_SESSION['role'] = "customer";
                $_SESSION['user_name'] = $user['name'];
                header("Location: index.php?page=home");
                exit;
            }

            $error = "Invalid Username or Password!";
        }

        // Load view
        require "view/login.php";
    }
}
