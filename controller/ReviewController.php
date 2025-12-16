<?php

require_once 'config/db_connection.php';
require_once 'model/Review.php';

class ReviewController {
    private $model;

    public function __construct($db) {
        $this->model = new ReviewModel($db);
    }

    // Show the form
    public function showReviewForm() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // 1. Check if logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        // 2. Validate URL parameters (we need to know WHAT we are reviewing)
        if (!isset($_GET['order_id']) || !isset($_GET['delivery_id'])) {
            echo "Invalid request. Missing Order ID.";
            return;
        }

        $orderCustomerId = $_GET['order_id'];
        $orderDeliveryId = $_GET['delivery_id'];

        // 3. Render the view
        require_once 'view/submit_review.php';
    }

    // Process the form submission
    public function submitReview() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $customerId = $_SESSION['user_id'];
            $orderCustomerId = $_SESSION['user_id'];
            $orderDeliveryId = $_POST['order_delivery_id'];
            $rating = $_POST['rating'];
            $comment = trim($_POST['comment']);

            // Simple validation
            if ($rating < 1 || $rating > 5) {
                echo "Invalid rating.";
                return;
            }

            // Check duplicate
            if ($this->model->hasReviewed($customerId, $orderDeliveryId)) {
                echo "<script>alert('You have already reviewed this item.'); window.location.href='index.php?page=profile';</script>";
                return;
            }

            // Save
            if ($this->model->createReview($customerId, $orderCustomerId, $orderDeliveryId, $rating, $comment)) {
                header("Location: index.php?page=my_orders&success=review_submitted");
            } else {
                echo "Error submitting review.";
            }
        }
    }
}
?>