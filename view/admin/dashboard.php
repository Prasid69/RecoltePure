
<?php
$current_action = $_GET['action'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | RecoltePure</title>
  <<base href="/RecoltePure/">

<link rel="stylesheet" href="/RecoltePure/assets/css/admin_dashboard.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  
  
</head>
<body>
  <header class="admin-header">
    <div class="brand"><img src="assets/uploads/products/Logo.png" alt="Logo"> RecoltePure Admin</div>
    <nav>
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
</nav>    
            
            <a  href="/RecoltePure/admin/logout" class="logout">
                <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
            </a>
        </nav>
  </header>

  <main class="admin-main">

   <div class="top-action-bar">
            <h2>Users Management</h2>

            

            
                

            <?php
            $adminEmail = $_SESSION['login_user'] ?? 'Admin';
            $initial = strtoupper(substr($adminEmail, 0, 1));
            ?>
            
            
            <div class="admin-user-wrapper">
                <button class="admin-initial-btn"><?php echo $initial; ?></button>
                <div class="admin-dropdown">
                    <a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a>
                    <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
                    <hr>
                    <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
    </div>
    
    <section class="stats">
      <div class="stat"><div class="num"><?= (int)$stats['users'] ?></div><div class="label">Users</div></div>
      <div class="stat"><div class="num"><?= (int)$stats['farmers'] ?></div><div class="label">Farmers</div></div>
      <div class="stat"><div class="num"><?= (int)$stats['products'] ?></div><div class="label">Products</div></div>
      <div class="stat"><div class="num"><?= (int)$stats['orders'] ?></div><div class="label">Orders</div></div>
    </section>
    <br><br>
    <section class="panels" style="display: block;"> 

    <div class="charts-section">

  <div class="panel chart-panel">
        <h2>Orders per Farmer</h2>
        

        <canvas id="chartOrdersPerFarmer" 
                data-labels='<?= json_encode(array_column($allFarmers, "name")) ?>'
                data-values='<?= json_encode(array_column($allFarmers, "orders_completed")) ?>'>
        </canvas>
    </div>

  <div class="panel chart-panel pie-chart">
    <h2>Products by Category</h2>
    <canvas id="categoryPieChart" 
                data-labels='<?= json_encode(array_column($categoryStats, "category_name")) ?>'
                data-values='<?= json_encode(array_column($categoryStats, "total_products")) ?>'>
            </canvas>
  </div>

    </div>


    
      
      

      


      
      
    </section>
  </main>

  <!-- <footer class="admin-footer">&copy; <?= date('Y') ?> RecoltePure</footer> -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  // Orders per Farmer
  const ordersCanvas = document.getElementById('chartOrdersPerFarmer');
  if (ordersCanvas) {
    new Chart(ordersCanvas, {
      type: 'bar',
      data: {
        labels: JSON.parse(ordersCanvas.dataset.labels),
        datasets: [{
          data: JSON.parse(ordersCanvas.dataset.values),
          backgroundColor: '#FF2A00',
          borderRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
      }
    });
  }

  // Products by Category
  const pieCanvas = document.getElementById('categoryPieChart');
  if (pieCanvas) {
    new Chart(pieCanvas, {
      type: 'pie',
      data: {
        labels: JSON.parse(pieCanvas.dataset.labels),
        datasets: [{
          data: JSON.parse(pieCanvas.dataset.values),
          backgroundColor: [
            '#FF2A00','#4CAF50','#FFC107','#2196F3','#9C27B0'
          ]
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom' } }
      }
    });
  }
});
</script>




</body>
</html>