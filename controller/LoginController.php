<?php
require_once 'config/db_connection.php';
require_once 'model/UserModel.php';

class LoginController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new UserModel($dbConnection);
    }

    public function handleRequest() {
        // 1. Start Session immediately
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            // Default role to 'user' if not sent by form
            $role = isset($_POST['role']) ? $_POST['role'] : 'user'; 

            // 2. Authenticate User
            // This calls the login() function in UserModel
            $loggedInUser = $this->model->login($email, $password, $role);

            if ($loggedInUser) {
                // --- CRITICAL STEP: STORE DATA FOR OTHER FILES ---
                
                // This saves the ID (e.g., 5) so UserController can see it
                $_SESSION['user_id'] = $loggedInUser['id'];  
                
                // This saves the Name (e.g., "John") for the Header
                $_SESSION['login_user'] = $loggedInUser['name']; 
                
                // This saves the Role (e.g., "farmer") for permissions
                $_SESSION['role'] = $role;

                // 3. Redirect to Profile
                // Now that session is set, UserController will NOT redirect you back
                header("Location: index.php?page=profile");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        }
        
        require_once 'view/login.php';
    }
}
?>