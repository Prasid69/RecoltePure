<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - RecoltePure</title>
    <link rel="stylesheet" href="assets/css/cart.css">
    <style>
        .success-container {
            max-width: 500px;
            margin: 100px auto;
            padding: 40px;
            background: white;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #27ae60;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
        }

        .success-title {
            color: #27ae60;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .success-message {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .payment-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            text-align: left;
            margin-bottom: 30px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-primary {
            background: #27ae60;
            color: white;
        }

        .btn-primary:hover {
            background: #229954;
        }

        .btn-secondary {
            background: #ecf0f1;
            color: #333;
        }

        .btn-secondary:hover {
            background: #d5dbdb;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✓</div>
        <h1 class="success-title">Payment Successful!</h1>
        <p class="success-message">
            Your payment has been processed successfully. Thank you for your order!
        </p>

        <div class="payment-details">
            <div class="detail-row">
                <span>Payment Status:</span>
                <strong style="color: #27ae60;">Completed</strong>
            </div>
            <div class="detail-row">
                <span>Payment Method:</span>
                <strong>Stripe</strong>
            </div>
            <div class="detail-row">
                <span>Order Date:</span>
                <strong><?php echo date('M d, Y H:i A'); ?></strong>
            </div>
        </div>

        <div class="action-buttons">
            <a href="index.php?page=my_orders" class="btn btn-primary">View Orders</a>
            <a href="index.php?page=home" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>
</body>
</html>
