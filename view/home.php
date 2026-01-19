<?php include 'view/layout/header.php';?>

<?php if ($userData['role'] === 'farmer'): ?>
    <div class="farmer-actions">
    <a href="index.php?page=upload_product" class="btn-upload">
        Upload Products
    </a>
</div>

<?php endif; ?>

<section class="hero">
    <div class="hero-content">
      <h1>
        Healty <span class="highlight1">Eating is <br>an </span><span class="highlight2"> Important </span>Part <br>of Lifestyle
      </h1>
      <p>Straight from the farm to your doorstep, Quality you can trust every day.</p>
      <a href="/RecoltePure/categories">
    <button class="explore-btn">Explore Now</button>
</a>
    </div>

    <div class="hero-image">
      <img src="assets/uploads/products/homepage.png" alt="Food Bowl">
      </div>
   </section>



   <h1 class="fm-heading" id="products">Our Categories</h1>
   <br>
<div class="homepage-wrapper">
    <div class="homepage-carousel">
      <button class="homepage-nav-btn" id="homepage-prev">❮</button>
      <div class="homepage-cards">
        <div class="homepage-card homepage-pink">
          <img src="assets/uploads/products/fruits.png" alt="fruits">
          <h3>Fruits</h3>
          <a href="index.php?page=categories&category_id=1">
          <button class="homepage-order-btn">Order Now</button>
          </a>
        </div>

        <div class="homepage-card homepage-orange">
          <img src="assets/uploads/products/vegetables.png" alt="vegetables">
          <h3>Vegetables</h3>
          <a href="index.php?page=categories&category_id=2">
          <button class="homepage-order-btn">Order Now</button>
          </a>
        </div>

        <div class="homepage-card homepage-green">
          <img src="assets/uploads/products/dairyproducts.png" alt="dairyproducts">
          <h3>Dairy Products</h3>
          <a href="index.php?page=categories&category_id=4">
          <button class="homepage-order-btn">Order Now</button>
          </a>
        </div>

        

        <div class="homepage-card homepage-red">
          <img src="assets/uploads/products/herbss.webp" alt="herbs">
          <h3>Herbs</h3>
          <a href="index.php?page=categories&category_id=3">
          <button class="homepage-order-btn">Order Now</button>
          </a>
        </div>
      </div>
      <button class="homepage-nav-btn" id="homepage-next">❯</button>
    </div>
   </div>


   <!-- <br><br>
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
                    <div class="fm-overlay">
                        <a href="index.php?page=categories&category_id=2">
                        <button class="fm-btn">ORDER NOW</button></div>
                        </a>
                </div>
                <div class="fm-card">
                    <img src="https://images.unsplash.com/photo-1619566636858-adf3ef46400b?w=400&h=300&fit=crop" alt="Vegetables">
                    <div class="fm-overlay"><button class="fm-btn">ORDER NOW</button></div>
                </div>
            </div>
            <div class="fm-right">
                <a href="index.php?page=categories&category_id=1">
                    <div class="fm-cat">
                    <div class="fm-icon">🍎</div>
                    <div><h3 class="fm-cat-title">Fresh Fruits</h3><p class="fm-cat-desc">We provide fresh seasonal fruits directly from local farms</p></div>
                </div>
                </a>
                
                <a href="index.php?page=categories&category_id=2">
                <div class="fm-cat">
                    <div class="fm-icon">🥕</div>
                    <div><h3 class="fm-cat-title">Fresh Vegetables</h3><p class="fm-cat-desc">We provide organic vegetables harvested daily for you</p></div>
                </div>
                </a>

                <a href="index.php?page=categories&category_id=4">
                <div class="fm-cat">
                    <div class="fm-icon">🥛</div>
                    <div><h3 class="fm-cat-title">Dairy Products</h3><p class="fm-cat-desc">We provide fresh dairy products from trusted local farms</p></div>
                </div>
                </a>

            </div>
        </div>
    </div> -->
<br><br>
<div class="container">
    <div class="section-header">
        <h2 class="section-title">Best Selling Products</h2>
        <div class="nav-buttons">
            <button class="nav-btn"><i class="fas fa-arrow-left"></i></button>
            <button class="nav-btn active"><i class="fas fa-arrow-right"></i></button>
        </div>
        </div>

    <div class="carousel-wrapper">
        <?php if (!empty($bestSellingProducts)): ?>
            <?php foreach ($bestSellingProducts as $product): ?>
                
                <form action="index.php?page=cart" method="POST" class="card">
                    <?php if ($product['old_price'] > $product['price']): ?>
                        <div class="badge">
                            -<?= round((($product['old_price'] - $product['price']) / $product['old_price']) * 100); ?>%
                        </div>
                    <?php endif; ?>

                    <div class="card-image-wrapper">
                        <img src="assets/uploads/products/<?= htmlspecialchars($product['image']); ?>"
                             alt="<?= htmlspecialchars($product['product_name']); ?>"
                             class="card-image">
                    </div>

                    <div class="card-content">
                        <p class="card-category"><?= htmlspecialchars($product['category_name']); ?></p>
                        <h3 class="card-title"><?= htmlspecialchars($product['product_name']); ?></h3>
                        <div class="card-price">
                            $<?= number_format($product['price'], 2); ?>
                            <span style="font-size: 0.8rem; color: #555; margin-left:5px;"> / <?= $product['stock_quantity']; ?> kg</span>
                            <span class="card-unit"></span>
                        </div>
                    </div>

                    <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['product_name']); ?>">
                    <input type="hidden" name="price" value="<?= $product['price']; ?>">
                    <input type="hidden" name="image" value="assets/uploads/products/<?= htmlspecialchars($product['image']); ?>">
                    
                    <div class="product-card">
                        <div class="card-actions">
                            <div class="counter">
                                <button type="button" class="counter-btn minus">-</button>
                                <input type="text" class="counter-input" value="1" readonly>
                                <button type="button" class="counter-btn plus">+</button>
                            </div>
                            <form action="index.php?page=cart" method="POST">
                                <input type="hidden" name="quantity" class="quantity-field" value="1">
                                <button type="submit" class="add-to-cart-btn">
                                    <i class="fas fa-shopping-bag"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                </form>

            <?php endforeach; ?>
        <?php else: ?>
            <p>No best selling products found.</p>
        <?php endif; ?>
    </div>
</div>



<?php include 'view/layout/footer.php'; ?>