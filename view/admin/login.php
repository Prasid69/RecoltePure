<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | RecoltePure</title>
  <link rel="stylesheet" href="/RecoltePure/assets/css/admin_login.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="admin-auth">
    <div class="card">
      <div class="logo-top">
        <img src="../assets/uploads/products/Logo.png" alt="RecoltePure">
        <strong>RecoltePure Admin</strong>
      </div>
      <h1>Admin Login</h1>
      <?php if (!empty($error)) : ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <form method="POST" action="/RecoltePure/admin/login">
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit" class="btn">Login</button>
        <div style="margin-top:10px; font-size:13px; text-align:center;">
          <a href="index.php?page=admin&action=register">Register an Admin</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
