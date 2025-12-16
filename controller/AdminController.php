<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/db_connection.php';

class AdminController {
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
        global $db;
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            // Simple admin auth: check admins table
            // Ensure admins table exists
            $db->query('CREATE TABLE IF NOT EXISTS admins (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) UNIQUE NOT NULL, password_hash VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)');
            $stmt = $db->prepare('SELECT email, password_hash FROM admins WHERE email = ?');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
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
        global $db;
        $error = '';
        $success = '';
        // Ensure admins table exists
        $db->query('CREATE TABLE IF NOT EXISTS admins (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(255) UNIQUE NOT NULL, password_hash VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)');

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
                $stmt = $db->prepare('INSERT INTO admins (email, password_hash) VALUES (?, ?)');
                $stmt->bind_param('ss', $email, $hash);
                if ($stmt->execute()) {
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
        global $db;
        // Basic stats
        $stats = [
            'users' => $db->query('SELECT COUNT(*) AS c FROM users')->fetch_assoc()['c'] ?? 0,
            'farmers' => $db->query('SELECT COUNT(*) AS c FROM farmer')->fetch_assoc()['c'] ?? 0,
            'products' => $db->query('SELECT COUNT(*) AS c FROM product')->fetch_assoc()['c'] ?? 0,
            'orders' => $db->query('SELECT COUNT(*) AS c FROM order_or_cart')->fetch_assoc()['c'] ?? 0,
        ];
        require 'view/admin/dashboard.php';
    }

}
