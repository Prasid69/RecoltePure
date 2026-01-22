<?php include 'view/layout/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - RecoltePure</title>
    <link rel="stylesheet" href="assets/css/homepage.css">
    <style>
        .contact-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .contact-header h1 {
            color: #2c7a3f;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .contact-header p {
            color: #666;
            font-size: 1.1rem;
        }

        .contact-form {
            display: grid;
            gap: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group textarea {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #2c7a3f;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #2c7a3f 0%, #1e5a2e 100%);
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(44, 122, 63, 0.3);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .contact-info {
            margin-top: 40px;
            padding-top: 40px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
        }

        .contact-info h2 {
            color: #2c7a3f;
            margin-bottom: 20px;
        }

        .info-items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .info-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .info-item strong {
            color: #2c7a3f;
            display: block;
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }

            .contact-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="contact-container">
        <div class="contact-header">
            <h1>Get in Touch</h1>
            <p>Have questions? We'd love to hear from you!</p>
        </div>

        <?php if (isset($successMsg) && $successMsg): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($successMsg); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errorMsg) && $errorMsg): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($errorMsg); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=contact" class="contact-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="firstName">First Name *</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name *</label>
                    <input type="text" id="lastName" name="lastName" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone">
                </div>
            </div>

            <div class="form-group">
                <label for="subject">Subject *</label>
                <input type="text" id="subject" name="subject" required>
            </div>

            <div class="form-group">
                <label for="message">Message *</label>
                <textarea id="message" name="message" required></textarea>
            </div>

            <button type="submit" class="submit-btn">Send Message</button>
        </form>

        <div class="contact-info">
            <h2>Contact Information</h2>
            <div class="info-items">
                <div class="info-item">
                    <strong>Email</strong>
                    <p>support@recoltepure.com</p>
                </div>
                <div class="info-item">
                    <strong>Phone</strong>
                    <p>+1 (555) 123-4567</p>
                </div>
                <div class="info-item">
                    <strong>Hours</strong>
                    <p>Mon-Fri: 9AM-6PM</p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'view/layout/footer.php'; ?>
</body>

</html>