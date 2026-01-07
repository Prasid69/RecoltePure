<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | RecoltePure</title>
  <style>
    body { font-family: Inter, Arial, sans-serif; background:#f5f6f8; margin: 0; padding: 0; }
    .wrapper { max-width: 420px; margin: 60px auto; background:#fff; padding:24px; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.08); }
    h1 { text-align: center; color: #333; margin-bottom: 20px; font-size: 24px; }
    .btn { width:100%; padding:10px 14px; border:none; border-radius:8px; background:#2d7a2d; color:#fff; cursor:pointer; font-weight: 600; font-size: 16px; margin-top: 10px; }
    .btn:hover { background: #246124; }
    .input-box { display:flex; flex-direction:column; gap:8px; padding:10px 0; }
    .input-box label { font-size: 14px; color: #555; font-weight: 500; }
    .input-box input { padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; }
    .input-box input:focus { outline: none; border-color: #2d7a2d; }
    
    .notice { margin-top:12px; padding:10px; background:#e7f3ff; border:1px solid #cbe1ff; color:#0b5ed7; border-radius:8px; text-align: center; }
    .error { margin-top:12px; padding:10px; background:#fde2e4; border:1px solid #fac5ca; color:#b02a37; border-radius:8px; text-align: center; }
  </style>
</head>
<body>
  <div class="wrapper">
    <h1>Reset Password</h1>
    
    <?php if (!empty($error)) : ?>
      <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($valid) : ?>
      <form method="POST" action="index.php?page=reset_password&email=<?php echo urlencode($email); ?>&token=<?php echo urlencode($token); ?>">
        <div class="input-box">
          <label>New Password</label>
          <input type="password" name="new_password" required>
        </div>
        <div class="input-box">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn">Update Password</button>
      </form>
    <?php endif; ?>

    <?php if (!empty($success)) : ?>
      <div class="notice"><?php echo htmlspecialchars($success); ?></div>
      <script>
        setTimeout(function(){ 
            window.location.href = "index.php?page=login"; 
        }, 2000);
      </script>
    <?php endif; ?>
  </div>
</body>
</html>
