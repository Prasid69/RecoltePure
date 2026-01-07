<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/db_connection.php';
require_once 'model/Admin.php'; 

class AdminController {
    private $model;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->model = new AdminModel($db);
    }

    public function route() {
        $action = $_GET['action'] ?? 'login';
        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'register':
                $this->register();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'dashboard':
                $this->ensureAdmin();
                $this->dashboard();
                break;
            case 'verify_farmer':
                $this->ensureAdmin();
                $this->verifyFarmerAction();
                break;
            default:
                $this->login();
        }
    }

    private function ensureAdmin() {
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            header('Location: index.php?page=admin&action=login');
            exit;
        }
    }

    private function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            // Use Model to check database
            $row = $this->model->getAdminByEmail($email);
            
            if ($row && password_verify($password, $row['password_hash'])) {
                $_SESSION['is_admin'] = true;
                $_SESSION['admin_email'] = $email;
                header('Location: index.php?page=admin&action=dashboard');
                exit;
            } else {
                $error = 'Invalid admin credentials';
            }
        }
        require 'view/admin/login.php';
    }

    private function register() {
        $error = '';
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm'] ?? '';

            if ($email === '' || $password === '') {
                $error = 'Email and password are required';
            } elseif ($password !== $confirm) {
                $error = 'Passwords do not match';
            } else {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                if ($this->model->registerAdmin($email, $hash)) {
                    $success = 'Admin registered successfully. You can login now.';
                } else {
                    $error = 'Registration failed. Email may already be registered.';
                }
            }
        }
        require 'view/admin/register.php';
    }

    private function logout() {
        unset($_SESSION['is_admin'], $_SESSION['admin_email']);
        header('Location: index.php?page=admin&action=login');
        exit;
    }

    private function dashboard() {
        $stats = $this->model->getDashboardStats();
        $allUsers = $this->model->getAllUsers();
        $allFarmers = $this->model->getAllFarmers();
        $categoryStats = $this->model->getCategoryStats();
        require 'view/admin/dashboard.php';
    }


    private function verifyFarmerAction() {
        if (isset($_GET['id'])) {
            $farmerId = $_GET['id'];
            if ($this->model->verifyFarmer($farmerId)) {
                header("Location: index.php?page=admin&action=dashboard&msg=verified");
                exit;
            }
        }
        header("Location: index.php?page=admin&action=dashboard&error=failed");
        exit;
    }
}
?>
