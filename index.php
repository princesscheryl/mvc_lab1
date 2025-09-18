<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Home - Taste of Africa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
</head>
<body>
    <div class="menu-tray">
        <?php if(isset($_SESSION['user_id'])): ?>
            <span class="user-greeting">
                <i class="fa fa-user-circle"></i>
                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
            </span>
            <a href="login/logout.php" class="btn-menu btn-menu-logout">
                <i class="fa fa-sign-out-alt"></i> Logout
            </a>
        <?php else: ?>
            <span class="user-greeting">Menu</span>
            <a href="login/register.php" class="btn-menu btn-menu-primary">Register</a>
            <a href="login/login.php" class="btn-menu btn-menu-secondary">Login</a>
        <?php endif; ?>
    </div>

    <div class="container welcome-container">
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="user-dashboard">
                <div class="user-card">
                    <div class="user-card-header">
                        <h2><i class="fa fa-user-circle"></i> Welcome Back</h2>
                        <h3><?php echo htmlspecialchars($_SESSION['user_name']); ?></h3>
                    </div>
                    <div class="user-card-body">
                        <div class="user-info-item">
                            <i class="fa fa-envelope"></i>
                            <div>
                                <strong>Email:</strong>
                                <span><?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                            </div>
                        </div>
                        <div class="user-info-item">
                            <i class="fa fa-phone"></i>
                            <div>
                                <strong>Contact:</strong>
                                <span><?php echo htmlspecialchars($_SESSION['user_contact']); ?></span>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="role-badge">
                                <i class="fa fa-id-badge"></i>
                                <?php echo $_SESSION['user_role']==1?'Restaurant Owner':'Customer'; ?>
                            </div>
                        </div>
                        <div class="location-info">
                            <i class="fa fa-map-marker-alt"></i>
                            <?php echo htmlspecialchars($_SESSION['user_city'].', '.$_SESSION['user_country']); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="guest-welcome">
                <h1>Taste of Africa</h1>
                <p class="tagline">Authentic African Cuisine Delivered</p>
                <p class="sub-text">Join our platform to explore the finest selection of African dishes</p>
                <div class="action-buttons">
                    <a href="login/register.php" class="btn-hero btn-hero-primary">
                        <i class="fa fa-user-plus"></i> Register Now
                    </a>
                    <a href="login/login.php" class="btn-hero btn-hero-secondary">
                        <i class="fa fa-sign-in-alt"></i> Login
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>