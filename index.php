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
    <!-- Navigation Header -->
    <nav class="main-nav">
        <div class="nav-container">
            <div class="nav-left">
                <a href="index.php" class="logo">shopify<span class="logo-dot">.</span></a>
            </div>
            <div class="nav-right">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span class="nav-user">
                        <i class="fa fa-user-circle"></i>
                        <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </span>
                    <?php if($_SESSION['user_role']==1): ?>
                        <a href="admin/category.php" class="nav-link">Category</a>
                        <a href="admin/brand.php" class="nav-link">Brand</a>
                        <a href="admin/product.php" class="nav-link">Products</a>
                    <?php endif; ?>
                    <a href="login/logout.php" class="btn-nav btn-nav-logout">Logout</a>
                <?php else: ?>
                    <a href="login/login.php" class="nav-link">Sign in</a>
                    <a href="login/register.php" class="btn-nav btn-nav-join">Join</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php if(isset($_SESSION['user_id'])): ?>
        <!-- Logged in user dashboard -->
        <section class="hero-section hero-dashboard">
            <div class="hero-container">
                <div class="dashboard-welcome">
                    <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</h1>
                    <p class="hero-subtitle">Ready to manage your platform</p>
                </div>

                <div class="dashboard-grid">
                    <div class="dashboard-card">
                        <div class="dashboard-card-icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <h4>Email</h4>
                            <p><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="dashboard-card-icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <h4>Contact</h4>
                            <p><?php echo htmlspecialchars($_SESSION['user_contact']); ?></p>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="dashboard-card-icon">
                            <i class="fa fa-id-badge"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <h4>Role</h4>
                            <p><?php echo $_SESSION['user_role']==1?'Restaurant Owner':'Customer'; ?></p>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="dashboard-card-icon">
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                        <div class="dashboard-card-content">
                            <h4>Location</h4>
                            <p><?php echo htmlspecialchars($_SESSION['user_city'].', '.$_SESSION['user_country']); ?></p>
                        </div>
                    </div>
                </div>

                <?php if($_SESSION['user_role']==1): ?>
                <div class="quick-actions">
                    <h3>Quick Actions</h3>
                    <div class="action-cards">
                        <a href="admin/category.php" class="action-card">
                            <i class="fa fa-tags"></i>
                            <span>Manage Categories</span>
                        </a>
                        <a href="admin/brand.php" class="action-card">
                            <i class="fa fa-bookmark"></i>
                            <span>Manage Brands</span>
                        </a>
                        <a href="admin/product.php" class="action-card">
                            <i class="fa fa-box"></i>
                            <span>Manage Products</span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
    <?php else: ?>
        <!-- Hero Section for guests -->
        <section class="hero-section">
            <div class="hero-container">
                <div class="hero-content">
                    <h1 class="hero-title">
                        Find the perfect <span class="highlight">products</span> for your business
                    </h1>
                    <p class="hero-subtitle">
                        Discover amazing products from top brands and categories
                    </p>
                    <div class="hero-search">
                        <input type="text" placeholder="Search for products, brands, or categories..." class="search-input">
                        <button class="search-btn">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <div class="hero-tags">
                        <span>Popular:</span>
                        <a href="#" class="tag">Electronics</a>
                        <a href="#" class="tag">Fashion</a>
                        <a href="#" class="tag">Home & Garden</a>
                        <a href="#" class="tag">Sports</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="features-container">
                <h2 class="section-title">Why choose our platform?</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-shield-alt"></i>
                        </div>
                        <h3>Secure Shopping</h3>
                        <p>Your purchases are protected with our money-back guarantee</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-truck"></i>
                        </div>
                        <h3>Fast Delivery</h3>
                        <p>Get your products delivered quickly and efficiently</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-star"></i>
                        </div>
                        <h3>Quality Products</h3>
                        <p>Only the best products from trusted brands</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-headset"></i>
                        </div>
                        <h3>24/7 Support</h3>
                        <p>Our team is here to help you anytime, anywhere</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="cta-container">
                <h2>Ready to get started?</h2>
                <p>Join thousands of satisfied customers today</p>
                <div class="cta-buttons">
                    <a href="login/register.php" class="btn-cta btn-cta-primary">
                        <i class="fa fa-user-plus"></i> Register Now
                    </a>
                    <a href="login/login.php" class="btn-cta btn-cta-secondary">
                        <i class="fa fa-sign-in-alt"></i> Sign In
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>