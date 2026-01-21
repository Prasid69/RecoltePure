<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="/RecoltePure/assets/css/cart.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .empty-cart-msg { text-align: center; padding: 50px; font-size: 1.2rem; color: #666; }
        .btn-continue { display: inline-block; margin-top: 15px; padding: 10px 20px; background-color: #333; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>


    

    <div class="container">


    <div class="back-home">
            <a href="/RecoltePure/home">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to Home
            </a>
        </div>
        <div class="page-header">
            <h1>Shopping Cart</h1>
            <div class="breadcrumb">Home <span>/</span> Shopping Cart</div>
        </div>

        <?php if (!empty($cartItems)): ?>
        <div class="cart-layout">
            
            <div class="cart-content">
                <div class="cart-table-header">
                    <div>Product</div>
                    <div>Price</div>
                    <div>Quantity</div>
                    <div>Subtotal</div>
                    <div></div> 
                </div>

                <?php foreach ($cartItems as $product_id => $product): 
                    $line_total = $product['price'] * $product['quantity'];
                ?>
                <div class="cart-item">
                    <div class="product-info">
                        <img src="/RecoltePure/<?php echo htmlspecialchars($product['image']); ?>" alt="">

                        <div style="text-align: left;">
                            <span class="product-name"><?php echo htmlspecialchars($product['name']); ?></span>
                            <span class="product-weight">Pack</span>
                        </div>
                    </div>

                    <div class="price-text">$<?php echo number_format($product['price'], 2); ?></div>

                    <form method="POST" action="/RecoltePure/cart" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <div class="qty-control">
                            <button type="submit" name="action" value="decrease" class="qty-btn">-</button>
                            <input type="text" value="<?php echo $product['quantity']; ?>" class="qty-input" readonly>
                            <button type="submit" name="action" value="increase" class="qty-btn">+</button>
                        </div>
                    </form>

                    <div class="price-text">$<?php echo number_format($line_total, 2); ?></div>

                    <form method="POST" action="/RecoltePure/cart" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <button type="submit" name="action" value="remove" class="remove-btn">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </div>
                <?php endforeach; ?>

                <div class="cart-actions">

    <!-- Show coupon input only if no coupon applied -->
    <?php if (empty($_SESSION['coupon'])): ?>
    <div class="coupon-group">
        <form action="/RecoltePure/cart" method="POST">
            <input type="text" name="coupon_code" class="input-field" placeholder="Coupon Code" required>
            <button type="submit" name="action" value="apply_coupon" class="btn btn-dark">Apply Coupon</button>
        </form>
    </div>
    <?php else: ?>
    <!-- Show applied coupon with remove option -->
    <div class="coupon-group">
        <p class="text-success">
            Coupon "<strong><?= htmlspecialchars($_SESSION['coupon']['code']); ?></strong>" applied! Discount: <?= $_SESSION['coupon']['discount']; ?>%
        </p>
        <form action="/RecoltePure/cart" method="POST">
            <button type="submit" name="action" value="remove_coupon" class="btn btn-secondary">Remove Coupon</button>
        </form>
    </div>
    <?php endif; ?>





                    <a href="/RecoltePure/cart/clear" class="link-text">Clear Shopping Cart</a>

                </div>
            </div>

            <div class="cart-sidebar">
    <div class="summary-card">
        <h3>Order Summary</h3>
        
       <div class="summary-row">
    <span>Items</span>
    <span><?= $totalItems ?></span>
</div>
<div class="summary-row">
    <span>Sub Total</span>
    <span>$<?= number_format($grandTotalBeforeDiscount, 2) ?></span>
</div>
<div class="summary-row">
    <span>Shipping</span>
    <span>Free</span>
</div>

<?php if (!empty($_SESSION['coupon'])): ?>
<div class="summary-row">
    <span>Coupon (<?= htmlspecialchars($_SESSION['coupon']['code']); ?>)</span>
    <span>-<?= $_SESSION['coupon']['discount']; ?>%</span>
</div>
<?php endif; ?>

<div class="summary-row total">
    <span>Total</span>
    <span>$<?= number_format($grandTotal, 2) ?></span>
</div>



        <form action="/RecoltePure/checkout" method="POST">
            <?php if (!empty($_SESSION['cart'])): ?>
                <button type="submit" class="btn btn-green btn-block">Proceed to Checkout</button>
            <?php else: ?>
                <button type="button" class="btn btn-secondary btn-block" disabled>Cart is Empty</button>
            <?php endif; ?>
        </form>
    </div>
</div>

        </div>

        <?php else: ?>
        <div class="empty-cart-msg">
            <i class="fas fa-shopping-basket" style="font-size: 3rem; margin-bottom: 20px; color:#ccc;"></i>
            <h2>Your cart is currently empty.</h2>
            <a href="/RecoltePure/categories" class="btn-continue">Return to Shop</a>
        </div>
        <?php endif; ?>

        </div>
</body>
</html>