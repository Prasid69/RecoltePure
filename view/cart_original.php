<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && isset($_POST['product_id']) 
    && !isset($_POST['action'])) 
{
    $product_id   = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price        = (float) $_POST['price'];
    $quantity     = (int) $_POST['quantity'];
    $image        = $_POST['image'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name'     => $product_name,
            'price'    => $price,
            'quantity' => $quantity,
            'image'    => $image
        ];
    }

    header("Location: cart.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['product_id'])
    && isset($_POST['action'])) 
{
    $product_id = $_POST['product_id'];
    $action     = $_POST['action'];

    if (isset($_SESSION['cart'][$product_id])) {
        switch ($action) {
            case 'increase':
                $_SESSION['cart'][$product_id]['quantity']++;
                break;

            case 'decrease':
                $_SESSION['cart'][$product_id]['quantity']--;
                if ($_SESSION['cart'][$product_id]['quantity'] <= 0) {
                    unset($_SESSION['cart'][$product_id]);
                }
                break;

            case 'remove':
                unset($_SESSION['cart'][$product_id]);
                break;
        }
    }

    header("Location: cart.php");
    exit;
}


if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit;
}


$total = 0;
foreach ($_SESSION['cart'] as $pid => $pdata) {
    $total += $pdata['price'] * $pdata['quantity'];
}

$grand_total = $total;
$total_items = array_sum(array_column($_SESSION['cart'], 'quantity'));
?>



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
        .empty-cart-msg {
            text-align: center;
            padding: 50px;
            font-size: 1.2rem;
            color: #666;
        }
        .btn-continue {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="page-header">
            <h1>Shopping Cart</h1>
            <div class="breadcrumb">
                Home <span>/</span> Shopping Cart
            </div>
        </div>

        <?php if (!empty($_SESSION['cart'])): ?>
        <div class="cart-layout">
            
            <div class="cart-content">
                <div class="cart-table-header">
                    <div>Product</div>
                    <div>Price</div>
                    <div>Quantity</div>
                    <div>Subtotal</div>
                    <div></div> 
                </div>

                <?php foreach ($_SESSION['cart'] as $product_id => $product): 
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

    <form method="POST" action="cart.php" style="display:inline;">
        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
        <div class="qty-control">
            <button type="submit" name="action" value="decrease" class="qty-btn">-</button>
            <input type="text" value="<?php echo $product['quantity']; ?>" class="qty-input" readonly>
            <button type="submit" name="action" value="increase" class="qty-btn">+</button>
        </div>
    </form>

    <div class="price-text">$<?php echo number_format($line_total, 2); ?></div>

    <form method="POST" action="cart.php" style="display:inline;">
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
                    <a href="?action=clear" class="link-text">Clear Shopping Cart</a>
                </div>
            </div>

            <div class="cart-sidebar">
                <div class="summary-card">
                    <h3>Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Items</span>
                        <span><?php echo $total_items; ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Sub Total</span>
                        <span>$<?php echo number_format($grand_total, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>$<?php echo number_format($grand_total, 2); ?></span>
                    </div>

                    <button class="btn btn-green btn-block">Proceed to Checkout</button>
                </div>
            </div>
        </div>

        <?php else: ?>
        <div class="empty-cart-msg">
            <i class="fas fa-shopping-basket" style="font-size: 3rem; margin-bottom: 20px; color:#ccc;"></i>
            <h2>Your cart is currently empty.</h2>
            <a href="categories.php" class="btn-continue">Return to Shop</a>
        </div>
        <?php endif; ?>


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

        <div class="newsletter">
            <h2>Subscribe to Our Newsletter</h2>
            <form class="newsletter-form">
                <input type="email" class="input-lg" placeholder="Enter Email Address">
                <button class="btn btn-yellow">Subscribe</button>
            </form>
        </div>

    </div>

</body>
</html>