<?php
session_start();
include "../config/db_connection.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$conditions = "FROM products WHERE 1=1";


if ($search !== '') {
    $search_safe = mysqli_real_escape_string($db, $search);
    $conditions .= " AND (product_name LIKE '%$search_safe%' OR description LIKE '%$search_safe%')";
}


if ($category_id != 0) {
    $conditions .= " AND category_id = $category_id";
}

$items_per_page = 12; 
$offset = ($page - 1) * $items_per_page;

$total_sql = "SELECT COUNT(*) as total " . $conditions;
$total_result = mysqli_query($db, $total_sql);

if (!$total_result) {
    die("Count Query Failed: " . mysqli_error($db));
}

$total_row = mysqli_fetch_assoc($total_result);
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);


if ($sort === 'low') {
    $prod_sql .= " ORDER BY price ASC";
} elseif ($sort === 'high') {
    $order_sql = " ORDER BY price DESC";
} elseif ($sort === "newest") {
    $order_sql = " ORDER BY created_on DESC";
} elseif ($sort === "oldest") {
    $order_sql = " ORDER BY created_on ASC";
} else {
    $order_sql = " ORDER BY product_id DESC"; 
}

$final_sql = "SELECT * " . $conditions . $order_sql . " LIMIT $offset, $items_per_page";


$products = mysqli_query($db, $final_sql);

if (!$products) {
    die("Final Query Failed: " . mysqli_error($db));
}

$categories = mysqli_query($db, "SELECT * FROM categories");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecoltPure | Shopping | vegetable</title>
    <link rel="stylesheet" href="../assets/css/categories.css"></link>
    <link href="https://fonts.googleapis.com/css2?fami  ly=Lato:wght@300;400;700&family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
</head>
<body>
    <!-- Header / Hero Section -->
    <header class="page-header">
        <h1>Shop</h1>

         <div class="back-home">
            <a href="homepage.php">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Back to Home
            </a>
        </div>
       
        
    </header>

   

    <div class="container">

        <!-- Categories Section -->
        <section class="categories-section">
            <div class="subtitle">When health is organic</div>
            <h2 class="section-title">Shop Our Organic Products</h2>
            
            <div class="category-list">
                <?php while($cat = mysqli_fetch_assoc($categories)) : ?>
                    <a href="categories.php?category_id=<?php echo $cat['category_id']; ?>">
                        <div class="category-item">
                            <div class="cat-img-wrapper">
                                 <img src="../assets/uploads/products/Fruits.png" alt="Category Image">
                            </div>
                             <h4><?php echo ucfirst($cat['category_name']); ?></h4>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>

        </section>

        <!-- Sort / Filter Bar -->
        <div class="toolbar">
            <div class="showing-text">Showing 1-10 of 20 Items</div>
            <div class="actions">
                <span class="view-options">
                    <i class="fas fa-th-large" id="gridView"></i>
                    <i class="fas fa-list" id="listView"></i>
                </span>
                <select class="sort-select" style="margin-left: 15px;" onchange="location='?category_id=<?php echo $category_id; ?>&sort=' + this.value;">
                    <option value="">Default Sorting</option>
                    <option value="low" <?php if($sort=='low') echo 'selected'; ?>>Price: Low to High</option>
                    <option value="high" <?php if($sort=='high') echo 'selected'; ?>>Price: High to Low</option>
                    <option value="newest" <?php if($sort=='newest') echo 'selected'; ?>>Newest Arrivals</option>
                    <option value="oldest" <?php if($sort=='oldest') echo 'selected'; ?>>Oldest Arrivals</option>
                </select>

            </div>
        </div>

        

        <!-- Product Grid -->
        <div class="product-grid" id="productGrid">
            <?php while($prod = mysqli_fetch_assoc($products)) : ?>
                <div class="product-card">
                    <span class="badge"><?php echo $prod['stock_quantity']; ?></span>
                    <img src="../assets/uploads/products/<?php echo $prod['image']; ?>" alt="<?php echo $prod['product_name']; ?>" class="product-img">
                    <div class="product-cat">
                        <?php 
                        $cat_name = mysqli_fetch_assoc(mysqli_query($db, "SELECT category_name FROM categories WHERE category_id=".$prod['category_id']));
                        echo ucfirst($cat_name['category_name']);
                        ?>
        </div>

        <h3 class="product-title"><?php echo $prod['product_name']; ?></h3>
        <div class="product-footer">
            <div>
                <span class="price">$<?php echo $prod['price']; ?></span>
                <?php if (!empty($prod['old_price']) && $prod['old_price'] != $prod['price']) : ?>
                <span class="old-price" style="text-decoration: line-through;">
                $<?php echo $prod['old_price']; ?>
                </span>
                <?php endif; ?>
            </div>
            <form method="POST" action="cart.php">
    <input type="hidden" name="product_id" value="<?php echo $prod['product_id']; ?>">
    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($prod['product_name']); ?>">
    <input type="hidden" name="price" value="<?php echo $prod['price']; ?>">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="image" value="../assets/uploads/products/<?php echo $prod['image']; ?>">
    <button type="submit" class="add-btn">
        <i class="fas fa-shopping-bag"></i>
    </button>
</form>


        </div>
    </div>
<?php endwhile; ?>
</div>


        <!-- Pagination -->
        <div class="pagination">
    <?php if ($page > 1): ?>
        <a class="page-btn" href="?category_id=<?= $category_id ?>&sort=<?= $sort ?>&page=<?= $page - 1 ?>">Prev</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a class="page-btn <?= ($i == $page) ? 'active' : '' ?>"
           href="?category_id=<?= $category_id ?>&sort=<?= $sort ?>&page=<?= $i ?>">
           <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a class="page-btn" href="?category_id=<?= $category_id ?>&sort=<?= $sort ?>&page=<?= $page + 1 ?>">Next</a>
    <?php endif; ?>
</div>




<script>
document.addEventListener("DOMContentLoaded", function() {
    const productGrid = document.getElementById("productGrid");
    const gridBtn = document.getElementById("gridView");
    const listBtn = document.getElementById("listView");

    if (!productGrid) {
        console.error("productGrid element not found. Make sure <div id='productGrid'> exists.");
        return;
    }

    if (!productGrid.classList.contains("grid-view") && !productGrid.classList.contains("list-view")) {
        productGrid.classList.add("grid-view");
    }

    function setActive(btn) {
        if (!gridBtn || !listBtn) return;
        gridBtn.classList.remove("active-view");
        listBtn.classList.remove("active-view");
        btn.classList.add("active-view");
    }

    if (gridBtn) {
        gridBtn.addEventListener("click", function() {
            productGrid.classList.add("grid-view");
            productGrid.classList.remove("list-view");
            setActive(gridBtn);
        });
    }

    if (listBtn) {
        listBtn.addEventListener("click", function() {
            productGrid.classList.add("list-view");
            productGrid.classList.remove("grid-view");
            setActive(listBtn);
        });
    }


    if (productGrid.classList.contains("list-view") && listBtn) setActive(listBtn);
    else if (gridBtn) setActive(gridBtn);
});
</script>


</body>
</html>