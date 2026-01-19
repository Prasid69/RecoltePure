<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Dotenv\Dotenv;

class StripePayment {
    public static function createCheckoutSession($cartItems, $successUrl, $cancelUrl) {
        // Load .env if not already loaded
        if (!isset($_ENV['STRIPE_SECRET_KEY'])) {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();
        }
        $apiKey = $_ENV['STRIPE_SECRET_KEY'] ?? getenv('STRIPE_SECRET_KEY');
        if (!$apiKey) {
            throw new Exception('Stripe secret key not set in .env');
        }
        Stripe::setApiKey($apiKey);
        $lineItems = [];
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => (int)($item['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);
        return $session->url;
    }
}
