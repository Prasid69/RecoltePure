<?php
$current_action = $_GET['action'] ?? 'dashboard';
?>
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
        <h2>Order Management</h2>
        <div class="filters">
            <a href="index.php?page=admin&action=orders&time=today" class="btn-filter">Today</a>
            <div class="filters">
                <select onchange="location.href='index.php?page=admin&action=orders&status=' + this.value">
                    <option value="all" <?= ($_GET['status'] ?? '') == 'all' ? 'selected' : '' ?>>All Statuses</option>
                    <option value="Pending" <?= ($_GET['status'] ?? '') == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Delivered" <?= ($_GET['status'] ?? '') == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                </select>
            </div>
        </div>
    </div>


   <div class="charts-container" style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 30px; align-items: start;">
    
    <div class="panel">
        <h3>Orders Trend</h3>
        <div style="height: 300px;">
            <canvas id="ordersLineChart" 
                data-labels='<?= json_encode(array_column($orderTrend, "order_date")) ?>'
                data-values='<?= json_encode(array_column($orderTrend, "total_orders")) ?>'>
            </canvas>
        </div>
    </div>

    <div class="panel">
        <h3>Order Status Breakdown</h3>
        <div style="height: 300px;">
            <canvas id="statusPieChart" 
                data-labels='<?= json_encode(array_column($statusStats, 'status')) ?>'
                data-values='<?= json_encode(array_column($statusStats, 'count')) ?>'>
            </canvas>
        </div>
    </div>

</div>

    
</div>

    

    <section class="panel">
        <table class="user-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Total</th>
                    <th>Status</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                <tr>
                    <td>#<?= $o['order_cart_id'] ?></td>
                    <td><?= htmlspecialchars($o['customer_name']) ?></td>
                    <td><?= htmlspecialchars($o['product_name']) ?></td>
                    <td>€<?= number_format($o['total_price'], 2) ?></td>
                    <td>
                        <span class="status-badge <?= strtolower($o['status']) ?>">
                            <?= $o['status'] ?>
                        </span>
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
    const ctx = document.getElementById('statusPieChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: JSON.parse(ctx.getAttribute('data-labels')),
                datasets: [{
                    data: JSON.parse(ctx.getAttribute('data-values')),
                    backgroundColor: ['#FFC107', '#4CAF50', '#F44336']
                }]
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const lineCtx = document.getElementById('ordersLineChart');
    if (lineCtx) {
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: JSON.parse(lineCtx.getAttribute('data-labels') || '[]'),
                datasets: [{
                    label: 'Daily Orders',
                    data: JSON.parse(lineCtx.getAttribute('data-values') || '[]'),
                    borderColor: '#FF2A00', 
                    backgroundColor: 'rgba(255, 42, 0, 0.1)',
                    fill: true,
                    tension: 0.4, 
                    borderWidth: 3,
                    pointBackgroundColor: '#FF2A00'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
});
</script>