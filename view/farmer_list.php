<?php include 'view/layout/header.php'; ?>

<style>
    .farmers-page {
        background-color: #f9f9f9;
        padding: 40px 20px;
        min-height: 80vh;
        font-family: 'Poppins', sans-serif;
    }
    .farmers-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }
    .farmer-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: transform 0.2s;
        display: flex;
        flex-direction: column;
    }
    .farmer-card:hover {
        transform: translateY(-5px);
    }
    .card-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
    }
    .farmer-name {
        font-size: 1.3rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-verified {
        background-color: #e8f5e9; 
        color: #2e7d32;            
        border: 1px solid #c8e6c9;
    }
    .status-pending {
        background-color: #fff3e0; 
        color: #ef6c00;            
        border: 1px solid #ffe0b2;
    }

    .farmer-details {
        font-size: 0.9rem;
        color: #666;
        margin-top: 10px;
    }
    .products-preview {
        padding: 15px 20px;
        background: #fafafa;
        flex-grow: 1;
    }
    .preview-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        color: #999;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .product-row {
        display: flex;
        gap: 10px;
    }
    .mini-prod {
        width: 60px;
    }
    .mini-prod img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid #eee;
    }
    .mini-price {
        font-size: 0.8rem;
        color: #4CAF50;
        text-align: center;
        font-weight: bold;
    }
    .btn-visit {
        display: block;
        text-align: center;
        background: #2c3e50;
        color: #fff;
        padding: 12px;
        text-decoration: none;
        transition: 0.3s;
    }
    .btn-visit:hover {
        background: #4CAF50;
    }
</style>

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
                                    <img src="assets/uploads/products/<?php echo htmlspecialchars($prod['image']); ?>" alt="product">
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