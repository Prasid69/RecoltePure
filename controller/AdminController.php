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


    $publicActions = ['login', 'register'];

    if (!in_array($action, $publicActions)) {
        $this->ensureAdmin();
    }

        switch ($action) {
            case 'login':
                $this->login();
                break;

            case 'users':          
                $this->usersPage();
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

            case 'toggle_user_status':
                $this->toggleUserStatus();
                break;

            case 'delete_user':
                $this->deleteUser();
                break;

            case 'users':           
                $this->usersPage();
                break;

            case 'farmers': 
                $this->farmersPage();
                break;

            case 'farmer-products':
            case 'view_farmer_products':
                $this->ensureAdmin(); 
                $this->viewFarmerProducts(); 
                break;

            case 'all_products':
                $this->allProductsPage();
                break;
            
            case 'delete-product': 
            case 'delete_product':
                $this->processDeleteProduct();
                break;
            case 'orders':
                $this->ordersPage();
                break;

            case 'export_users':
                $this->export_users();
                break;

            case 'export_farmers':
                $this->export_farmers();
                break;

            
            
            default:
                $this->login();
        }
    }

    private function ensureAdmin() {
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
        header('Location: /RecoltePure/admin/login');
        exit;
    }
}

    private function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            $row = $this->model->getAdminByEmail($email);
            
            if ($row && password_verify($password, $row['password_hash'])) {
                $_SESSION['is_admin'] = true;
                $_SESSION['admin_email'] = $email;
                header('Location: /RecoltePure/admin');
                
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

    


    private function verifyFarmerAction() {
    $farmerId = $_GET['id'] ?? null;
    $status = $_GET['status'] ?? 'Verify'; 

    if ($farmerId) {
        if ($this->model->updateFarmerStatus($farmerId, $status)) {
            header("Location: index.php?page=admin&action=farmers&msg=updated");
            exit;
        }
    }
    header("Location: index.php?page=admin&action=farmers&error=failed");
    exit;
}


    private function usersPage() {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $allUsers = $this->model->getAllUsers($search);

    require 'view/admin/users.php';
    }

    private function toggleUserStatus() {
    $id = $_GET['id'] ?? null;
    $status = $_GET['status'] ?? null; 
    if ($id && $status) {
        $this->model->updateUserStatus($id, $status);
    }
    header('Location: index.php?page=admin&action=users');
    }


    private function deleteUser() {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $this->model->deleteUser($id);
    }
    header('Location: index.php?page=admin&action=users');
}

private function farmersPage() {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $allFarmers = $this->model->getAllFarmersWithPerformance($search);
   
    $stats = [
        'total_farmers' => count($allFarmers),
        'pending_verifications' => 0,
        'total_revenue' => 0.0
    ];

    foreach ($allFarmers as $f) {
        
        if (strtolower($f['account_status'] ?? '') !== 'verify') {
            $stats['pending_verifications']++;
        }
        
        $stats['total_revenue'] += (float)($f['revenue'] ?? 0);
    }

    require 'view/admin/farmers.php';
}



private function viewFarmerProducts() {
    // Change 'farmer_id' to 'id' to match your links
    $farmerId = $_GET['id'] ?? null; 
    
    if ($farmerId) {
        $products = $this->model->getProductsByFarmer($farmerId);
        $allFarmers = $this->model->getAllFarmers();
        $currentFarmer = null;
        
        foreach($allFarmers as $f) {
            // Check if 'farmer_id' is the correct key in your DB array
            if($f['farmer_id'] == $farmerId) {
                $currentFarmer = $f;
                break;
            }
        }

        require 'view/admin/farmer_product.php';
    } else {
        // This is why the page refreshes/redirects if the ID is missing
        header('Location: index.php?page=admin&action=farmers');
    }
}

private function allproductsPage() {
    $products = $this->model->getAllProductsWithDetails();
    $categoryStats = $this->model->getCategoryStats();
    
    require 'view/admin/all_product.php';
}



private function processDeleteProduct() {
    $productId = $_GET['id'] ?? null;

    if ($productId) {
        $success = $this->model->deleteProductById($productId);
        
        if ($success) {
            header('Location: /RecoltePure/admin/all_products?status=deleted');
            exit();
        }
    }
    header('Location: /RecoltePure/admin/all_products?status=error');
}



private function changeStatus() {
    $id = $_GET['id'];
    $newStatus = $_GET['new_status'];
    if ($this->model->updateOrderStatus($id, $newStatus)) {
        header("Location: index.php?page=admin&action=orders&msg=updated");
    }
}


private function ordersPage() {
    $timeframe = $_GET['time'] ?? 'all';
    $status = $_GET['status'] ?? 'all';
    
    $orders = $this->model->getAllOrders($timeframe, $status);
    $statusStats = $this->model->getOrderStatusStats();
    $orderTrend = $this->model->getOrdersTrend();
    
    require 'view/admin/orders.php';
}


public function dashboard() {

    $adminModel = new AdminModel($this->db);
    $allFarmers = $adminModel->getAllFarmersWithPerformance();
    $categoryStats = $adminModel->getCategoryStats();

    $stats = $adminModel->getDashboardStats();

    require 'view/admin/dashboard.php';
}


public function export_users() {

    $this->ensureAdmin(); 

    $adminModel = new AdminModel($this->db);
    
    $search = $_GET['search'] ?? null;

    if ($search) {
        $users = $adminModel->getAllUsers($search);
    } else {
        $users = $adminModel->getAllUsers();
    }

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="users_export_' . date('Y-m-d') . '.csv"');

    $output = fopen('php://output', 'w');

    fputcsv($output, [
        'User ID',
        'Name',
        'Email',
        'Phone',
        'Status',
        'Address'
    ]);

    foreach ($users as $user) {
        fputcsv($output, [
            $user['customer_id'],
            $user['name'],
            $user['email'],
            $user['phone_number'] ?? '',
            $user['status'] ?? 'active',
            $user['address'] ?? ''
        ]);
    }

    fclose($output);
    exit;
}

public function export_farmers() {

     $this->ensureAdmin(); 
    if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
        header('Location: index.php?page=admin&action=login');
        exit;
    }

    $adminModel = new AdminModel($this->db);
    $search = $_GET['search'] ?? null;

    if ($search) {
        $farmers = $adminModel->getAllFarmersWithPerformance($search);
    } else {
        $farmers = $adminModel->getAllFarmersWithPerformance();
    }

    // CSV headers
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="farmers_export_' . date('Y-m-d') . '.csv"');

    $output = fopen('php://output', 'w');

    fputcsv($output, [
        'Farmer ID',
        'Name',
        'Email',
        'Phone',
        'Status',
        'Address',
        'Orders Completed',
        'Revenue (€)'
    ]);

    foreach ($farmers as $farmer) {
        fputcsv($output, [
            $farmer['farmer_id'],
            $farmer['name'],
            $farmer['email'],
            $farmer['phone_number'] ?? '',
            $farmer['account_status'] ?? 'Pending',
            $farmer['address'] ?? '',
            $farmer['orders_completed'] ?? 0,
            $farmer['revenue'] ?? 0
        ]);
    }

    fclose($output);
    exit;
}

}
