<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | RecoltePure</title>
  <link rel="stylesheet" href="assets/css/admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  
  <style>
    /* Table Styling */
    .user-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 0.9rem;
    }
    .user-table th, .user-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    .user-table th {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
    }
    .user-table tr:hover {
        background-color: #f1f1f1;
    }
    .panel {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .table-wrapper {
        overflow-x: auto;
    }
  </style>
</head>
<body>
  <header class="admin-header">
    <div class="brand"><img src="assets/uploads/products/Logo.png" alt="Logo"> RecoltePure Admin</div>
    <nav>
      <a href="index.php?page=admin&action=dashboard">Dashboard</a>
      <a class="logout" href="index.php?page=admin&action=logout">Logout</a>
    </nav>
  </header>

  <main class="admin-main">
    
    <section class="stats">
      <div class="stat"><div class="num"><?= (int)$stats['users'] ?></div><div class="label">Users</div></div>
      <div class="stat"><div class="num"><?= (int)$stats['farmers'] ?></div><div class="label">Farmers</div></div>
      <div class="stat"><div class="num"><?= (int)$stats['products'] ?></div><div class="label">Products</div></div>
      <div class="stat"><div class="num"><?= (int)$stats['orders'] ?></div><div class="label">Orders</div></div>
    </section>

    <section class="panels" style="display: block;"> 
      
      <div class="panel">
        <h2>Registered Users</h2>
        <div class="table-wrapper">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($allUsers)): ?>
                        <?php foreach ($allUsers as $user): ?>
                        <tr>
                            <td>#<?= isset($user['customer_id']) ? $user['customer_id'] : $user['user_id'] ?></td>
                            <td><?= htmlspecialchars($user['user_name'] ?? $user['name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($user['user_email'] ?? $user['email'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($user['user_phone_number'] ?? $user['phone_number'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($user['user_address'] ?? $user['address'] ?? 'N/A') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center;">No registered users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
      </div>


      <div class="panel">
        <h2>Registered Farmers</h2>
        <div class="table-wrapper">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th> <th>Action</th> </tr>
                </thead>
                <tbody>
                    <?php if (!empty($allFarmers)): ?>
                        <?php foreach ($allFarmers as $farm): ?>
                        <tr>
                            <td>#<?= $farm['farmer_id'] ?></td>
                            <td>
                                <?= htmlspecialchars($farm['name']) ?><br>
                                <small style="color:#888"><?= htmlspecialchars($farm['email']) ?></small>
                            </td>
                            
                            <td>
                                <?php if ($farm['account_status'] == 'Verified'): ?>
                                    <span style="color: green; font-weight: bold; background: #e8f5e9; padding: 2px 6px; border-radius: 4px;">Verified</span>
                                <?php else: ?>
                                    <span style="color: orange; font-weight: bold; background: #fff3e0; padding: 2px 6px; border-radius: 4px;">Pending</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($farm['account_status'] != 'Verified'): ?>
                                    <a href="index.php?page=admin&action=verify_farmer&id=<?= $farm['farmer_id'] ?>" 
                                       onclick="return confirm('Are you sure you want to verify this farmer?');"
                                       style="background: #4CAF50; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 0.8rem;">
                                       Verify Now
                                    </a>
                                <?php else: ?>
                                    <span style="color: #ccc;">No Action</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align:center;">No farmers found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
      </div>

      <div class="panel">
        <h2>Product Inventory by Category</h2>
        <div class="table-wrapper">
            <table class="user-table">
                <thead>
                    <tr>
                        <th style="width: 70%;">Category Name</th>
                        <th style="width: 30%; text-align: center;">Total Products</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categoryStats)): ?>
                        <?php foreach ($categoryStats as $cat): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($cat['category_name']) ?></strong>
                            </td>
                            <td style="text-align: center;">
                                <span style="background: #e3f2fd; color: #1976d2; padding: 4px 12px; border-radius: 12px; font-weight: bold;">
                                    <?= $cat['total_products'] ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="2" style="text-align:center;">No categories found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
      </div>


      
      
    </section>
  </main>

  <footer class="admin-footer">&copy; <?= date('Y') ?> RecoltePure</footer>
</body>
</html>
