<?php include 'view/layout/header.php'; ?>

<style>
    .edit-container { max-width: 600px; margin: 50px auto; padding: 20px; font-family: 'Poppins', sans-serif; }
    .edit-card { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
    .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
    .save-btn { background: #4CAF50; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-size: 16px; width: 100%; transition: 0.3s; }
    .save-btn:hover { background: #45a049; }
    .cancel-link { display: block; text-align: center; margin-top: 15px; color: #777; text-decoration: none; }
</style>

<div class="edit-container">
    <div class="edit-card">
        <h2 style="text-align: center; margin-bottom: 25px;">Edit Profile</h2>
        
        <form action="index.php?page=update_profile" method="POST">
    
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>Phone Number</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label>Address</label>
        <input type="text" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>" required>
    </div>

    <?php if (isset($role) && $role === 'farmer'): ?>
        <div class="form-group">
            <label>Certificate Number</label>
            <input type="text" name="certificate_number" value="<?= htmlspecialchars($user['certificate_number'] ?? '') ?>" required>
        </div>
    <?php endif; ?>

    <button type="submit" class="save-btn">Save Changes</button>
    <a href="index.php?page=profile" class="cancel-link">Cancel</a>
</form>
    </div>
</div>