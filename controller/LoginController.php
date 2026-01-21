<?php
require_once 'config/db_connection.php';
require_once 'model/UserModel.php';

class LoginController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new UserModel($dbConnection);
    }

    public function handleRequest() {
        
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            
            $role = isset($_POST['role']) ? $_POST['role'] : 'user'; 

            $loggedInUser = $this->model->login($email, $password, $role);

            if ($loggedInUser) {
                $_SESSION['user_id'] = $loggedInUser['id'];  
                $_SESSION['login_user'] = $loggedInUser['name']; 
                $_SESSION['role'] = $role;
                header("Location: /RecoltePure/profile");
                exit();

            } else {
                $error = "Invalid email or password.";
            }
        }
        
        require_once 'view/login.php';
    }
}
?>