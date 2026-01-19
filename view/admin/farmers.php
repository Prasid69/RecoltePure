<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management | RecoltePure</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <base href="/RecoltePure/">

    <link rel="stylesheet" href="/RecoltePure/assets/css/admin_users.css">
</head>

<body>

    <header class="admin-header">
        <div class="brand">
            <img src="assets/uploads/products/Logo.png" alt="Logo">
            <span>RecoltePure Admin</span>
        </div>
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

            <a href="index.php?page=admin&action=logout" class="logout">
                <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
            </a>
        </nav>
    </header>
    <main class="admin-main">
        <div class="top-action-bar">
            <h2>Farmers Management</h2>
            <div class="admin-profile">
                <button class="admin-initial-btn">A</button>
            </div>
        </div>

        <section class="stats">
            <div class="stat">
                <div class="num"><?= (int) ($stats['total_farmers'] ?? 0) ?></div>
                <div class="label">Total Farmers</div>
            </div>
            <div class="stat">
                <div class="num"><?= (int) ($stats['pending_verifications'] ?? 0) ?></div>
                <div class="label">Pending Approval</div>
            </div>
            <div class="stat">
                <div class="num">€<?= number_format((float) ($stats['total_revenue'] ?? 0), 2) ?></div>
                <div class="label">Total Revenue</div>
            </div>
        </section>


        <div class="charts-section">
            <div class="panel chart-panel">
                <h2>Orders per Farmer</h2>
                <canvas id="chartOrdersPerFarmer" data-labels='<?= json_encode(array_column($allFarmers, "name")) ?>'
                    data-values='<?= json_encode(array_column($allFarmers, "orders_completed")) ?>'>
                </canvas>
            </div>
            <div class="panel chart-panel">
                <h2>Top Revenue Generators</h2>
                <canvas id="chartTopFarmers" data-labels='<?= json_encode(array_column($allFarmers, "name")) ?>'
                    data-values='<?= json_encode(array_column($allFarmers, "revenue")) ?>'>
                </canvas>
            </div>
        </div>

        <section class="panel">
            <div class="panel-header">
                <h2>Farmer Directory & Performance</h2>
            </div>




            <div class="table-wrapper">
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>Farmer / Location</th>
                            <th>Products</th>
                            <th>Status</th>
                            <th>Performance</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allFarmers as $farmer): ?>
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <strong><?= htmlspecialchars($farmer['name']) ?></strong>
                                        <small><i class="fas fa-map-marker-alt"></i>
                                            <?= htmlspecialchars($farmer['address']) ?></small>
                                    </div>
                                </td>
                                <<td>
                                    <span class="badge"><?= (int) ($farmer['total_products'] ?? 0) ?> Items</span>
                                    </td>
                                    <td>
                                        <?php if ($farmer['account_status'] === 'Verified'): ?>
                                            <span class="status status-verified">Approved</span>
                                        <?php elseif ($farmer['account_status'] === 'Rejected'): ?>
                                            <span class="status status-pending"
                                                style="background:#fdeaea; color:#e74c3c;">Rejected</span>
                                        <?php else: ?>
                                            <span class="status status-pending">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small>Orders: <?= (int) ($farmer['orders_completed'] ?? 0) ?></small><br>
                                        <strong>$<?= number_format((float) ($farmer['revenue'] ?? 0), 2) ?></strong>
                                    </td>
                                    <td class="actions">
                                        <a href="admin/farmer-products/<?= $farmer['farmer_id'] ?>" class="btn-icon">
                                            <i class="fas fa-seedling"></i>
                                        </a>

                                        <?php if ($farmer['account_status'] === 'Pending'): ?>
                                            <a href="index.php?page=admin&action=verify_farmer&id=<?= $farmer['farmer_id'] ?>&status=Verified"
                                                class="btn-icon text-success" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a href="index.php?page=admin&action=verify_farmer&id=<?= $farmer['farmer_id'] ?>&status=Rejected"
                                                class="btn-icon text-danger" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>




    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Prepare the data from PHP
            const farmerNames = <?= json_encode(array_column($allFarmers, 'name')) ?>;
            const orderData = <?= json_encode(array_column($allFarmers, 'orders_completed')) ?>;
            const revenueData = <?= json_encode(array_column($allFarmers, 'revenue')) ?>;

            // 2. Orders per Farmer Chart
            const ctxOrders = document.getElementById('chartOrdersPerFarmer').getContext('2d');
            new Chart(ctxOrders, {
                type: 'bar',
                data: {
                    labels: farmerNames,
                    datasets: [{
                        label: 'Orders',
                        data: orderData,
                        backgroundColor: '#FF2A00', // Your brand red
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });

            // 3. Top Revenue Generators Chart
            const ctxRevenue = document.getElementById('chartTopFarmers').getContext('2d');
            new Chart(ctxRevenue, {
                type: 'line',
                data: {
                    labels: farmerNames,
                    datasets: [{
                        label: 'Revenue ($)',
                        data: revenueData,
                        borderColor: '#4CAF50', // Success green
                        backgroundColor: 'rgba(76, 175, 80, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
        });
    </script>
</body>

</html>