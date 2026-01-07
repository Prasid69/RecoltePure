<?php
class ProductReviewModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Add a new review
    public function addReview($userId, $productId, $rating, $comment) {
        // Check if review already exists
        if ($this->hasReviewed($userId, $productId)) {
            return false; 
        }

        $sql = "INSERT INTO product_reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiis", $userId, $productId, $rating, $comment);
        
        return $stmt->execute();
    }

    // Check if user already reviewed this product
    public function hasReviewed($userId, $productId) {
        $sql = "SELECT review_id FROM product_reviews WHERE user_id = ? AND product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Get all reviews for a specific product (for display on product page)
    public function getReviewsByProduct($productId) {
        $sql = "SELECT pr.*, u.user_name 
                FROM product_reviews pr 
                JOIN users u ON pr.user_id = u.user_id 
                WHERE pr.product_id = ? 
                ORDER BY pr.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>