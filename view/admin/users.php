<?php
$adminName = $_SESSION['admin_name'] ?? 'Admin';
$initial = strtoupper(substr($adminName, 0, 1));
?>
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
            <h2>Users Management</h2>

            <form action="index.php" method="GET" class="search-box">
                <input type="hidden" name="page" value="admin">
                <input type="hidden" name="action" value="users">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Search users by name or email..."
                    value="<?= htmlspecialchars($search ?? '') ?>">
            </form>

            <div class="admin-profile">
                <a href="index.php?page=admin&action=export_users" class="btn-outline">
                    <i class="fas fa-file-csv"></i>
                    Export CSV
                </a>
                <?php
                $adminEmail = $_SESSION['login_user'] ?? 'Admin';
                $initial = strtoupper(substr($adminEmail, 0, 1));
                ?>
                <div class="admin-user-wrapper">
                    <button class="admin-initial-btn">
                        <?php echo $initial; ?>
                    </button>
                    <div class="admin-dropdown">
                        <a href="profile.php">
                            <i class="fas fa-user-circle"></i> Profile
                        </a>
                        <a href="settings.php">
                            <i class="fas fa-cog"></i> Settings</a>
                        <hr>
                        <a href="index.php?page=admin&action=logout" class="text-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <section class="panel">
            <div class="panel-header">
                <h2>All Registered Users</h2>
                <p>Review and manage customer accounts</p>
            </div>

            <div class="table-wrapper">
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Details</th>
                            <th>Status</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($allUsers)): ?>

                            <?php foreach ($allUsers as $user): ?>
                                <tr>
                                    <td>#<?= $user['customer_id'] ?></td>

                                    <td>
                                        <div class="user-info">
                                            <strong><?= htmlspecialchars($user['name']) ?></strong>
                                            <small><?= htmlspecialchars($user['email']) ?></small>
                                        </div>
                                    </td>

                                    <td>
                                        <?php
                                        // Read status from your new database column
                                        $currentStatus = $user['status'] ?? 'active';
                                        ?>
                                        <?php if ($currentStatus === 'active'): ?>
                                            <span class="status status-verified">Active</span>
                                        <?php else: ?>
                                            <span class="status status-pending"
                                                style="background: #ffebee; color: #e74c3c;">Blocked</span>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= htmlspecialchars($user['phone_number'] ?? '-') ?></td>
                                    <td><small><?= htmlspecialchars($user['address'] ?? '-') ?></small></td>

                                    <td class="actions">
                                        <a href="index.php?page=admin&action=view_user&id=<?= $user['customer_id'] ?>"
                                            class="btn-icon" title="View Profile">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <?php if ($currentStatus === 'active'): ?>
                                            <a href="index.php?page=admin&action=toggle_user_status&id=<?= $user['customer_id'] ?>&status=blocked"
                                                class="btn-icon text-warning" title="Block User"
                                                onclick="return confirm('Are you sure you want to block this user?');">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="index.php?page=admin&action=toggle_user_status&id=<?= $user['customer_id'] ?>&status=active"
                                                class="btn-icon text-success" title="Unblock User"
                                                onclick="return confirm('Unblock this user?');">
                                                <i class="fas fa-check-circle"></i>
                                            </a>
                                        <?php endif; ?>

                                        <a href="index.php?page=admin&action=delete_user&id=<?= $user['customer_id'] ?>"
                                            class="btn-icon text-danger" title="Delete User"
                                            onclick="return confirm('This action is permanent. Delete?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align:center; padding: 50px;">
                                    <i class="fas fa-user-slash"
                                        style="font-size: 2rem; color: #ccc; margin-bottom: 10px;"></i>
                                    <p>No users found matching your search.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="panel">
            <div class="panel-header">
                <h2>User Registration Trends</h2>
            </div>
            <div style="height: 300px; position: relative;">
                <canvas id="userRegistrationChart"></canvas>
            </div>
        </section>

        <footer class="admin-footer">
            &copy; <?= date('Y') ?> RecoltePure Admin System
        </footer>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('userRegistrationChart').getContext('2d');

        // Dynamic data from Controller
        const rawData = <?= json_encode($registrationStats ?? [
            ['month' => 'Jan', 'count' => 5],
            ['month' => 'Feb', 'count' => 12],
            ['month' => 'Mar', 'count' => 8],
            ['month' => 'Apr', 'count' => 15],
            ['month' => 'May', 'count' => 20],
            ['month' => 'Jun', 'count' => 18]
        ]) ?>;

        const labels = rawData.map(item => item.month);
        const dataPoints = rawData.map(item => item.count);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'New Registrations',
                    data: dataPoints,
                    borderColor: '#FF2A00',
                    backgroundColor: 'rgba(255, 42, 0, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#FF2A00'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>

</html>