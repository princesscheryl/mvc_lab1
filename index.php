<?php
session_start();
require_once 'settings/core.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Home - E-Commerce Platform</title>
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
            <?php if($_SESSION['user_role']==1): ?>
                <!-- If logged in and an admin, Logout | Category | Brand | Add Product -->
                <a href="admin/category.php" class="btn-menu btn-menu-primary">
                    <i class="fa fa-tags"></i> Category
                </a>
                <a href="admin/brand.php" class="btn-menu btn-menu-primary">
                    <i class="fa fa-bookmark"></i> Brand
                </a>
                <a href="admin/product.php" class="btn-menu btn-menu-primary">
                    <i class="fa fa-plus-circle"></i> Add Product
                </a>
                <a href="login/logout.php" class="btn-menu btn-menu-logout">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a>
            <?php else: ?>
                <!-- If logged in and not an admin, Logout -->
                <a href="login/logout.php" class="btn-menu btn-menu-logout">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a>
            <?php endif; ?>
        <?php else: ?>
            <!-- If not logged in, Register | Login -->
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
                <h1>Your Platform</h1>
                <p class="tagline">Modern E-Commerce Solution</p>
                <p class="sub-text">Join our platform to explore amazing products and services</p>
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