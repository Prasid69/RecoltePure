<?php

require_once "config/db_connection.php";
require_once "model/Farmers.php";
require_once "model/Users.php";

class AuthController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function login()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $error = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $email = $_POST['username'];
            $password = $_POST['password'];

            $farmerModel = new Farmer($this->db);
            $userModel = new User($this->db);

            $farmer = $farmerModel->findByEmail($email);
            if ($farmer && password_verify($password, $farmer['password'])) {
                $_SESSION['login_user'] = $farmer['email'];
                $_SESSION['role'] = "farmer";
                $_SESSION['user_name'] = $farmer['name'];

                $_SESSION['user_id'] = $farmer['farmer_id'];

                header("Location: index.php?page=home");
                exit;
            }

            $user = $userModel->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['login_user'] = $user['email'];
                $_SESSION['role'] = "customer";
                $_SESSION['user_name'] = $user['name'];

                $_SESSION['user_id'] = $user['customer_id'];

                header("Location: index.php?page=home");
                exit;
            }

            $error = "Invalid Username or Password!";
        }

        require "view/login.php";
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header("Location: index.php?page=home");
        exit;
    }
}