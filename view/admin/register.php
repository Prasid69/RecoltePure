modified file view/admin/register.php
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Registration | RecoltePure</title>
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
  <div class="admin-auth">
    <div class="card">
      <h1>Register Admin</h1>
      <?php if (!empty($error)) : ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if (!empty($success)) : ?>
        <div class="notice" style="margin-bottom:12px; padding:10px; background:#e7f3ff; border:1px solid #cbe1ff; color:#0b5ed7; border-radius:8px;">
          <?= htmlspecialchars($success) ?>
        </div>
      <?php endif; ?>
      <form method="POST" action="index.php?page=admin&action=register">
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <label>Confirm Password</label>
        <input type="password" name="confirm" required>
        <button type="submit" class="btn">Register</button>
        <div style="margin-top:10px; font-size:13px;">
          Already have an account? <a href="index.php?page=admin&action=login">Login as Admin</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
