<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecoltePure - Registration</title>
    <link rel="stylesheet" href="assets/css/registration.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <div class="logo-circle">
                <img src="assets/uploads/products/Logo.png" alt="Logo Icon" class="logo-icon">
            </div>
            <span class="logo-name">RecoltePure</span>
        </div>
    </div>

    <div class="container">
        <div class="left-section">
             <h1>Join Us to Change Food for Good</h1>
             <ul class="feature-list">
                <li class="feature-item"><div class="check-icon"></div><span>Leader in direct sales</span></li>
                <li class="feature-item"><div class="check-icon"></div><span>Certified organic farmers</span></li>
                <li class="feature-item"><div class="check-icon"></div><span>Refund or replacement for defects</span></li>
                <li class="feature-item"><div class="check-icon"></div><span>98.44% issue-free delivery</span></li>
             </ul>
        </div>

        <div class="right-section">
            <div class="form-container">
                <h2>Create account</h2>
                
                <?php if (isset($error) && !empty($error)): ?>
                    <div style="background: #ffcfcc; color: #a61b1b; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?page=register">
                    
                    <div class="form-group">
                        <label for="role">Register as</label>
                        <select id="role" name="role" required>
                            <option value="user">User</option>
                            <option value="farmer">Farmer</option>
                        </select>
                    </div>

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
                        <div class="form-group" id="certNumberGroup">
                            <label for="certNumber">Certification number (Farmers only)</label>
                            <input type="text" id="certNumber" name="certNumber" placeholder="Enter certificate number (optional)">
                        </div>
                        
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
                        Already have an account? <a href="index.php?page=login">Log In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 RecoltePure. All rights reserved.</p>
            
        </div>
    </footer>

    <div id="successModal" class="success-modal" style="display: none;">
        <div class="success-modal-content">
            <div class="success-icon">✓</div>
            <h2>Registration Successful!</h2>
            <p>Your account has been created. You will be redirected to login in a moment.</p>
            <a href="index.php?page=login" class="btn btn-primary">Go to Login Now</a>
        </div>
    </div>

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

        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const certGroup = document.getElementById('certNumberGroup');
            const certInput = document.getElementById('certNumber');

            function updateCertVisibility() {
                if (roleSelect && roleSelect.value === 'farmer') {
                    certGroup.style.display = 'block';
                } else {
                    certGroup.style.display = 'none';
                    certInput.value = '';
                }
            }
            updateCertVisibility();
            if (roleSelect) {
                roleSelect.addEventListener('change', updateCertVisibility);
            }

            // Success Modal Trigger
            <?php if (isset($success) && $success === "registered") { ?>
                const modal = document.getElementById('successModal');
                modal.style.display = 'flex';
                setTimeout(function() {
                    window.location.href = 'index.php?page=login';
                }, 3000);
            <?php } ?>
        });
    </script>
</body>
</html>