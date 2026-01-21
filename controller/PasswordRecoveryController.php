<?php

require_once 'model/PasswordRecovery.php';
require_once 'config/db_connection.php';

class RecoveryController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new RecoveryModel($dbConnection);
    }

    public function handleRequest() {
        $message = '';
        $resetLink = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            if ($email === '') {
                $message = 'Please enter your email.';
            } else {
                if ($this->model->emailExists($email)) {
              
                    $token = bin2hex(random_bytes(16));
                    
                    $_SESSION['pwd_reset'] = $_SESSION['pwd_reset'] ?? [];
                    
                    $_SESSION['pwd_reset'][$email] = [
                        'token' => $token, 
                        'created' => time()
                    ];
                    $resetLink = "http://localhost/RecoltePure/index.php?page=reset_password&email=" . urlencode($email) . "&token=" . urlencode($token);
                    
                    $message = 'A recovery link has been generated below (local test).';
                } else {
                   
                    $message = 'Email address not found.';
                }
            }
        }
        include 'view/password_recovery.php';
    }
}
?>