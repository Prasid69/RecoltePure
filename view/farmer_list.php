<?php include 'view/layout/header.php'; ?>
<link rel="stylesheet" href="assets/css/farmer_list.css">

<div class="farmers-page">
    <h1 style="text-align:center; color:#333; margin-bottom:40px;">Meet Our Farmers</h1>

    <div class="farmers-grid">
        <?php foreach ($farmers as $farm): ?>
            <div class="farmer-card">

                <div class="card-header">
                    <div class="farmer-name">
                        <span><?php echo htmlspecialchars($farm['name']); ?></span>

                        <?php if (isset($farm['account_status']) && $farm['account_status'] === 'Verified'): ?>
                            <span class="status-badge status-verified">Verified</span>
                        <?php else: ?>
                            <span class="status-badge status-pending">Pending</span>
                        <?php endif; ?>

                    </div>
                    <div class="farmer-details">
                        <i class='bx  bx-location-pin'></i> <?php echo htmlspecialchars($farm['address']); ?><br>
                        <i class='bx  bx-phone'></i> <?php echo htmlspecialchars($farm['phone_number']); ?>
                    </div>
                </div>

                <div class="products-preview">
                    <div class="preview-label">Top Products</div>

                    <?php if (!empty($farm['products'])): ?>
                        <div class="product-row">
                            <?php foreach ($farm['products'] as $prod): ?>
                                <div class="mini-prod">
                                    <img src="assets/uploads/products/<?php echo htmlspecialchars($prod['image']); ?>"
                                        alt="product">
                                    <div class="mini-price">$<?php echo $prod['price']; ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="color:#aaa; font-style:italic; font-size:0.9rem;">No products listed yet.</p>
                    <?php endif; ?>
                </div>


            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'view/layout/footer.php'; ?>