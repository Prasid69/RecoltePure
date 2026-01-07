<?php
// Session should already be started in index.php
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

// Get order/delivery information from POST or GET
$delivery_id = isset($_POST['delivery_id']) ? intval($_POST['delivery_id']) : (isset($_GET['delivery_id']) ? intval($_GET['delivery_id']) : null);
$order_total = isset($_POST['total']) ? floatval($_POST['total']) : (isset($_GET['total']) ? floatval($_GET['total']) : 0);

// If no delivery_id, calculate from cart
if (!$delivery_id && !empty($_SESSION['cart'])) {
    // Create a delivery record and persist the cart items as an order
    require_once __DIR__ . '/../config/db_connection.php';
    
    $customer_id = $_SESSION['user_id'];
    $delivery_date = date('Y-m-d', strtotime('+2 days'));
    $order_datetime = date('Y-m-d H:i:s');
    
    // Insert delivery record
    $query = "INSERT INTO delivery (delivery_date, delivery_status, delivery_partner, tracking_number) 
              VALUES (?, 'Pending', 'Processing', 'N/A')";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $delivery_date);
    $stmt->execute();
    $delivery_id = $db->insert_id;
    $stmt->close();

    // Insert each cart item into order_or_cart so it shows up in My Orders
    $itemQuery = "INSERT INTO order_or_cart (customer_id, delivery_id, product_id, quantity, total_price, delivery_date) 
                  VALUES (?, ?, ?, ?, ?, ?)";
    $itemStmt = $db->prepare($itemQuery);
    $itemStmt->bind_param("iiiids", $customer_id, $delivery_id, $productId, $quantity, $lineTotal, $order_datetime);

    $order_total = 0;
    foreach ($_SESSION['cart'] as $productId => $product) {
        $quantity = (int)($product['quantity'] ?? 1);
        $lineTotal = (float)$product['price'] * $quantity;
        $order_total += $lineTotal;
        $itemStmt->execute();
    }
    $itemStmt->close();
}

if (!$delivery_id || $order_total <= 0) {
    die("<h2>Invalid order information</h2><p><a href='index.php?page=cart'>Return to cart</a></p>");
}

// Get Stripe public key
require_once __DIR__ . '/../config/stripe_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - RecoltePure</title>
    <link rel="stylesheet" href="../assets/css/cart.css">
    <style>
        .checkout-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .checkout-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
            font-weight: 600;
        }

        .order-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
        }

        .order-summary h3 {
            margin-top: 0;
            color: #333;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: 600;
            font-size: 18px;
            padding-top: 15px;
            color: #27ae60;
        }

        .payment-form {
            background: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        #card-element {
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 4px;
            background: white;
        }

        #card-errors {
            color: #dc3545;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .payment-button {
            width: 100%;
            padding: 14px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .payment-button:hover {
            background: #229954;
        }

        .payment-button:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
        }

        .spinner {
            color: white;
            display: inline-block;
            border: 4px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top: 4px solid white;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: none;
        }

        .info-text {
            color: #666;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #27ae60;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <h1 class="checkout-title">Secure Payment</h1>

        <div class="order-summary">
            <h3>Order Summary</h3>
            <div class="summary-row">
                <span>Delivery ID:</span>
                <span>#<?php echo htmlspecialchars($delivery_id); ?></span>
            </div>
            <div class="summary-row">
                <span>Order Total:</span>
                <span>$<?php echo number_format($order_total, 2); ?></span>
            </div>
        </div>

        <div class="success-message" id="successMessage">
            <strong>Success!</strong> Your payment has been processed. Redirecting...
        </div>

        <form id="payment-form" class="payment-form">
            <input type="hidden" id="delivery-id" value="<?php echo htmlspecialchars($delivery_id); ?>">
            <input type="hidden" id="order-total" value="<?php echo htmlspecialchars($order_total); ?>">

            <div class="form-group">
                <label for="card-element">Credit or debit card</label>
                <div id="card-element"></div>
                <div id="card-errors" role="alert"></div>
            </div>

            <button type="submit" class="payment-button" id="submit-button">
                <span id="button-text">Pay $<?php echo number_format($order_total, 2); ?></span>
            </button>

            <p class="info-text">
                🔒 Your payment is secure and encrypted with Stripe
            </p>
        </form>

        <div class="back-link">
            <a href="index.php?page=cart">← Back to Cart</a>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('<?php echo htmlspecialchars($payment_config['publishable_key']); ?>');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        // Handle real-time validation errors from the card Element
        cardElement.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        // Handle form submission
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', handleSubmit);

        async function handleSubmit(e) {
            e.preventDefault();

            const submitButton = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            submitButton.disabled = true;

            // Show loading spinner
            buttonText.innerHTML = '<div class="spinner"></div>Processing...';

            const deliveryId = document.getElementById('delivery-id').value;
            const orderTotal = document.getElementById('order-total').value;

            try {
                // Create payment intent
                const response = await fetch('index.php?page=create_payment_intent', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        delivery_id: deliveryId,
                        order_total: parseFloat(orderTotal)
                    })
                });

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.error || 'Failed to create payment intent');
                }

                // Confirm payment
                const result = await stripe.confirmCardPayment(data.client_secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: document.querySelector('input[name="cardholder-name"]')?.value || 'Customer'
                        }
                    }
                });

                if (result.error) {
                    throw new Error(result.error.message);
                } else if (result.paymentIntent.status === 'succeeded') {
                    // Show success message
                    document.getElementById('successMessage').style.display = 'block';
                    form.style.display = 'none';

                    // Redirect to success page
                    setTimeout(function() {
                        window.location.href = 'index.php?page=payment_success&payment_intent=' + result.paymentIntent.id;
                    }, 2000);
                }
            } catch (error) {
                document.getElementById('card-errors').textContent = error.message;
            } finally {
                submitButton.disabled = false;
                buttonText.textContent = 'Pay $' + parseFloat(orderTotal).toFixed(2);
            }
        }
    </script>
</body>
</html>
