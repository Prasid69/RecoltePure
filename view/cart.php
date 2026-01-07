<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="assets/css/cart.css"> 
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
            <a href="index.php?page=home">
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
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="">
                        <div style="text-align: left;">
                            <span class="product-name"><?php echo htmlspecialchars($product['name']); ?></span>
                            <span class="product-weight">Pack</span>
                        </div>
                    </div>

                    <div class="price-text">$<?php echo number_format($product['price'], 2); ?></div>

                    <form method="POST" action="index.php?page=cart" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <div class="qty-control">
                            <button type="submit" name="action" value="decrease" class="qty-btn">-</button>
                            <input type="text" value="<?php echo $product['quantity']; ?>" class="qty-input" readonly>
                            <button type="submit" name="action" value="increase" class="qty-btn">+</button>
                        </div>
                    </form>

                    <div class="price-text">$<?php echo number_format($line_total, 2); ?></div>

                    <form method="POST" action="index.php?page=cart" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <button type="submit" name="action" value="remove" class="remove-btn">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </div>
                <?php endforeach; ?>

                <div class="cart-actions">
                    <div class="coupon-group">
                        <input type="text" class="input-field" placeholder="Coupon Code">
                        <button class="btn btn-dark">Apply Coupon</button>
                    </div>
                    <a href="index.php?page=cart&action=clear" class="link-text">Clear Shopping Cart</a>
                </div>
            </div>

            <div class="cart-sidebar">
                <div class="summary-card">
                    <h3>Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Items</span>
                        <span><?php echo $totalItems; ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Sub Total</span>
                        <span>$<?php echo number_format($grandTotal, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>$<?php echo number_format($grandTotal, 2); ?></span>
                    </div>

                    <form action="index.php?page=checkout" method="POST">
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
            <a href="index.php?page=categories" class="btn-continue">Return to Shop</a>
        </div>
        <?php endif; ?>

        </div>
</body>
</html>