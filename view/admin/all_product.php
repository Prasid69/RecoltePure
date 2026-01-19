
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | RecoltePure</title>
  <base href="/RecoltePure/">

    <link rel="stylesheet" href="/RecoltePure/assets/css/admin_users.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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

    <a href="/RecoltePure/admin/logout"  class="logout">
                <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
            </a>
        </nav>
  </header>
<main class="admin-main">
    <div class="top-action-bar">
        <h2>Global Inventory Management</h2>
    </div>

    <form action="index.php" method="GET" class="search-box">
                <input type="hidden" name="page" value="admin">
                <input type="hidden" name="action" value="users"> 
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search users by name or email..." 
                       value="<?= htmlspecialchars($search ?? '') ?>">
            </form>
    <br>

    <div class="charts-section" style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px; margin-bottom: 30px;">
        <div class="panel chart-panel" style="height: 350px;">
            <h3>Products by Category</h3>
            <canvas id="categoryPieChart" 
                data-labels='<?= json_encode(array_column($categoryStats, "category_name")) ?>'
                data-values='<?= json_encode(array_column($categoryStats, "total_products")) ?>'>
            </canvas>
        </div>
        
        <div class="panel">
            <h3>Quick Stats</h3>
            <div class="stats-mini" style="display: flex; gap: 20px; margin-top: 20px;">
                <div class="stat-box">
                    <strong>Total Items:</strong> <?= count($products) ?>
                </div>
            </div>
        </div>
    </div>

    <section class="panel">
        <table class="user-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Farmer</th>
                    <th>Price</th>
                    <th>Stock Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($p['product_name']) ?></strong><br>
                        <small><?= htmlspecialchars($p['category_name']) ?></small>
                    </td>
                    <td>
                        <?= htmlspecialchars($p['farmer_name']) ?><br>
                        <small><?= htmlspecialchars($p['farmer_location']) ?></small>
                    </td>
                    <td>€<?= number_format($p['price'], 2) ?></td>
                    <td>
                        <?php if ($p['stock_quantity'] <= 10): ?>
                            <span class="status-pending" style="color: red; font-weight: bold;">Low Stock: <?= $p['stock_quantity'] ?></span>
                        <?php else: ?>
                            <span class="status-verified">In Stock: <?= $p['stock_quantity'] ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="actions" style="text-align: right;">
                        
                    <a href="admin/delete-product/<?= $p['product_id'] ?>" class="btn-icon text-danger" onclick="return confirm('Are you sure you want to delete this product?');">
                     <i class="fas fa-trash"></i>
                    </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
   
    const pieCtx = document.getElementById('categoryPieChart');
    
    if (pieCtx) {
        const pieLabels = JSON.parse(pieCtx.getAttribute('data-labels') || '[]');
        const pieValues = JSON.parse(pieCtx.getAttribute('data-values') || '[]');

        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieValues,
                    backgroundColor: [
                        '#FF2A00', // Brand Red
                        '#4CAF50', // Success Green
                        '#FFC107', // Warning Yellow
                        '#2196F3', // Info Blue
                        '#9C27B0', // Purple
                        '#FF5722'  // Orange
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 12, padding: 15 }
                    }
                }
            }
        });
    }

    const orderCanvas = document.getElementById('chartOrdersPerFarmer');
    if (orderCanvas) {
        new Chart(orderCanvas, {
            type: 'bar',
            data: {
                labels: JSON.parse(orderCanvas.getAttribute('data-labels') || '[]'),
                datasets: [{
                    label: 'Orders',
                    data: JSON.parse(orderCanvas.getAttribute('data-values') || '[]'),
                    backgroundColor: '#FF2A00'
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }
});
</script>