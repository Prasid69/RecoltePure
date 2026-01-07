<?php
// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment helper
require_once __DIR__ . '/env.php';

// Stripe Configuration - prefer environment variables
// Get your keys from: https://dashboard.stripe.com/apikeys
$stripe_publishable_key = env('STRIPE_PUBLISHABLE_KEY', '');
$stripe_secret_key      = env('STRIPE_SECRET_KEY', '');

// App + Payment settings
$app_url            = rtrim(env('APP_URL', 'http://localhost/RecoltePure'), '/');
$payment_currency   = env('PAYMENT_CURRENCY', 'USD');
$statement_name     = env('PAYMENT_STATEMENT', 'RecoltePure');

// Set Stripe API version and key (no-ops if key missing but keeps code paths consistent)
\Stripe\Stripe::setApiVersion("2024-04-10");
if (!empty($stripe_secret_key)) {
    \Stripe\Stripe::setApiKey($stripe_secret_key);
}

// Payment configuration
$payment_config = array(
    'currency' => $payment_currency,
    'publishable_key' => $stripe_publishable_key,
    'secret_key' => $stripe_secret_key,
    'statement_descriptor' => $statement_name,
    // Ensure these match routing in index.php (uses ?page=...)
    'success_url' => $app_url . '/index.php?page=payment_success',
    'cancel_url' => $app_url . '/index.php?page=payment_cancel'
);
?>
