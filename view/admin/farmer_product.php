<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farmer Products | RecoltePure</title>
    <base href="/RecoltePure/">

    <link rel="stylesheet" href="/RecoltePure/assets/css/admin_users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="admin-header">
    <div class="brand"><img src="assets/uploads/products/Logo.png" alt="Logo"> RecoltePure Admin</div>
    <nav>
            <a href="admin/dashboard" class="<?= ($current_action == 'dashboard') ? 'active' : '' ?>">
        <i class="fas fa-th-large"></i> <span>Dashboard</span>
    </a>

    <a href="admin/users" class="<?= ($current_action == 'users') ? 'active' : '' ?>">
        <i class="fas fa-users"></i> <span>Users</span>
    </a>

    <a href="admin/farmers" class="<?= ($current_action == 'farmers') ? 'active' : '' ?>">
        <i class="fas fa-tractor"></i> <span>Farmers</span>
    </a>

    <a href="admin/all_products" class="<?= ($current_action == 'all_products') ? 'active' : '' ?>">
        <i class="fas fa-seedling"></i> <span>All Products</span>
    </a>

    <a href="admin/orders" class="<?= ($current_action == 'orders') ? 'active' : '' ?>">
        <i class="fas fa-shopping-basket"></i> <span>Orders</span>
    </a>
    <a href="/RecoltePure/admin/logout" class="logout">
                <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
            </a>
        </nav>
  </header>
 

    <main class="admin-main">
        <div class="top-action-bar">
            <h2>Products for: <?= htmlspecialchars($currentFarmer['name'] ?? 'Farmer') ?></h2>
            <a href="index.php?page=admin&action=farmers" class="btn-icon"><i class="fas fa-arrow-left"></i> Back</a>
        </div>

        <section class="panel">
            <div class="table-wrapper">
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Stock Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <img src="assets/uploads/products/<?= $product['image'] ?>" width="50" style="border-radius: 8px;">
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($product['product_name']) ?></strong><br>
                                    <small>ID: #<?= $product['product_id'] ?></small>
                                </td>
                                <td>€<?= number_format($product['price'], 2) ?></td>
                                <td>
                                    <?php if ($product['stock_quantity'] <= 5): ?>
                                        <span class="status status-pending" style="background:#fff3e0; color:#ef6c00;">Low Stock (<?= $product['quantity'] ?>)</span>
                                    <?php else: ?>
                                        <span class="status status-verified">In Stock (<?= $product['stock_quantity'] ?>)</span>
                                    <?php endif; ?>
                                </td>
                                <td class="actions">
                                    <a href="admin/delete-product/<?= $p['product_id'] ?>" 
   class="btn-icon text-danger" 
   onclick="return confirm('Delete this product?')">
   <i class="fas fa-trash"></i>
</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center; padding: 40px;">No products found for this farmer.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>