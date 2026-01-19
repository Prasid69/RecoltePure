<?php include 'view/layout/header.php'; ?>

<link rel="stylesheet" href="assets/css/categories.css">

<div class="container">
    <section class="categories-section">
        
        
        <div class="category-list">
            <?php foreach($categories as $cat): ?>
                <a href="index.php?page=categories&category_id=<?= $cat['category_id']; ?>">
                    <div class="category-item">
                        <div class="cat-img-wrapper">
                             <img src="assets/uploads/products/Fruits.png" alt="Category">
                        </div>
                        <h4><?= ucfirst($cat['category_name']); ?></h4>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <div class="toolbar">
        <div class="showing-text">
            Showing <?= count($products) > 0 ? $offset + 1 : 0 ?>-<?= min($offset + count($products), $totalItems) ?> of <?= $totalItems ?> Items
        </div>
        <div class="actions">

            <form action="index.php" method="GET" class="search-form">
                <input type="hidden" name="page" value="categories">
                
                <?php if (isset($categoryId) && $categoryId): ?>
                    <input type="hidden" name="category_id" value="<?= htmlspecialchars($categoryId); ?>">
                <?php endif; ?>

                <div class="search-group">
                    <input type="text" name="search" placeholder="Search..." value="<?= isset($search) ? htmlspecialchars($search) : '' ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
            
            <span class="view-options">
                <i class="fas fa-th-large" id="gridView"></i>
                <i class="fas fa-list" id="listView"></i>
            </span>
            
            <select class="sort-select" style="margin-left: 15px;" 
                onchange="window.location.href='index.php?page=categories&category_id=<?= $categoryId ?>&search=<?= htmlspecialchars($search) ?>&sort=' + this.value;">
                <option value="">Default Sorting</option>
                <option value="low" <?= $sort=='low' ? 'selected' : '' ?>>Price: Low to High</option>
                <option value="high" <?= $sort=='high' ? 'selected' : '' ?>>Price: High to Low</option>
                <option value="newest" <?= $sort=='newest' ? 'selected' : '' ?>>Newest Arrivals</option>
                <option value="oldest" <?= $sort=='oldest' ? 'selected' : '' ?>>Oldest Arrivals</option>
            </select>
        </div>
    </div>


    
   <div class="product-grid grid-view" id="productGrid">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <?php if (!empty($product['old_price']) && $product['old_price'] > $product['price']): ?>
                    <span class="badge">
                        -<?= round((($product['old_price'] - $product['price']) / $product['old_price']) * 100); ?>%
                    </span>
                <?php endif; ?>

                <img src="assets/uploads/products/<?= htmlspecialchars($product['image']); ?>" 
                     alt="<?= htmlspecialchars($product['product_name']); ?>" class="product-img">

                <div class="product-cat">
                    <?php
                        $catName = 'Unknown';
                        foreach ($categories as $c) {
                            if ($c['category_id'] == $product['category_id']) {
                                $catName = $c['category_name'];
                                break;
                            }
                        }
                        echo ucfirst($catName);
                    ?>
                </div>

                <h3 class="product-title"><?= htmlspecialchars($product['product_name']); ?></h3>

                <div class="product-footer">
                    <div>
                        <span class="price">$<?= $product['price']; ?></span>
                        <span style="font-size: 0.8rem; color: #555; margin-left:5px;"> / <?= $product['stock_quantity']; ?> kg</span>
                        <?php if (!empty($product['old_price']) && $product['old_price'] != $product['price']) : ?>
                            <span class="old-price" style="text-decoration: line-through;">
                                $<?= $product['old_price']; ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <form method="POST" action="index.php?page=cart">
                        <input type="hidden" name="product_id" value="<?= $product['product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['product_name']); ?>">
                        <input type="hidden" name="price" value="<?= $product['price']; ?>">
                        <input type="hidden" name="quantity" class="quantity-input" value="1">
                        <input type="hidden" name="image" value="assets/uploads/products/<?= htmlspecialchars($product['image']); ?>">

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
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found in this category.</p>
    <?php endif; ?>
</div>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a class="page-btn" href="?page=categories&category_id=<?= $categoryId ?>&sort=<?= $sort ?>&search=<?= $search ?>&p=<?= $page - 1 ?>">Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a class="page-btn <?= ($i == $page) ? 'active' : '' ?>"
               href="?page=categories&category_id=<?= $categoryId ?>&sort=<?= $sort ?>&search=<?= $search ?>&p=<?= $i ?>">
               <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a class="page-btn" href="?page=categories&category_id=<?= $categoryId ?>&sort=<?= $sort ?>&search=<?= $search ?>&p=<?= $page + 1 ?>">Next</a>
        <?php endif; ?>
    </div>
</div>