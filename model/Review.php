<?php
class ReviewModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createReview($customerId, $orderCustomerId, $orderDeliveryId, $rating, $comment) {
        $sql = "INSERT INTO reviews (customer_id, order_customer_id, order_delivery_id, rating, comment, review_date) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->db->error);
        }

        $stmt->bind_param("iiiis", $customerId, $orderCustomerId, $orderDeliveryId, $rating, $comment);
        
        return $stmt->execute();
    }

    public function hasReviewed($customerId, $orderDeliveryId) {
        $sql = "SELECT review_id FROM reviews WHERE customer_id = ? AND order_delivery_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $customerId, $orderDeliveryId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function getReviewsByOrder($orderCustomerId) {
        $sql = "SELECT * FROM reviews WHERE order_customer_id = ? ORDER BY review_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $orderCustomerId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>