<?php
session_start();
include("../db_connection.php");

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = mysqli_real_escape_string($db, $_POST['firstName']);
    $surname = mysqli_real_escape_string($db, $_POST['surname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $certNumber = mysqli_real_escape_string($db, $_POST['certNumber']);
    $verificationDate = mysqli_real_escape_string($db, $_POST['verificationDate']);
    $registrationDate = mysqli_real_escape_string($db, $_POST['registrationDate']);
    $password = $_POST['password'];
    $terms = isset($_POST['terms']) ? 1 : 0;

    if (!$terms) {
        $error = "You must accept terms and privacy policy.";
    } else {
        // Check if email exists
        $check_email = mysqli_query($db, "SELECT * FROM farmer WHERE email='$email'");
        if (mysqli_num_rows($check_email) > 0) {
            $error = "Email already registered!";
        } else {
            // Hash password
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $fullName = $firstName . " " . $surname;

            // Insert into farmer table with password hash
            $stmt = $db->prepare("INSERT INTO farmer (name, email, phone_number, address, certificate_number, verification_date, registration_date, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $fullName, $email, $phone, $address, $certNumber, $verificationDate, $registrationDate, $password_hash);

            if ($stmt->execute()) {
                $success = "registered";
            } else {
                $error = "Error: " . $db->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecoltePure - Farmer Registration</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(180deg, #c8e6a0 0%, #7da86f 50%, #4a6b4a 100%);
            color: #333;
            min-height: 100vh;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 15px 40px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid #4a6b4a;
            background-color: #f5f0e8;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            position: relative;
        }

        .logo-text-top {
            font-size: 9px;
            font-weight: bold;
            color: #4a6b4a;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .logo-icon {
            width: 25px;
            height: 25px;
            margin: 2px 0;
        }

        .logo-text-bottom {
            font-size: 7px;
            color: #4a6b4a;
            text-transform: uppercase;
        }

        .logo-name {
            font-size: 28px;
            font-weight: 600;
            color: #4a6b4a;
        }

        .container {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            min-height: calc(100vh - 90px);
            padding: 40px 20px;
        }

        .left-section {
            flex: 1;
            padding: 60px 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }

        .illustration {
            width: 200px;
            height: 200px;
            margin-bottom: 40px;
        }

        .left-section h1 {
            font-size: 36px;
            color: white;
            margin-bottom: 40px;
            line-height: 1.3;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .feature-list {
            list-style: none;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 18px;
            color: white;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .check-icon {
            width: 24px;
            height: 24px;
            background-color: #7da86f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .check-icon::after {
            content: '✓';
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        .right-section {
            flex: 1;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 60px 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-container h2 {
            font-size: 32px;
            color: white;
            margin-bottom: 40px;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: white;
            font-weight: 500;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            transition: all 0.3s;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-group input:focus {
            outline: none;
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.25);
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 25px 0;
        }

        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: #7da86f;
        }

        .checkbox-group label {
            font-size: 14px;
            color: white;
            line-height: 1.5;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .checkbox-group a {
            color: #c8e6a0;
            text-decoration: none;
            font-weight: 600;
        }

        .checkbox-group a:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background-color: rgba(255, 255, 255, 0.95);
            color: #4a6b4a;
            border: none;
            border-radius: 25px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .submit-btn:hover {
            background-color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.3);
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            color: white;
            font-size: 14px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .social-buttons {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .social-btn {
            flex: 1;
            padding: 14px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            color: white;
        }

        .social-btn:hover {
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .facebook-btn {
            background: rgba(59, 89, 152, 0.4);
            border-color: rgba(59, 89, 152, 0.5);
        }

        .facebook-btn:hover {
            background: rgba(59, 89, 152, 0.5);
        }

        .login-link {
            text-align: center;
            font-size: 14px;
            color: white;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }

        .login-link a {
            color: #c8e6a0;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .footer {
            background: rgba(45, 80, 22, 0.9);
            padding: 20px;
            text-align: center;
            color: white;
            margin-top: 40px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .footer-content p {
            margin: 0;
            font-size: 13px;
        }

        .footer-login-btn {
            display: inline-block;
            padding: 10px 25px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 20px;
            font-weight: 600;
            transition: all 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .footer-login-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
            }

            .left-section, .right-section {
                padding: 40px;
            }
        }

        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .social-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <div class="logo-circle">
                <img src="../assets/uploads/products/logo.png" alt="Logo Icon" class="logo-icon">
            </div>
            <span class="logo-name">RecoltePure</span>
        </div>
    </div>

    <div class="container">
        <div class="left-section">
            <div class="illustration">
            </div>
            <h1>Join Us to Change Food for Good</h1>
            <ul class="feature-list">
                <li class="feature-item">
                    <div class="check-icon"></div>
                    <span>Leader in direct sales</span>
                </li>
                <li class="feature-item">
                    <div class="check-icon"></div>
                    <span>Certified organic farmers</span>
                </li>
                <li class="feature-item">
                    <div class="check-icon"></div>
                    <span>Refund or replacement for defects</span>
                </li>
                <li class="feature-item">
                    <div class="check-icon"></div>
                    <span>98.44% issue-free delivery</span>
                </li>
            </ul>
        </div>

        <div class="right-section">
            <div class="form-container">
                <h2>Create account</h2>
                <form method="POST" action="registration.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First name</label>
                            <input type="text" id="firstName" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="surname">Surname</label>
                            <input type="text" id="surname" name="surname" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone number</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="certNumber">Certification number</label>
                            <input type="text" id="certNumber" name="certNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="verificationDate">Verification date</label>
                            <input type="date" id="verificationDate" name="verificationDate" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="registrationDate">Registration date</label>
                        <input type="date" id="registrationDate" name="registrationDate" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="password" name="password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">🔒</button>
                        </div>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            I have read and accept <a href="#">the conditions</a> and <a href="#">the privacy policy</a>
                        </label>
                    </div>

                    <button type="submit" class="submit-btn">Sign Up</button>

                    <div class="login-link">
                        Already have an account? <a href="login.php">Log In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 RecoltePure. All rights reserved.</p>
            <a href="login.php" class="footer-login-btn">Login</a>
        </div>
    </footer>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleBtn = document.querySelector('.password-toggle');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtn.textContent = '🔓';
            } else {
                passwordInput.type = 'password';
                toggleBtn.textContent = '🔒';
            }
        }

        // Set today's date as default for registration date
        document.getElementById('registrationDate').valueAsDate = new Date();

        // Show success modal if registration was successful
        <?php if ($success === "registered") { ?>
        window.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('successModal');
            modal.style.display = 'flex';
            
            // Auto-redirect to login after 3 seconds
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 3000);
        });
        <?php } ?>
    </script>

    <!-- Success Modal -->
    <div id="successModal" class="success-modal" style="display: none;">
        <div class="success-modal-content">
            <div class="success-icon">✓</div>
            <h2>Registration Successful!</h2>
            <p>Your account has been created. You will be redirected to login in a moment.</p>
            <a href="login.php" class="btn btn-primary">Go to Login Now</a>
        </div>
    </div>

    <style>
        .success-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .success-modal-content {
            background: white;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            max-width: 400px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            font-size: 64px;
            color: #4a7c2c;
            margin-bottom: 20px;
        }

        .success-modal-content h2 {
            font-size: 24px;
            color: #2d5016;
            margin-bottom: 15px;
        }

        .success-modal-content p {
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .success-modal-content .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #2d5016 0%, #4a7c2c 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .success-modal-content .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 80, 22, 0.3);
        }
    </style>
</body>
</html>