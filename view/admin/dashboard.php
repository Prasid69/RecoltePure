<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | RecoltePure</title>
  <link rel="stylesheet" href="assets/css/admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script defer src="assets/js/admin.js"></script>
</head>
<body>
  <header class="admin-header">
    <div class="brand"><img src="assets/uploads/products/Logo.png" alt="Logo"> RecoltePure Admin</div>
    <nav>
      <a href="index.php?page=admin&action=dashboard">Dashboard</a>
      <a href="#" id="toggleTheme">Toggle Theme</a>
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

    <section class="panels">
      <div class="panel">
        <h2>Users</h2>
        <iframe src="index.php?page=categories" class="embed"></iframe>
      </div>
      <div class="panel">
        <h2>Products</h2>
        <iframe src="index.php?page=upload_product" class="embed"></iframe>
      </div>
    </section>
  </main>

  <footer class="admin-footer">&copy; <?= date('Y') ?> RecoltePure</footer>
</body>
</html>