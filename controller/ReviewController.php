<?php
require_once 'config/db_connection.php';
require_once 'model/ProductReview.php'; // Ensure this matches your new model filename
require_once 'model/Orders.php';        // Needed for fetching order items

class ReviewController {
    private $reviewModel;
    private $orderModel;

    public function __construct($db) {
        $this->reviewModel = new ProductReviewModel($db);
        $this->orderModel = new OrderModel($db);
    }

    // --- SHOW THE REVIEW FORM ---
    public function showReviewForm() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // 1. Check Login
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $itemsToReview = [];
        $preSelectedProductId = null;

        // CASE A: User came from "My Orders" page (Has a Delivery ID)
        // We need to show a dropdown of all items in that order.
        if (isset($_GET['delivery_id'])) {
            $deliveryId = $_GET['delivery_id'];
            $itemsToReview = $this->orderModel->getOrderItems($deliveryId);
        }
        
        // CASE B: User came from "Product Page" (Has a Product ID)
        // We pre-select this product and hide the dropdown.
        elseif (isset($_GET['product_id'])) {
            $preSelectedProductId = $_GET['product_id'];
        }

        // Render the view
        require_once 'view/submit_review.php';
    }

    // --- HANDLE FORM SUBMISSION ---
    public function submitReview() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            
            // Get data from form
            $productId = $_POST['product_id'];
            $rating = $_POST['rating'];
            $comment = trim($_POST['comment']);

            // Validate inputs
            if (empty($productId) || empty($rating)) {
                echo "<script>alert('Please select a product and a rating.'); window.history.back();</script>";
                return;
            }

            // Save using the new ProductReviewModel
            if ($this->reviewModel->addReview($userId, $productId, $rating, $comment)) {
                // Success: Redirect to My Orders
                header("Location: index.php?page=my_orders&success=review_submitted");
                exit();
            } else {
                // Failure (Likely already reviewed)
                echo "<script>alert('You have already reviewed this product.'); window.location.href='index.php?page=my_orders';</script>";
            }
        }
    }
}
?>