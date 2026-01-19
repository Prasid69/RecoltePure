<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($userData)) {
    $isLoggedIn = isset($_SESSION['user_id']);
    $initial = 'U';

    if ($isLoggedIn) {
        $displayName = $_SESSION['user_name'] ?? $_SESSION['login_user'] ?? '';
        
        if (!empty($displayName)) {
            $initial = strtoupper(substr($displayName, 0, 1));
        }
    }

    $userData = [
        'is_logged_in' => $isLoggedIn,
        'initial'      => $initial
    ];
}
?>
<?php
require_once __DIR__ . '/../../model/Cart.php';
$cartCount = Cart::getTotalQuantity();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RecoltePure</title>
  
  <link rel="icon" type="image/png" sizes="512x512" href="../assets/images/favicon.png">
  <link rel="stylesheet" href="/RecoltePure/assets/css/homepage.css">

  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
<style>
    .icon-wrapper {
        position: relative;
        display: inline-flex; 
        align-items: center;
        justify-content: center;
    }

  
    .icon-wrapper i {
        font-size: 1.6rem; 
        color: #333;
    }

    
    .cart-badge {
        position: absolute;
        top: -5px; 
        right: -8px;  
        
        background-color: #ff4757; 
        color: white;
        
        font-size: 12px;
        font-weight: 700;
        font-family: sans-serif;
        
       
        width: 18px;
        height: 18px;
        border-radius: 50%;
        
     
        display: flex;
        align-items: center;
        justify-content: center;
        
        
        /* Ensure it sits on top */
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <a href="../RecoltePure/home" class="logo">

            <img src="/RecoltePure/assets/uploads/products/Logo.png" alt="RecoltePure Logo" width="16" height="16">

            RecoltePure
        </a>
      </div>
      <ul class="nav-links">
    <li><a href="/RecoltePure/" class="active">Home</a></li>
    <li><a href="/RecoltePure/categories" class="active">Product</a></li>
    <li><a href="/RecoltePure/farmers" class="active">Our Producers</a></li>
    <li><a href="/RecoltePure/contact" class="active">Contact Us</a></li>
    <li><a href="/RecoltePure/terms-and-conditions" class="active">Terms & Conditions</a></li>
</ul>

      
      <div class="nav-actions">

      <div class="menu-icon" id="menu-toggle">
     <i class='bx bx-menu'></i> </div>
        <form method="GET" action="index.php" class="search-box">
          <input type="hidden" name="page" value="categories">
        
          <input type="text" name="search" class="search-input" placeholder="Search..." 
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        
          <button type="submit" class="search-btn">
              <i class='bx bx-search'></i>
          </button>
        </form>

        <a href="index.php?page=cart" class="cart-link" style="text-decoration: none;">
            <div class="icon-wrapper">
                <i class='bx bxs-cart' style="color: black"></i>
                
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </div>
        </a>
        <?php if (!$userData['is_logged_in']): ?>
           <a href="/RecoltePure/login" class="sign-in">Sign In</a>
        <?php else: ?>
            <button class="user-btn"><?php echo $userData['initial']; ?></button>
            <div class="dropdown-menu">
                <a href="index.php?page=profile">My Profile</a>
                <a href="index.php?page=my_orders">My Orders</a>
                <a href="index.php?page=logout">Logout</a>
            </div>
        <?php endif; ?>
      </div>
</nav>
  </header>
  <script src="/RecoltePure/assets/js/main.js" defer></script>
</body>
</html>
