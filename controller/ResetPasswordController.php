<?php

require_once 'model/ResetPassword.php';
require_once 'config/db_connection.php';

class ResetPasswordController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new ResetPasswordModel($dbConnection);
    }

    public function handleRequest() {
        
        $email = $_GET['email'] ?? '';
        $token = $_GET['token'] ?? '';
        $error = '';
        $success = '';
        $valid = false;
        if (!empty($email) && !empty($token) && isset($_SESSION['pwd_reset'][$email])) {
            $entry = $_SESSION['pwd_reset'][$email];
            if ($entry['token'] === $token && (time() - $entry['created']) < 1800) {
                $valid = true;
            } else {
                $error = 'Reset link expired. Please generate a new one.';
            }
        } else {
            $error = 'Invalid reset link. Please generate a new one.';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid) {
            $new = $_POST['new_password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if ($new === '' || $confirm === '') {
                $error = 'Please enter and confirm your new password.';
            } elseif ($new !== $confirm) {
                $error = 'Passwords do not match.';
            } else {
                $hash = password_hash($new, PASSWORD_BCRYPT);
                
                if ($this->model->updatePassword($email, $hash)) {
                    $success = 'Password updated successfully. Redirecting to login...';
                    $valid = false; 
                    
                    unset($_SESSION['pwd_reset'][$email]);
                } else {
                    $error = 'Unable to update password. Please try again.';
                }
            }
        }

        include 'view/reset_password.php';
    }
}
?>