<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Cancelled - RecoltePure</title>
    <link rel="stylesheet" href="../assets/css/cart.css">
    <style>
        .cancel-container {
            max-width: 500px;
            margin: 100px auto;
            padding: 40px;
            background: white;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .cancel-icon {
            width: 80px;
            height: 80px;
            background: #e74c3c;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
            color: white;
        }

        .cancel-title {
            color: #e74c3c;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .cancel-message {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
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
    <div class="cancel-container">
        <div class="cancel-icon">✕</div>
        <h1 class="cancel-title">Payment Cancelled</h1>
        <p class="cancel-message">
            Your payment has been cancelled. Your order has not been processed.<br>
            You can update your payment details and try again.
        </p>

        <div class="action-buttons">
            <a href="index.php?page=cart" class="btn btn-primary">Back to Cart</a>
            <a href="index.php?page=home" class="btn btn-secondary">Continue Shopping</a>
        </div>
    </div>
</body>
</html>
