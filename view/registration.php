<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

  <div class="container">
    <h2>Registration Form</h2>
    <form action="">
      <label for="fullname">Full Name:</label>
      <input type="text" id="fullname" name="fullname" required><br><br>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required><br><br>

      <label for="address">Address:</label>
      <textarea type="textarea" id="address" name="address" required></textarea><br><br>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required><br><br>

      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" required><br><br>

      <button type="submit">Register</button><br><br>
    </form>

    <div class="login-link">
      Already have an account? <a href="login.html">Login</a>
    </div>
  </div>

</body>
</html>
