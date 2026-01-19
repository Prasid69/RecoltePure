<?php include 'view/layout/header.php'; ?>

<style>
    .profile-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        font-family: 'Poppins', sans-serif;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .profile-header h1 {
        color: #2c3e50;
    }

    .profile-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
    }

    .profile-sidebar {
        flex: 1;
        text-align: center;
        border-right: 1px solid #eee;
        padding-right: 20px;
        min-width: 200px;
    }

    .avatar-circle {
        width: 100px;
        height: 100px;
        background-color: #4CAF50;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        font-weight: bold;
        margin: 0 auto 15px auto;
    }

    .profile-details {
        flex: 2;
        min-width: 300px;
    }

    .info-group {
        margin-bottom: 20px;
        border-bottom: 1px solid #f9f9f9;
        padding-bottom: 10px;
    }

    .info-label {
        font-weight: 600;
        color: #777;
        font-size: 0.9rem;
        margin-bottom: 5px;
        display: block;
    }

    .info-value {
        color: #333;
        font-size: 1.1rem;
    }

    .edit-btn {
        display: inline-block;
        margin-top: 20px;
        background-color: #333;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        transition: 0.3s;
    }

    .edit-btn:hover {
        background-color: #4CAF50;
        color: black;
    }
</style>

<div class="profile-container">

    <div class="profile-header">
        <h1>My Profile</h1>

        <div class="edit-section" style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
            <a href="index.php?page=edit_profile" class="edit-btn">Edit Profile</a>
        </div>
    </div>



    <div class="profile-card">
        <div class="profile-sidebar">
            <div class="avatar-circle">
                <?php
                echo isset($user['first_name']) ? strtoupper(substr($user['first_name'], 0, 1)) : 'U';
                ?>
            </div>
            <h3>
                <?php echo htmlspecialchars($user['first_name'] ?? '') . ' ' . htmlspecialchars($user['last_name'] ?? ''); ?>
            </h3>
            <p style="color: #777;">
                <?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Member'; ?>
            </p>
        </div>


        <div class="profile-details">
            <h3 style="margin-bottom: 20px; color: #4CAF50;">Personal Information</h3>

            <div class="info-group">
                <span class="info-label">Full Name</span>
                <span class="info-value">
                    <?php echo htmlspecialchars($user['first_name'] ?? '-'); ?>
                </span>
            </div>

            <div class="info-group">
                <span class="info-label">Email Address</span>
                <span class="info-value">
                    <?php echo htmlspecialchars($user['email'] ?? '-'); ?>
                </span>
            </div>

            <div class="info-group">
                <span class="info-label">Phone Number</span>
                <span class="info-value">
                    <?php echo htmlspecialchars($user['phone_number'] ?? 'Not provided'); ?>
                </span>
            </div>

            <div class="info-group">
                <span class="info-label">Address</span>
                <span class="info-value">
                    <?php echo htmlspecialchars($user['address'] ?? 'Not provided'); ?>
                </span>
            </div>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'farmer'): ?>

                <div class="info-group">
                    <span class="info-label">Certificate Number</span>
                    <span class="info-value">
                        <?php
                        echo htmlspecialchars($user['certificate_number'] ?? 'Not provided');
                        ?>
                    </span>
                </div>

                <div class="info-group">
                    <span class="info-label">Farmer ID</span>
                    <span class="info-value">
                        <?php
                        echo htmlspecialchars($user['farmer_id'] ?? 'N/A');
                        ?>
                    </span>
                </div>

            <?php endif; ?>
        </div>
    </div>
    <?php include 'view/layout/footer.php'; ?>