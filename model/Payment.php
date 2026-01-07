<?php

class Payment {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    /**
     * Create a new payment record
     */
    public function createPayment($order_id, $customer_id, $amount, $payment_method, $stripe_payment_intent_id = null) {
        $query = "INSERT INTO payments (order_id, customer_id, amount, payment_method, stripe_payment_intent_id, payment_status) 
                  VALUES (?, ?, ?, ?, ?, 'pending')";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return array('success' => false, 'error' => $this->db->error);
        }

        $stmt->bind_param("iidss", $order_id, $customer_id, $amount, $payment_method, $stripe_payment_intent_id);
        
        if ($stmt->execute()) {
            return array('success' => true, 'payment_id' => $this->db->insert_id);
        } else {
            return array('success' => false, 'error' => $stmt->error);
        }
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus($payment_id, $status, $charge_id = null, $failure_reason = null) {
        $query = "UPDATE payments SET payment_status = ?, stripe_charge_id = ?, failure_reason = ? WHERE payment_id = ?";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return array('success' => false, 'error' => $this->db->error);
        }

        $stmt->bind_param("sssi", $status, $charge_id, $failure_reason, $payment_id);
        
        if ($stmt->execute()) {
            return array('success' => true);
        } else {
            return array('success' => false, 'error' => $stmt->error);
        }
    }

    /**
     * Get payment by ID
     */
    public function getPaymentById($payment_id) {
        $query = "SELECT * FROM payments WHERE payment_id = ?";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $payment_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Get payment by order ID
     */
    public function getPaymentByOrderId($order_id) {
        $query = "SELECT * FROM payments WHERE order_id = ? ORDER BY created_at DESC LIMIT 1";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Get payment by Stripe Payment Intent ID
     */
    public function getPaymentByStripeIntentId($stripe_payment_intent_id) {
        $query = "SELECT * FROM payments WHERE stripe_payment_intent_id = ?";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("s", $stripe_payment_intent_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Get customer payment history
     */
    public function getCustomerPayments($customer_id, $limit = 10) {
        $query = "SELECT p.*, o.delivery_status FROM payments p 
                  LEFT JOIN delivery o ON p.order_id = o.delivery_id 
                  WHERE p.customer_id = ? 
                  ORDER BY p.created_at DESC 
                  LIMIT ?";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return array();
        }

        $stmt->bind_param("ii", $customer_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $payments = array();
        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }

        return $payments;
    }

    /**
     * Save payment method
     */
    public function savePaymentMethod($customer_id, $stripe_payment_method_id, $card_last_four, $card_brand, $exp_month, $exp_year, $is_default = false) {
        // If setting as default, unset other defaults
        if ($is_default) {
            $update_query = "UPDATE payment_methods SET is_default = 0 WHERE customer_id = ?";
            $update_stmt = $this->db->prepare($update_query);
            $update_stmt->bind_param("i", $customer_id);
            $update_stmt->execute();
        }

        $query = "INSERT INTO payment_methods (customer_id, stripe_payment_method_id, card_last_four, card_brand, card_exp_month, card_exp_year, is_default) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return array('success' => false, 'error' => $this->db->error);
        }

        $is_default_int = $is_default ? 1 : 0;
        $stmt->bind_param("isssiis", $customer_id, $stripe_payment_method_id, $card_last_four, $card_brand, $exp_month, $exp_year, $is_default_int);
        
        if ($stmt->execute()) {
            return array('success' => true, 'payment_method_id' => $this->db->insert_id);
        } else {
            return array('success' => false, 'error' => $stmt->error);
        }
    }

    /**
     * Get customer payment methods
     */
    public function getCustomerPaymentMethods($customer_id) {
        $query = "SELECT * FROM payment_methods WHERE customer_id = ? ORDER BY is_default DESC, created_at DESC";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return array();
        }

        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $methods = array();
        while ($row = $result->fetch_assoc()) {
            $methods[] = $row;
        }

        return $methods;
    }

    /**
     * Delete payment method
     */
    public function deletePaymentMethod($payment_method_id, $customer_id) {
        $query = "DELETE FROM payment_methods WHERE payment_method_id = ? AND customer_id = ?";
        
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return array('success' => false, 'error' => $this->db->error);
        }

        $stmt->bind_param("ii", $payment_method_id, $customer_id);
        
        if ($stmt->execute()) {
            return array('success' => true);
        } else {
            return array('success' => false, 'error' => $stmt->error);
        }
    }

    /**
     * Get payment statistics
     */
    public function getPaymentStats($date_from = null, $date_to = null) {
        $query = "SELECT 
                    COUNT(*) as total_payments,
                    SUM(amount) as total_revenue,
                    AVG(amount) as average_payment,
                    COUNT(CASE WHEN payment_status = 'completed' THEN 1 END) as completed_payments,
                    COUNT(CASE WHEN payment_status = 'failed' THEN 1 END) as failed_payments
                  FROM payments
                  WHERE 1=1";

        if ($date_from && $date_to) {
            $query .= " AND DATE(created_at) BETWEEN ? AND ?";
        }

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return null;
        }

        if ($date_from && $date_to) {
            $stmt->bind_param("ss", $date_from, $date_to);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Get recent payments with customer details
     */
    public function getRecentPayments($limit = 10) {
        $query = "SELECT p.*, u.name as customer_name 
                  FROM payments p
                  LEFT JOIN users u ON p.customer_id = u.customer_id
                  ORDER BY p.created_at DESC
                  LIMIT ?";

        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return array();
        }

        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $payments = array();
        while ($row = $result->fetch_assoc()) {
            $payments[] = $row;
        }

        return $payments;
    }
}
?>
