<?php
require 'config/db_connection.php';

$message = '';
$resetLink = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if ($email === '') {
        $message = 'Please enter your email.';
    } else {

        $exists = false;
        $stmt = $db->prepare('SELECT 1 FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $exists = $stmt->get_result()->num_rows > 0;
        if (!$exists) {
            $stmt = $db->prepare('SELECT 1 FROM farmer WHERE email = ? LIMIT 1');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $exists = $stmt->get_result()->num_rows > 0;
        }

        $token = bin2hex(random_bytes(16));
        $_SESSION['pwd_reset'] = $_SESSION['pwd_reset'] ?? [];

        $_SESSION['pwd_reset'][$email] = ['token' => $token, 'created' => time()];
        $resetLink = 'http://' . $_SERVER['HTTP_HOST'] . '/view/reset_password.php?email=' . urlencode($email) . '&token=' . urlencode($token);
        $message = 'If this email is registered, a recovery link has been generated below (local test).';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery | RecoltePure</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: Inter, Arial, sans-serif;
            background: #f5f6f8;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            max-width: 420px;
            margin: 60px auto;
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        .btn {
            width: 100%;
            padding: 10px 14px;
            border: none;
            border-radius: 8px;
            background: #2d7a2d;
            color: #fff;
            cursor: pointer;
        }

        .btn:hover {
            background: #246124;
        }

        .input-box {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #ddd;
            padding: 10px 12px;
            border-radius: 8px;
            background: #fafafa;
        }

        .input-box input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
        }

        .login-link {
            margin-top: 12px;
            text-align: center;
        }

        .notice {
            margin-top: 12px;
            padding: 10px;
            background: #e7f3ff;
            border: 1px solid #cbe1ff;
            color: #0b5ed7;
            border-radius: 8px;
            font-size: 14px;
            word-break: break-all;
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .login-link a {
            color: #2d7a2d;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <form method="POST" action="index.php?page=password_recovery">
            <h1>Password Recovery</h1>

            <div class="input-box" style="margin-top:12px;">
                <i class='bx bxs-envelope'></i>
                <input type="email" name="email" placeholder="Enter your registered email" required>
            </div>

            <button type="submit" class="btn" style="margin-top:14px;">Send Recovery Link</button>

            <?php if (!empty($message)): ?>
                <div class="notice"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <?php if (!empty($resetLink)): ?>
                <div class="notice" style="margin-top:8px;">
                    <strong>Localhost Test Link:</strong><br>
                    <a href="index.php?page=reset_password&email=<?= urlencode($email) ?>&token=<?= urlencode($token) ?>">Open
                        Password Reset</a>
                </div>
            <?php endif; ?>

            <div class="login-link">
                <p>Remembered your password? <a href="index.php?page=login">Login</a></p>
            </div>
        </form>
    </div>
</body>

</html>