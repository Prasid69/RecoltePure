<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RecoltePure</title>
  <link rel="icon" type="image/png" sizes="512x512" href="assets/images/favicon.png">

  <link rel="stylesheet" href="../assets/css/homepage.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <a href="homepage.php" class="logo">
        <img src="../assets/images/Logo.png" alt="RecoltePure Logo" sizes="16x16"/>
        RecoltePure
        </a>
    </div>
      <ul class="nav-links">
        <li><a href="#" class="active">Home</a></li>
        <li><a href="categories.php" class="active">Product</a></li>
        <li><a href="categories.php" class="active">Categories</a></li>
        <li><a href="#" class="active">Our Producers</a></li>
        <li><a href="contact.php" class="active">Contact Us</a></li>
      </ul>
      <div class="nav-actions">


    
    <form method="GET" action="view/categories.php" >
    <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <button type="submit">
        <i class='bx bx-search'></i>
    </button>
    </form>

    <a href="cart.php"><i class='bx bxs-cart' style="color: black"></i></a>

    <?php if (!isset($_SESSION['login_user'])): ?>
        <a href="login.php" class="sign-in">Sign Up</a>
    <?php else: ?>
        <?php 
            $email = $_SESSION['login_user'];
            $initial = strtoupper(substr($email, 0, 1));
        ?>
        <button class="user-btn"><?php echo $initial; ?></button>
        <div class="dropdown-menu">
            <a href="profile.php">My Profile</a>
            <a href="orders.php">My Orders</a>
            <a href="logout.php">Logout</a>
        </div>
    <?php endif; ?>

</div>
</nav>
  </header>


  <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'farmer'): ?>
    <div class="farmer-actions">
        <form action="upload_products.php" method="GET">
            <button type="submit" class="btn-upload">
                Upload Products
            </button>
        </form>
    </div>
<?php endif; ?>

  <section class="hero">
    <div class="hero-content">
      <h1>
        Healty <span class="highlight1">Eating is <br>an </span><span class="highlight2"> Important </span>Part <br>of Lifestyle
      </h1>
      <p>Straight from the farm to your doorstep, Quality you can trust every day.</p>
      <a href="#products"><button class="explore-btn">Explore Now</button></a>
    </div>

    <div class="hero-image">
      <img src="../assets/images/homepage.png" alt="Food Bowl">
      <!-- <div class="info-card">
        <div>
          <h4> <i class='bx  bxs-truck'  style='color: black'  ></i> Fast Delivery</h4>
          <p>Promised to Deliver Within 30 Min</p>
        </div>
        <div>
          <h4> <i class='bx  bxs-shopping-bag-alt'  style='color: black'  ></i> Pick Up</h4>
          <p>Pickup Delivery At Your Doorstep</p>
        </div> -->
      </div>
    </div>
  </section>

<!-- /*---------------------------------- Categories Section ----------------------------------*/ -->
<br>
<h1 class="heading" id="products">Our Products</h1>
<div class="homepage-wrapper" >
    <div class="homepage-carousel">
      <button class="homepage-nav-btn" id="homepage-prev">❮</button>
      <div class="homepage-cards">
        <div class="homepage-card homepage-pink">
          <img src="../assets/images/fruits.png" alt="fruits">
          <h3>Fruits</h3>
          <button class="homepage-order-btn">Order Now</button>
        </div>

        <div class="homepage-card homepage-orange">
          <img src="../assets/images/vegetables.png" alt="vegetables">
          <h3>Vegetables</h3>
          <button class="homepage-order-btn">Order Now</button>
        </div>

        <div class="homepage-card homepage-green">
          <img src="../assets/images/dairyproducts.png" alt="dairyproducts">
          <h3>Dairy Products</h3>
          <button class="homepage-order-btn">Order Now</button>
        </div>

        <div class="homepage-card homepage-blue">
          <img src="../assets/images/grains_and_pulses.png" alt="grains_and_pulses">
          <h3>Grains and Pulses</h3>
          <button class="homepage-order-btn">Order Now</button>
        </div>

        <div class="homepage-card homepage-red">
          <img src="../assets/images/herbss.webp" alt="herbs">
          <h3>Herbs</h3>
          <button class="homepage-order-btn">Order Now</button>
        </div>
      </div>
      <button class="homepage-nav-btn" id="homepage-next">❯</button>
    </div>
  </div>

<!-- /*---------------------------------- Categories Section End----------------------------------*/ -->






<!-- /*---------------------------------- Promotions Section ----------------------------------*/ -->

<br><br>
  <div class="fm-container">
        <h1 class="fm-heading" id="categories">Our Categories</h1>
        <div class="fm-content">
            <div class="fm-left">
                <div class="fm-featured">
                    <h2 class="fm-featured-title">Fresh From<br>Farm</h2>
                    <span class="fm-badge">NEW!</span>
                    <div class="fm-featured-icon">🥬</div>
                </div>
                <div class="fm-card">
                    <img src="https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=400&h=300&fit=crop" alt="Fruits">
                    <div class="fm-overlay"><button class="fm-btn">ORDER NOW</button></div>
                </div>
                <div class="fm-card">
                    <img src="https://images.unsplash.com/photo-1619566636858-adf3ef46400b?w=400&h=300&fit=crop" alt="Vegetables">
                    <div class="fm-overlay"><button class="fm-btn">ORDER NOW</button></div>
                </div>
            </div>
            <div class="fm-right">
                <a href="categories.php">
                    <div class="fm-cat">
                    <div class="fm-icon">🍎</div>
                    <div><h3 class="fm-cat-title">Fresh Fruits</h3><p class="fm-cat-desc">We provide fresh seasonal fruits directly from local farms</p></div>
                </div>
                </a>
                
                <a href="categories.php">
                <div class="fm-cat">
                    <div class="fm-icon">🥕</div>
                    <div><h3 class="fm-cat-title">Fresh Vegetables</h3><p class="fm-cat-desc">We provide organic vegetables harvested daily for you</p></div>
                </div>
                </a>

                <a href="categories.php">
                <div class="fm-cat">
                    <div class="fm-icon">🥛</div>
                    <div><h3 class="fm-cat-title">Dairy Products</h3><p class="fm-cat-desc">We provide fresh dairy products from trusted local farms</p></div>
                </div>
                </a>

            </div>
        </div>
    </div>

<!-- /*---------------------------------- Promotions Section End----------------------------------*/ -->
<!-- /*---------------------------------- Best Selling Products Section ----------------------------------*/ -->

<div class="container">
    <div class="section-header">
        <h2 class="section-title">Best Selling Products</h2>
        <div class="nav-buttons">
            <button class="nav-btn"><i class="fas fa-arrow-left"></i></button>
            <button class="nav-btn active"><i class="fas fa-arrow-right"></i></button>
        </div>
    </div>

    <div class="carousel-wrapper">

        <!-- PRODUCT 1 -->
        <form action="cart.php" method="POST" class="card">
            <div class="badge">-25%</div>
            <button type="button" class="wishlist-btn active"><i class="fas fa-heart"></i></button>

            <div class="card-image-wrapper">
                <img src="../assets/images/tomatoes.png" alt="Vegetables" class="card-image">
            </div>

            <div class="card-content">
                <p class="card-category">Vegetables</p>
                <h3 class="card-title">Farm fresh organic Tomates 250g</h3>
                <div class="card-price">$7.99 <span class="card-unit">/kg</span></div>
            </div>

            <!-- Hidden values -->
            <input type="hidden" name="product_id" value="1">
            <input type="hidden" name="product_name" value="Farm fresh organic Tomates 250g">
            <input type="hidden" name="price" value="7.99">
            <input type="hidden" name="image" value="../assets/images/tomatoes.png">
            <input type="hidden" name="quantity" class="quantity-field" value="1">

            <div class="card-actions">
                <div class="counter">
                    <button type="button" class="counter-btn minus">-</button>
                    <input type="text" class="counter-input" value="1" readonly>
                    <button type="button" class="counter-btn plus">+</button>
                </div>
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        </form>

        <!-- PRODUCT 2 -->
        <form action="cart.php" method="POST" class="card">
            <div class="badge">-25%</div>
            <button type="button" class="wishlist-btn"><i class="far fa-heart"></i></button>

            <div class="card-image-wrapper">
                <img src="../assets/images/banana.png" alt="Bananas" class="card-image">
            </div>

            <div class="card-content">
                <p class="card-category">Bananas</p>
                <h3 class="card-title">Farm fresh organic Bananas 1 kg</h3>
                <div class="card-price">$11.00 <span class="card-unit">/kg</span></div>
            </div>

            <input type="hidden" name="product_id" value="2">
            <input type="hidden" name="product_name" value="Farm fresh organic Bananas 1 kg">
            <input type="hidden" name="price" value="11.00">
            <input type="hidden" name="image" value="../assets/images/banana.png">
            <input type="hidden" name="quantity" class="quantity-field" value="1">

            <div class="card-actions">
                <div class="counter">
                    <button type="button" class="counter-btn minus">-</button>
                    <input type="text" class="counter-input" value="1" readonly>
                    <button type="button" class="counter-btn plus">+</button>
                </div>
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        </form>

        <!-- PRODUCT 3 -->
        <form action="cart.php" method="POST" class="card">
            <div class="badge">-25%</div>
            <button type="button" class="wishlist-btn"><i class="far fa-heart"></i></button>

            <div class="card-image-wrapper">
                <img src="../assets/images/honey.png" alt="Honey" class="card-image">
            </div>

            <div class="card-content">
                <p class="card-category">Honey</p>
                <h3 class="card-title">Farm fresh organic honey 500g</h3>
                <div class="card-price">$11.00 <span class="card-unit">/kg</span></div>
            </div>

            <input type="hidden" name="product_id" value="3">
            <input type="hidden" name="product_name" value="Farm fresh organic honey 500g">
            <input type="hidden" name="price" value="11.00">
            <input type="hidden" name="image" value="../assets/images/honey.png">
            <input type="hidden" name="quantity" class="quantity-field" value="1">

            <div class="card-actions">
                <div class="counter">
                    <button type="button" class="counter-btn minus">-</button>
                    <input type="text" class="counter-input" value="1" readonly>
                    <button type="button" class="counter-btn plus">+</button>
                </div>
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        </form>

        <!-- PRODUCT 4 -->
        <form action="cart.php" method="POST" class="card">
            <div class="badge">-25%</div>
            <button type="button" class="wishlist-btn"><i class="far fa-heart"></i></button>

            <div class="card-image-wrapper">
                <img src="../assets/images/orange.png" alt="Oranges" class="card-image">
            </div>

            <div class="card-content">
                <p class="card-category">Fruits</p>
                <h3 class="card-title">Full Fresh organic orange 500g</h3>
                <div class="card-price">$11.00 <span class="card-unit">/kg</span></div>
            </div>

            <input type="hidden" name="product_id" value="4">
            <input type="hidden" name="product_name" value="Fresh organic orange 500g">
            <input type="hidden" name="price" value="11.00">
            <input type="hidden" name="image" value="../assets/images/orange.png">
            <input type="hidden" name="quantity" class="quantity-field" value="1">

            <div class="card-actions">
                <div class="counter">
                    <button type="button" class="counter-btn minus">-</button>
                    <input type="text" class="counter-input" value="1" readonly>
                    <button type="button" class="counter-btn plus">+</button>
                </div>
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        </form>

        <!-- PRODUCT 5 -->
        <form action="cart.php" method="POST" class="card">
            <div class="badge">-25%</div>
            <button type="button" class="wishlist-btn"><i class="far fa-heart"></i></button>

            <div class="card-image-wrapper">
                <img src="../assets/images/orange.png" alt="Oranges" class="card-image">
            </div>

            <div class="card-content">
                <p class="card-category">Fruits</p>
                <h3 class="card-title">Full Fresh organic orange 500g</h3>
                <div class="card-price">$11.00 <span class="card-unit">/kg</span></div>
            </div>

            <input type="hidden" name="product_id" value="4">
            <input type="hidden" name="product_name" value="Fresh organic orange 500g">
            <input type="hidden" name="price" value="11.00">
            <input type="hidden" name="image" value="../assets/images/orange.png">
            <input type="hidden" name="quantity" class="quantity-field" value="1">

            <div class="card-actions">
                <div class="counter">
                    <button type="button" class="counter-btn minus">-</button>
                    <input type="text" class="counter-input" value="1" readonly>
                    <button type="button" class="counter-btn plus">+</button>
                </div>
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        </form>

        <!-- PRODUCT 6 -->
        <form action="cart.php" method="POST" class="card">
            <div class="badge">-25%</div>
            <button type="button" class="wishlist-btn"><i class="far fa-heart"></i></button>

            <div class="card-image-wrapper">
                <img src="../assets/images/orange.png" alt="Oranges" class="card-image">
            </div>

            <div class="card-content">
                <p class="card-category">Fruits</p>
                <h3 class="card-title">Full Fresh organic orange 500g</h3>
                <div class="card-price">$11.00 <span class="card-unit">/kg</span></div>
            </div>

            <input type="hidden" name="product_id" value="4">
            <input type="hidden" name="product_name" value="Fresh organic orange 500g">
            <input type="hidden" name="price" value="11.00">
            <input type="hidden" name="image" value="../assets/images/orange.png">
            <input type="hidden" name="quantity" class="quantity-field" value="1">

            <div class="card-actions">
                <div class="counter">
                    <button type="button" class="counter-btn minus">-</button>
                    <input type="text" class="counter-input" value="1" readonly>
                    <button type="button" class="counter-btn plus">+</button>
                </div>
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        </form>
        <!-- PRODUCT 7 -->
        <form action="cart.php" method="POST" class="card">
            <div class="badge">-25%</div>
            <button type="button" class="wishlist-btn"><i class="far fa-heart"></i></button>

            <div class="card-image-wrapper">
                <img src="../assets/images/orange.png" alt="Oranges" class="card-image">
            </div>

            <div class="card-content">
                <p class="card-category">Fruits</p>
                <h3 class="card-title">Full Fresh organic orange 500g</h3>
                <div class="card-price">$11.00 <span class="card-unit">/kg</span></div>
            </div>

            <input type="hidden" name="product_id" value="4">
            <input type="hidden" name="product_name" value="Fresh organic orange 500g">
            <input type="hidden" name="price" value="11.00">
            <input type="hidden" name="image" value="../assets/images/orange.png">
            <input type="hidden" name="quantity" class="quantity-field" value="1">

            <div class="card-actions">
                <div class="counter">
                    <button type="button" class="counter-btn minus">-</button>
                    <input type="text" class="counter-input" value="1" readonly>
                    <button type="button" class="counter-btn plus">+</button>
                </div>
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        </form>

        <!-- PRODUCT 8 -->
        <form action="cart.php" method="POST" class="card">
            <div class="badge">-25%</div>
            <button type="button" class="wishlist-btn"><i class="far fa-heart"></i></button>

            <div class="card-image-wrapper">
                <img src="../assets/images/orange.png" alt="Oranges" class="card-image">
            </div>

            <div class="card-content">
                <p class="card-category">Fruits</p>
                <h3 class="card-title">Full Fresh organic orange 500g</h3>
                <div class="card-price">$11.00 <span class="card-unit">/kg</span></div>
            </div>

            <input type="hidden" name="product_id" value="4">
            <input type="hidden" name="product_name" value="Fresh organic orange 500g">
            <input type="hidden" name="price" value="11.00">
            <input type="hidden" name="image" value="../assets/images/orange.png">
            <input type="hidden" name="quantity" class="quantity-field" value="1">

            <div class="card-actions">
                <div class="counter">
                    <button type="button" class="counter-btn minus">-</button>
                    <input type="text" class="counter-input" value="1" readonly>
                    <button type="button" class="counter-btn plus">+</button>
                </div>
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        </form>
        <!-- PRODUCT 9 -->
        <form action="cart.php" method="POST" class="card">
            <div class="badge">-25%</div>
            <button type="button" class="wishlist-btn"><i class="far fa-heart"></i></button>

            <div class="card-image-wrapper">
                <img src="../assets/images/orange.png" alt="Oranges" class="card-image">
            </div>

            <div class="card-content">
                <p class="card-category">Fruits</p>
                <h3 class="card-title">Full Fresh organic orange 500g</h3>
                <div class="card-price">$11.00 <span class="card-unit">/kg</span></div>
            </div>

            <input type="hidden" name="product_id" value="4">
            <input type="hidden" name="product_name" value="Fresh organic orange 500g">
            <input type="hidden" name="price" value="11.00">
            <input type="hidden" name="image" value="../assets/images/orange.png">
            <input type="hidden" name="quantity" class="quantity-field" value="1">

            <div class="card-actions">
                <div class="counter">
                    <button type="button" class="counter-btn minus">-</button>
                    <input type="text" class="counter-input" value="1" readonly>
                    <button type="button" class="counter-btn plus">+</button>
                </div>
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        </form>
        <!-- PRODUCT 10 -->
        <form action="cart.php" method="POST" class="card">
            <div class="badge">-25%</div>
            <button type="button" class="wishlist-btn"><i class="far fa-heart"></i></button>

            <div class="card-image-wrapper">
                <img src="../assets/images/orange.png" alt="Oranges" class="card-image">
            </div>

            <div class="card-content">
                <p class="card-category">Fruits</p>
                <h3 class="card-title">Full Fresh organic orange 500g</h3>
                <div class="card-price">$11.00 <span class="card-unit">/kg</span></div>
            </div>

            <input type="hidden" name="product_id" value="4">
            <input type="hidden" name="product_name" value="Fresh organic orange 500g">
            <input type="hidden" name="price" value="11.00">
            <input type="hidden" name="image" value="../assets/images/orange.png">
            <input type="hidden" name="quantity" class="quantity-field" value="1">

            <div class="card-actions">
                <div class="counter">
                    <button type="button" class="counter-btn minus">-</button>
                    <input type="text" class="counter-input" value="1" readonly>
                    <button type="button" class="counter-btn plus">+</button>
                </div>
                <button type="submit" class="add-to-cart-btn">
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        </form>

    </div>

    
</div>

<!-- /*---------------------------------- Best Selling Products Section Ends----------------------------------*/ -->


<!-- /*---------------------------------- Footer Section ----------------------------------*/ --> 
<div class="footer-wrapper">
        <i class="fa-solid fa-leaf leaf-decoration leaf-top-right"></i>
        <i class="fa-solid fa-leaf leaf-decoration leaf-bottom-left"></i>
        <i class="fa-solid fa-leaf leaf-decoration leaf-falling-1"></i>
        <i class="fa-solid fa-leaf leaf-decoration leaf-falling-2"></i>
        <i class="fa-solid fa-pepper-hot leaf-decoration leaf-falling-3"></i>

        <div class="footer-content">
            
            <!-- Brand -->
            <div class="brand-col">
                <div class="logo">
                    <img src="../assets/images/Logo.png" alt="RecoltePure Logo" sizes="4x4"/>
                    <div class="logo-text">
                        <span>RecoltePure</span>
                        <span></span>
                    </div>
                </div>
                <br>
                <div class="social-icons">
                    <a href="#" class="social-btn"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social-btn"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="social-btn"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="social-btn"><i class="fa-brands fa-pinterest"></i></a>
                </div>
            </div>

            <!-- Categories -->
            <div class="links-col">
                <h3>Categories</h3>
                <ul>
                    <li><a href="#">Fruits & Vegetables</a></li>
                    <li><a href="#">Dairy Products</a></li>
                    <li><a href="#">Package Foods</a></li>
                    <li><a href="#">Beverage</a></li>
                    <li><a href="#">Health & Wellness</a></li>
                </ul>
            </div>

            <!--Useful Links -->
            <div class="links-col">
                <h3>Useful Links</h3>
                <ul>
                    <li><a href="#">Payment & Tax</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Store Location</a></li>
                    <li><a href="#">Return Policy</a></li>
                    <li><a href="#">Discount</a></li>
                </ul>
            </div>

            <!--Newsletter -->
            <div class="newsletter-col">
                <h3>Newsletter</h3>
                <p class="newsletter-text">Get now free 20% discount for all products on your first order</p>
                
                <form class="newsletter-form">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" placeholder="Your Email address...">
                    <button type="submit"><i class="fa-solid fa-arrow-right"></i></button>
                </form>

                <div class="contact-info">
                    <div>T : +1-202-555-0184</div>
                    <div>E : hello@example.com</div>
                </div>
            </div>
        </div>

       
        
    </div>
 <!-- /*---------------------------------- Footer Section Ends----------------------------------*/ -->     
    <div class="footer-bottom">
            <div class="copyright">
                &copy; 2025 RecoltePure. All rights reserved.
            </div>
            
            <div class="bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms & Conditions</a>
                <a href="#">Cookies/Ad Choices</a>
            </div>

            <div class="payment-icons">
                <i class="fa-brands fa-cc-mastercard pay-icon"></i>
                <i class="fa-brands fa-cc-paypal pay-icon"></i>
                <i class="fa-brands fa-cc-visa pay-icon"></i>
            </div>
        </div>




<script>
document.addEventListener("DOMContentLoaded", function () {
    const btn = document.querySelector(".user-btn");
    const menu = document.querySelector(".dropdown-menu");

    if (btn) {
        btn.addEventListener("click", () => {
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        });
    }
    document.addEventListener("click", function(e) {
        if (!btn.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = "none";
        }
    });
});



window.addEventListener("scroll", function() {
    const navbar = document.querySelector(".navbar");
    if (window.scrollY > 100) { 
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});


document.querySelectorAll(".card").forEach(card => {
    const minusBtn = card.querySelector(".minus");
    const plusBtn  = card.querySelector(".plus");
    const counterInput = card.querySelector(".counter-input");
    const quantityField = card.querySelector(".quantity-field");

    plusBtn.addEventListener("click", () => {
        let value = parseInt(counterInput.value);
        value++;
        counterInput.value = value;
        quantityField.value = value;
    });

    minusBtn.addEventListener("click", () => {
        let value = parseInt(counterInput.value);
        if (value > 1) {
            value--;
            counterInput.value = value;
            quantityField.value = value;
        }
    });
});


const wrapper = document.querySelector(".carousel-wrapper");
const prevBtn = document.querySelectorAll(".nav-btn")[0];
const nextBtn = document.querySelectorAll(".nav-btn")[1];

const scrollAmount = 270; 
nextBtn.addEventListener("click", () => {
    wrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
});


prevBtn.addEventListener("click", () => {
    wrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
});

</script>


</body>


</html>
