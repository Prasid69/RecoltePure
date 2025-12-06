<?php
ob_start(); 
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("db_connection.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!$db) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // --- CHECK FARMER ---
    $sql_farmers = "SELECT * FROM farmer WHERE email='$username' AND password='$password'";
    $result_farmers = mysqli_query($db, $sql_farmers);

    if ($result_farmers && mysqli_num_rows($result_farmers) == 1) {
        $_SESSION['login_user'] = $username;
        $_SESSION['role'] = "farmer";
        header("Location: homepage.php");
        exit();
    }

    // --- CHECK USER ---
    $sql_users = "SELECT * FROM users WHERE email='$username' AND password='$password'";
    $result_users = mysqli_query($db, $sql_users);

    if ($result_users && mysqli_num_rows($result_users) == 1) {
        $_SESSION['login_user'] = $username;
        $_SESSION['role'] = "customer";
        header("Location: homepage.php");
        exit();
    }

    // If we reach here, no user was found
    $error = "Invalid Username or Password!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RecoltePure</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
    <style>
        /* Small inline style for the error message */
        .error-msg {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="left-panel">
            <div class="panel-content-bottom">
                <div class="user-profile">
                    <div class="user-info"></div>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="header"></div>

            <div class="form-container">
                <div class="welcome-text">
                    <h2>Welcome <br>to RecoltePure</h2>
                </div>

                <form method="POST" action="">
                    
                    <?php if(!empty($error)) { ?>
                        <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
                    <?php } ?>

                    <div class="input-group">
                        <input type="email" name="username" placeholder="Email" class="input-field" required>
                    </div>
                    
                    <div class="input-group">
                        <input type="password" name="password" id="password" placeholder="Password" class="input-field" required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>

                    <a href="#" class="forgot-link">Forgot password?</a>

                    <div class="divider">
                        <span>or</span>
                    </div>

                    <button type="button" class="btn btn-google">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google Logo" width="20" height="20">
                        Login with Google
                    </button>

                    <button type="submit" class="btn btn-primary">Login</button>

                    <p class="signup-text">
                        Don't have an account? <a href="#">Sign up</a>
                    </p>
                </form>
            </div>

            <div class="social-footer">
                <img class="social-icon" src="https://cdn-icons-png.flaticon.com/512/124/124010.png" width="20" height="20" alt="Facebook">
                <img class="social-icon" src="https://cdn-icons-png.flaticon.com/512/733/733579.png" width="20" height="20" alt="Twitter">
                <img class="social-icon" src="https://cdn-icons-png.flaticon.com/512/174/174857.png" width="20" height="20" alt="LinkedIn">
                <img class="social-icon" src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" width="20" height="20" alt="Instagram">
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>
</html>