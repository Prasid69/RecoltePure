<?php
/**
 * Stripe Payment Controller
 * Handles Stripe checkout sessions and payment verification
 */

require_once 'config/db_connection.php';
require_once 'model/Orders.php';

class StripeController
{
    private $db;
    private $orderModel;
    private $stripeConfig;

    public function __construct($db)
    {
        $this->db = $db;
        $this->orderModel = new OrderModel($db);
        $this->stripeConfig = include __DIR__ . '/../config/stripe_config.php';
    }

    /**
     * Create Stripe Checkout Session
     * Redirects user to Stripe payment page
     */
    public function createCheckoutSession()
    {
        error_log("StripeController::createCheckoutSession() - Method called");

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check user is logged in
        if (!isset($_SESSION['user_id'])) {
            error_log("User not logged in - redirecting to login");
            $_SESSION['error_message'] = "Please login to checkout";
            header("Location: index.php?page=login");
            exit();
        }
        error_log("User logged in: " . $_SESSION['user_id']);

        // Check cart is not empty
        if (empty($_SESSION['cart'])) {
            error_log("Cart is empty - redirecting to cart");
            $_SESSION['error_message'] = "Your cart is empty";
            header("Location: index.php?page=cart");
            exit();
        }
        error_log("Cart has items: " . count($_SESSION['cart']));

        // Debug: Output session and cart state
        try {
            file_put_contents(__DIR__ . '/../debug_session.log', "[CheckoutSession] SESSION: " . print_r($_SESSION, true) . "\n", FILE_APPEND);
        } catch (Exception $e) {
            error_log("Could not write to debug_session.log: " . $e->getMessage());
        }

        $cartItems = $_SESSION['cart'];
        $lineItems = [];
        $totalAmount = 0;

        error_log("Building Stripe line items...");

        // Build Stripe line items from cart
        foreach ($cartItems as $productId => $item) {
            $unitPrice = floatval($item['price']);
            $quantity = intval($item['quantity']);
            $totalAmount += ($unitPrice * $quantity);

            // Prepare image URL (must be absolute)
            // Fix: URL encode the segments to handle spaces and special characters in filenames
            $imagePath = $item['image'];
            $pathSegments = explode('/', $imagePath);
            $encodedSegments = array_map('rawurlencode', $pathSegments);
            $imageUrl = $this->stripeConfig['app_url'] . '/' . implode('/', $encodedSegments);

            $lineItems[] = [
                'price_data' => [
                    'currency' => $this->stripeConfig['currency'],
                    'product_data' => [
                        'name' => $item['name'],
                        'images' => [$imageUrl],
                    ],
                    'unit_amount' => (int) ($unitPrice * 100), // Convert to cents
                ],
                'quantity' => $quantity,
            ];
            error_log("Added item: " . $item['name'] . " x" . $quantity);
        }

        error_log("Total amount: $" . $totalAmount);
        error_log("Calling Stripe API createCheckoutSession...");

        try {
            $successUrl = $this->stripeConfig['app_url'] . '/index.php?page=checkout&status=success&session_id={CHECKOUT_SESSION_ID}';
            $cancelUrl = $this->stripeConfig['app_url'] . '/index.php?page=cart&status=cancelled';

            error_log("Success URL: " . $successUrl);
            error_log("Cancel URL: " . $cancelUrl);

            // Create Stripe Checkout Session
            $checkoutSession = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'customer_email' => $_SESSION['login_user'] ?? null,
                'metadata' => [
                    'user_id' => $_SESSION['user_id'],
                    'customer_name' => $_SESSION['user_name'] ?? 'Guest'
                ],
                // Simplified for testing - removed shipping address collection
                'billing_address_collection' => 'auto',
            ]);

            error_log("Stripe session created successfully! ID: " . $checkoutSession->id);
            error_log("Stripe checkout URL: " . $checkoutSession->url);

            // Store session details for verification
            $_SESSION['stripe_session_id'] = $checkoutSession->id;
            $_SESSION['checkout_amount'] = $totalAmount;
            // Store cart with session id as backup for payment return
            $_SESSION['cart_backup_' . $checkoutSession->id] = $cartItems;

            error_log("About to redirect to: " . $checkoutSession->url);

            // Redirect to Stripe Checkout
            header("Location: " . $checkoutSession->url);
            exit();

        } catch (\Stripe\Exception\ApiErrorException $e) {
            error_log("STRIPE API ERROR: " . $e->getMessage());
            error_log("Error type: " . get_class($e));
            error_log("Error HTTP status: " . (method_exists($e, 'getHttpStatus') ? $e->getHttpStatus() : 'N/A'));

            $_SESSION['error_message'] = "Payment Error: " . $e->getMessage();
            header("Location: index.php?page=cart");
            exit();
        } catch (Exception $e) {
            error_log("GENERAL EXCEPTION in createCheckoutSession: " . $e->getMessage());
            error_log("Exception trace: " . $e->getTraceAsString());

            $_SESSION['error_message'] = "System Error: " . $e->getMessage();
            header("Location: index.php?page=cart");
            exit();
        }
    }

    /**
     * Handle successful payment
     * Verifies payment and creates order
     */
    public function handleSuccess()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_GET['session_id'])) {
            header("Location: index.php?page=cart");
            exit();
        }

        $sessionId = $_GET['session_id'];

        // Debug: Output session and cart state after payment
        file_put_contents(__DIR__ . '/../debug_session.log', "[HandleSuccess] SESSION: " . print_r($_SESSION, true) . "\n", FILE_APPEND);

        try {
            // Retrieve the session from Stripe
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            // Verify payment was successful
            if ($session->payment_status === 'paid') {
                $userId = $session->metadata->user_id;
                $cartItems = $_SESSION['cart'] ?? [];
                // Restore cart from backup if missing
                if (empty($cartItems) && isset($_SESSION['cart_backup_' . $sessionId])) {
                    $cartItems = $_SESSION['cart_backup_' . $sessionId];
                }
                // Debug: Output cart state after restore attempt
                file_put_contents(__DIR__ . '/../debug_session.log', "[HandleSuccess] Cart after restore: " . print_r($cartItems, true) . "\n", FILE_APPEND);
                if (empty($cartItems)) {
                    $_SESSION['error_message'] = "Cart is empty after payment. Please contact support.";
                    header("Location: index.php?page=home");
                    exit();
                }

                // Get payment details
                $paymentIntentId = $session->payment_intent;
                $amountPaid = $session->amount_total / 100; // Convert from cents
                $paymentMethod = 'Stripe Card Payment';

                // Create order in database with payment info
                $orderId = $this->orderModel->createOrderWithPayment(
                    $userId,
                    $cartItems,
                    $paymentIntentId,
                    $paymentMethod,
                    $amountPaid
                );

                if ($orderId) {
                    // Clear cart and session data
                    unset($_SESSION['cart']);
                    unset($_SESSION['stripe_session_id']);
                    unset($_SESSION['checkout_amount']);
                    unset($_SESSION['cart_backup_' . $sessionId]);

                    // Redirect to success page
                    $_SESSION['success_message'] = "Payment successful! Order ID: #" . $orderId;
                    header("Location: index.php?page=my_orders&success=payment_completed");
                    exit();
                } else {
                    throw new Exception("Failed to create order in database");
                }

            } else {
                // Payment not completed
                $_SESSION['error_message'] = "Payment was not completed. Status: " . $session->payment_status;
                header("Location: index.php?page=cart");
                exit();
            }

        } catch (\Stripe\Exception\ApiErrorException $e) {
            $_SESSION['error_message'] = "Payment Verification Failed: " . $e->getMessage();
            header("Location: index.php?page=cart");
            exit();
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Order Creation Failed: " . $e->getMessage();
            header("Location: index.php?page=cart");
            exit();
        }
    }

    /**
     * Handle cancelled checkout
     */
    public function handleCancel()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['error_message'] = "Checkout was cancelled. Your items are still in the cart.";
        header("Location: index.php?page=cart");
        exit();
    }

    /**
     * Get publishable key for frontend
     */
    public function getPublishableKey()
    {
        return $this->stripeConfig['publishable_key'];
    }
}
?>