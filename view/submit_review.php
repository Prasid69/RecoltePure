<?php include 'view/layout/header.php'; ?>

<style>
    .review-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        font-family: 'Poppins', sans-serif;
        text-align: center;
    }


    .rating-group {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 5px;
        margin-bottom: 20px;
    }

    .rating-group input {
        display: none;
    }

    .rating-group label {
        font-size: 35px;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }


    .rating-group input:checked~label,
    .rating-group label:hover,
    .rating-group label:hover~label {
        color: #FFD700;
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
        transition: 0.3s;
    }

    .submit-btn:hover {
        background-color: #45a049;
    }
</style>

<div class="review-container">
    <h2>Write a Review</h2>

    <form action="index.php?page=process_review" method="POST">

        <div class="form-group" style="margin-bottom: 20px;">
            <label style="font-weight: bold; display:block; margin-bottom:5px;">Product:</label>

            <?php if ($preSelectedProductId): ?>
                <input type="hidden" name="product_id" value="<?php echo $preSelectedProductId; ?>">
                <div style="padding: 10px; background: #f9f9f9; border-left: 4px solid #4CAF50;">
                    Reviewing Product ID: <strong>#<?php echo $preSelectedProductId; ?></strong>
                </div>

            <?php elseif (!empty($itemsToReview)): ?>
                <select name="product_id" required
                    style="width: 100%; padding: 10px; border:1px solid #ddd; border-radius:4px;">
                    <option value="" disabled selected>-- Select a Product --</option>
                    <?php foreach ($itemsToReview as $item): ?>
                        <option value="<?php echo $item['product_id']; ?>">
                            <?php echo htmlspecialchars($item['product_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            <?php else: ?>
                <p style="color:red;">Error: No product found to review.</p>
            <?php endif; ?>
        </div>

        <label style="font-weight: bold; display:block; margin-bottom:5px;">Rating:</label>

        <div class="rating-group">
            <input type="radio" id="star5" name="rating" value="5" />
            <label for="star5" title="Excellent">★</label>

            <input type="radio" id="star4" name="rating" value="4" />
            <label for="star4" title="Good">★</label>

            <input type="radio" id="star3" name="rating" value="3" />
            <label for="star3" title="Average">★</label>

            <input type="radio" id="star2" name="rating" value="2" />
            <label for="star2" title="Poor">★</label>

            <input type="radio" id="star1" name="rating" value="1" required />
            <label for="star1" title="Terrible">★</label>
        </div>

        <div class="form-group">
            <label style="font-weight: bold; display:block; margin-bottom:5px;">Review:</label>
            <textarea name="comment" placeholder="Tell us about your experience with this product..."></textarea>
        </div>

        <button type="submit" class="submit-btn">Submit Review</button>
    </form>
</div>
<?php include 'view/layout/footer.php'; ?>