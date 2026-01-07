<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/stripe_config.php';
require_once __DIR__ . '/../model/Payment.php';

class PaymentController {
    private $db;
    private $payment_model;

    public function __construct($database) {
        $this->db = $database;
        $this->payment_model = new Payment($database);
    }

    /**
     * Create a payment intent for Stripe
     */
    public function createPaymentIntent($order_id, $customer_id, $amount) {
        try {
            global $stripe_publishable_key;

            // Amount in cents
            $amount_cents = (int)($amount * 100);

            // Create payment intent
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $amount_cents,
                'currency' => 'usd',
                'metadata' => [
                    'order_id' => $order_id,
                    'customer_id' => $customer_id
                ]
            ]);

            // Save payment record
            $payment_result = $this->payment_model->createPayment(
                $order_id,
                $customer_id,
                $amount,
                'stripe',
                $intent->id
            );

            if ($payment_result['success']) {
                return array(
                    'success' => true,
                    'client_secret' => $intent->client_secret,
                    'payment_intent_id' => $intent->id,
                    'publishable_key' => $stripe_publishable_key
                );
            } else {
                return array('success' => false, 'error' => $payment_result['error']);
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return array('success' => false, 'error' => $e->getMessage());
        }
    }

    /**
     * Confirm payment
     */
    public function confirmPayment($payment_intent_id) {
        try {
            // Retrieve and expand charges to ensure availability
            $intent = \Stripe\PaymentIntent::retrieve([
                'id' => $payment_intent_id,
                'expand' => ['charges']
            ]);

            if ($intent->status == 'succeeded') {
                // Get charge ID safely
                $charge_id = null;
                if (isset($intent->charges) && isset($intent->charges->data) && !empty($intent->charges->data)) {
                    $charge_id = $intent->charges->data[0]->id;
                }

                // Get payment from database
                $payment = $this->payment_model->getPaymentByStripeIntentId($payment_intent_id);

                if ($payment) {
                    // Update payment status
                    $this->payment_model->updatePaymentStatus(
                        $payment['payment_id'],
                        'completed',
                        $charge_id
                    );

                    return array(
                        'success' => true,
                        'message' => 'Payment successful',
                        'payment_id' => $payment['payment_id'],
                        'order_id' => $payment['order_id']
                    );
                }
            } elseif ($intent->status == 'requires_payment_method') {
                return array(
                    'success' => false,
                    'error' => 'Payment method required'
                );
            } else {
                return array(
                    'success' => false,
                    'error' => 'Payment failed: ' . $intent->status
                );
            }
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return array('success' => false, 'error' => $e->getMessage());
        }
    }

    /**
     * Handle webhook for payment updates
     */
    public function handleWebhook($payload, $signature) {
        try {
            global $stripe_secret_key;
            $endpoint_secret = 'whsec_YOUR_WEBHOOK_SECRET'; // Replace with actual webhook secret

            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $signature,
                $endpoint_secret
            );

            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $intent = $event->data->object;
                    $payment = $this->payment_model->getPaymentByStripeIntentId($intent->id);
                    if ($payment) {
                        $charge_id = (isset($intent->charges) && isset($intent->charges->data) && !empty($intent->charges->data))
                            ? $intent->charges->data[0]->id
                            : null;
                        $this->payment_model->updatePaymentStatus(
                            $payment['payment_id'],
                            'completed',
                            $charge_id
                        );
                    }
                    break;

                case 'payment_intent.payment_failed':
                    $intent = $event->data->object;
                    $payment = $this->payment_model->getPaymentByStripeIntentId($intent->id);
                    if ($payment) {
                        $failure_reason = $intent->last_payment_error ? $intent->last_payment_error->message : 'Unknown error';
                        $this->payment_model->updatePaymentStatus(
                            $payment['payment_id'],
                            'failed',
                            null,
                            $failure_reason
                        );
                    }
                    break;
            }

            return array('success' => true);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return array('success' => false, 'error' => 'Invalid signature');
        } catch (\Exception $e) {
            return array('success' => false, 'error' => $e->getMessage());
        }
    }

    /**
     * Get payment details
     */
    public function getPaymentDetails($payment_id) {
        return $this->payment_model->getPaymentById($payment_id);
    }

    /**
     * Get customer payments
     */
    public function getCustomerPayments($customer_id) {
        return $this->payment_model->getCustomerPayments($customer_id);
    }

    /**
     * Save customer payment method
     */
    public function savePaymentMethod($customer_id, $stripe_payment_method_id) {
        try {
            $payment_method = \Stripe\PaymentMethod::retrieve($stripe_payment_method_id);

            $result = $this->payment_model->savePaymentMethod(
                $customer_id,
                $stripe_payment_method_id,
                $payment_method->card->last4,
                $payment_method->card->brand,
                $payment_method->card->exp_month,
                $payment_method->card->exp_year
            );

            return $result;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return array('success' => false, 'error' => $e->getMessage());
        }
    }

    /**
     * Refund payment
     */
    public function refundPayment($payment_id, $amount = null) {
        try {
            $payment = $this->payment_model->getPaymentById($payment_id);

            if (!$payment || !$payment['stripe_charge_id']) {
                return array('success' => false, 'error' => 'Payment not found');
            }

            $refund_params = array();
            if ($amount) {
                $refund_params['amount'] = (int)($amount * 100);
            }

            $refund = \Stripe\Refund::create([
                'charge' => $payment['stripe_charge_id'],
                ...$refund_params
            ]);

            // Update payment status
            if ($amount && $amount < $payment['amount']) {
                $this->payment_model->updatePaymentStatus($payment_id, 'partially_refunded');
            } else {
                $this->payment_model->updatePaymentStatus($payment_id, 'refunded');
            }

            return array(
                'success' => true,
                'refund_id' => $refund->id,
                'refund_status' => $refund->status
            );
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return array('success' => false, 'error' => $e->getMessage());
        }
    }
}
?>
