<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    
    <link rel="stylesheet" href="../assets/css/cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
      
    </style>
</head>
<body>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Shopping Cart</h1>
            <div class="breadcrumb">
                Home <span>/</span> Shopping Cart
            </div>
        </div>

        <!-- Main Cart Area -->
        <div class="cart-layout">
            
            <!-- Left Column: Cart Items -->
            <div class="cart-content">
                <!-- Header Row -->
                <div class="cart-table-header">
                    <div>Product</div>
                    <div>Price</div>
                    <div>Quantity</div>
                    <div>Subtotal</div>
                    <div></div> <!-- Empty for close button -->
                </div>

                <!-- Item 1 -->
                <div class="cart-item">
                    <div class="product-info">
                        <!-- Placeholder for Food Image -->
                        <img src="https://placehold.co/100x100/orange/white?text=Orange" alt="Fresh Orange">
                        <div style="text-align: left;">
                            <span class="product-name">Fresh Oranges</span>
                            <span class="product-weight">500 g</span>
                        </div>
                    </div>
                    <div class="price-text">$11.75</div>
                    <div>
                        <div class="qty-control">
                            <button class="qty-btn">-</button>
                            <input type="text" value="4" class="qty-input" readonly>
                            <button class="qty-btn">+</button>
                        </div>
                    </div>
                    <div class="price-text">$47.00</div>
                    <button class="remove-btn"><i class="fas fa-times"></i></button>
                </div>

                <!-- Item 2 -->
                <div class="cart-item">
                    <div class="product-info">
                        <img src="https://placehold.co/100x100/purple/white?text=Onion" alt="Red Onion">
                        <div style="text-align: left;">
                            <span class="product-name">Red Onion</span>
                            <span class="product-weight">500 g</span>
                        </div>
                    </div>
                    <div class="price-text">$8.00</div>
                    <div>
                        <div class="qty-control">
                            <button class="qty-btn">-</button>
                            <input type="text" value="2" class="qty-input" readonly>
                            <button class="qty-btn">+</button>
                        </div>
                    </div>
                    <div class="price-text">$16.00</div>
                    <button class="remove-btn"><i class="fas fa-times"></i></button>
                </div>

                <!-- Item 3 -->
                <div class="cart-item">
                    <div class="product-info">
                        <img src="https://placehold.co/100x100/gold/white?text=Lemon" alt="Lemon">
                        <div style="text-align: left;">
                            <span class="product-name">Fresh Yellow Lemon</span>
                            <span class="product-weight">1 Kg</span>
                        </div>
                    </div>
                    <div class="price-text">$8.00</div>
                    <div>
                        <div class="qty-control">
                            <button class="qty-btn">-</button>
                            <input type="text" value="1" class="qty-input" readonly>
                            <button class="qty-btn">+</button>
                        </div>
                    </div>
                    <div class="price-text">$8.00</div>
                    <button class="remove-btn"><i class="fas fa-times"></i></button>
                </div>

                <!-- Coupon Section -->
                <div class="cart-actions">
                    <div class="coupon-group">
                        <input type="text" class="input-field" placeholder="Coupon Code">
                        <button class="btn btn-dark">Apply Coupon</button>
                    </div>
                    <a href="#" class="link-text">Clear Shopping Cart</a>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="cart-sidebar">
                <div class="summary-card">
                    <h3>Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Items</span>
                        <span>9</span>
                    </div>
                    <div class="summary-row">
                        <span>Sub Total</span>
                        <span>$85.40</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>$00.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Taxes</span>
                        <span>$00.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Coupon Discount</span>
                        <span>-$10.00</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>$75.40</span>
                    </div>

                    <button class="btn btn-green btn-block">Proceed to Checkout</button>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="features">
            <div class="feature-item">
                <div class="icon-box"><i class="fas fa-shipping-fast"></i></div>
                <div class="feature-text">
                    <h4>Free Shipping</h4>
                    <p>Free shipping for order above $50</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="icon-box"><i class="fas fa-wallet"></i></div>
                <div class="feature-text">
                    <h4>Flexible Payment</h4>
                    <p>Multiple secure payment options</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="icon-box"><i class="fas fa-headset"></i></div>
                <div class="feature-text">
                    <h4>24x7 Support</h4>
                    <p>We support online all days</p>
                </div>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="newsletter">
            <h2>Subscribe to Our Newsletter to<br>Get <span>Updates on Our Latest Offers</span></h2>
            <p>Get 25% off on your first order just by subscribing to our newsletter</p>
            <form class="newsletter-form">
                <input type="email" class="input-lg" placeholder="Enter Email Address">
                <button class="btn btn-yellow">Subscribe</button>
            </form>
        </div>

    </div>

</body>
</html>