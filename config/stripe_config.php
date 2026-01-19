<?php
/**
 * Stripe Configuration
 * Loads Stripe API keys and initializes the Stripe SDK
 */

// Load environment variables
require_once __DIR__ . '/env_loader.php';

// Check if Stripe SDK is installed
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    // Friendly error message for missing Stripe SDK
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Stripe SDK Not Installed</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
            .error-box { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 20px; border-radius: 5px; }
            .code-box { background: #f8f9fa; padding: 15px; margin: 15px 0; border-left: 4px solid #007bff; font-family: monospace; }
            h1 { color: #dc3545; }
            .step { margin: 15px 0; }
            .step-number { background: #007bff; color: white; padding: 5px 10px; border-radius: 50%; margin-right: 10px; }
        </style>
    </head>
    <body>
        <div class="error-box">
            <h1>⚠️ Stripe SDK Not Installed</h1>
            <p>The Stripe payment library is required but not found. Please install it using Composer.</p>
            
            <h3>Quick Fix (3 Steps):</h3>
            
            <div class="step">
                <span class="step-number">1</span>
                <strong>Install Composer (if not installed)</strong><br>
                Download from: <a href="https://getcomposer.org/download/" target="_blank">https://getcomposer.org/download/</a>
            </div>
            
            <div class="step">
                <span class="step-number">2</span>
                <strong>Open Command Prompt and navigate to your project</strong>
                <div class="code-box">cd C:\\xampp\\htdocs\\RecoltePure</div>
            </div>
            
            <div class="step">
                <span class="step-number">3</span>
                <strong>Install Stripe SDK</strong>
                <div class="code-box">composer require stripe/stripe-php</div>
            </div>
            
            <p><strong>After installation, refresh this page.</strong></p>
            
            <p style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ccc;">
                <small>Technical details: Looking for file: ' . $autoloadPath . '</small>
            </p>
        </div>
    </body>
    </html>
    ';
    exit();
}

// Load Stripe SDK
require_once $autoloadPath;

// Get Stripe keys from environment
$stripeSecretKey = getenv('STRIPE_SECRET_KEY');
$stripePublishableKey = getenv('STRIPE_PUBLISHABLE_KEY');
$currency = getenv('PAYMENT_CURRENCY') ?: 'USD';

// Validate keys exist
if (empty($stripeSecretKey) || empty($stripePublishableKey)) {
    die("❌ Stripe API keys not found in .env file. Please add STRIPE_PUBLISHABLE_KEY and STRIPE_SECRET_KEY to your .env file.");
}

// Initialize Stripe with secret key
try {
    \Stripe\Stripe::setApiKey($stripeSecretKey);
} catch (Exception $e) {
    die("❌ Stripe Initialization Error: " . $e->getMessage());
}

// Return configuration array
return [
    'publishable_key' => $stripePublishableKey,
    'secret_key' => $stripeSecretKey,
    'currency' => strtolower($currency),
    'app_url' => getenv('APP_URL') ?: 'http://localhost/RecoltePure'
];
?>