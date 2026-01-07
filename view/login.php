<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RecoltePure</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">

    <!-- External CSS -->
    <link rel="stylesheet" href="/RecoltePure/assets/css/login.css">

    <style>
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

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s, opacity 0.3s;
        }

        .social-link:hover {
            transform: scale(1.2);
            opacity: 0.8;
        }
    </style>
</head>

<body>

<div class="login-card">

    <!-- LEFT PANEL -->
    <div class="left-panel">
        <div class="panel-content-bottom">
            <div class="user-profile">
                <div class="user-info"></div>
            </div>
        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="right-panel">

        <div class="header"></div>

        <div class="form-container">

            <div class="welcome-text">
                <h2>Welcome <br>to RecoltePure</h2>
            </div>

            <!-- LOGIN FORM -->
            <form method="POST" action="/RecoltePure/index.php?page=login">


                <!-- ERROR MESSAGE FROM CONTROLLER -->
                <?php if (!empty($error)) : ?>
                    <div class="error-msg">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <div class="input-group">
                    <input 
                        type="email" 
                        name="username" 
                        placeholder="Email" 
                        class="input-field" 
                        required
                    >
                </div>

                <div class="input-group">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="Password" 
                        class="input-field" 
                        required
                    >

                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </div>

                <a href="index.php?page=password_recovery" class="forgot-link">Forgot password?</a>

                <button type="submit" class="btn btn-primary">Login</button>

                <p class="signup-text">
                    Don't have an account?
                    <a href="index.php?page=register">Sign up</a>
                </p>

            </form>
        </div>

        <!-- SOCIAL FOOTER -->
        <div class="social-footer">
           
        </div>

    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    }
</script>

</body>
</html>
