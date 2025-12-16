<?php include 'view/layout/header.php'; ?>

<style>
    .review-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        font-family: 'Poppins', sans-serif;
    }
    .rating-group {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 10px;
        margin: 20px 0;
    }
    /* Hide radio buttons */
    .rating-group input {
        display: none;
    }
    /* Star styling */
    .rating-group label {
        font-size: 40px;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }
    /* Hover and Checked Logic for Stars */
    .rating-group input:checked ~ label,
    .rating-group label:hover,
    .rating-group label:hover ~ label {
        color: #FFD700; /* Gold */
    }
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        resize: vertical;
        min-height: 100px;
    }
    .submit-btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
        margin-top: 15px;
    }
    .submit-btn:hover {
        background-color: #45a049;
    }
</style>

<div class="review-container">
    <h2 style="text-align: center; color: #333;">Write a Review</h2>
    <p style="text-align: center; color: #666;">How was your order?</p>

    <form action="index.php?page=process_review" method="POST">
        <input type="hidden" name="order_customer_id" value="<?php echo htmlspecialchars($orderCustomerId); ?>">
        <input type="hidden" name="order_delivery_id" value="<?php echo htmlspecialchars($orderDeliveryId); ?>">

        <div class="rating-group">
            <input type="radio" id="star5" name="rating" value="5"><label for="star5" title="Excellent">★</label>
            <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="Good">★</label>
            <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="Average">★</label>
            <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="Poor">★</label>
            <input type="radio" id="star1" name="rating" value="1" required><label for="star1" title="Terrible">★</label>
        </div>

        <div class="form-group">
            <label for="comment" style="font-weight: bold; display: block; margin-bottom: 5px;">Your Feedback</label>
            <textarea name="comment" id="comment" placeholder="Tell us more about your experience..."></textarea>
        </div>

        <button type="submit" class="submit-btn">Submit Review</button>
        <a href="index.php?page=profile" style="display: block; text-align: center; margin-top: 15px; color: #777; text-decoration: none;">Cancel</a>
    </form>
</div>