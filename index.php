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
            <div class="hero-container-logged">
                <div class="hero-content-logged">
                    <h1 class="hero-title-logged">
                        Welcome back, <span class="highlight"><?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span> 👋
                    </h1>
                    <p class="hero-subtitle">
                        <?php echo $_SESSION['user_role']==1 ? 'Manage your products and grow your business' : 'Discover amazing products from top brands'; ?>
                    </p>

                    <?php if($_SESSION['user_role']==1): ?>
                    <!-- Admin Quick Actions -->
                    <div class="admin-actions-hero">
                        <a href="admin/category.php" class="hero-action-btn">
                            <i class="fa fa-tags"></i>
                            <span>Categories</span>
                        </a>
                        <a href="admin/brand.php" class="hero-action-btn">
                            <i class="fa fa-bookmark"></i>
                            <span>Brands</span>
                        </a>
                        <a href="admin/product.php" class="hero-action-btn">
                            <i class="fa fa-box"></i>
                            <span>Products</span>
                        </a>
                    </div>
                    <?php else: ?>
                    <!-- Customer Search -->
                    <div class="hero-search">
                        <input type="text" placeholder="Search for products..." class="search-input">
                        <button class="search-btn">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <?php endif; ?>

                    <!-- User Info Grid -->
                    <div class="user-info-grid">
                        <div class="user-info-item-compact">
                            <i class="fa fa-envelope"></i>
                            <span><?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
                        </div>
                        <div class="user-info-item-compact">
                            <i class="fa fa-phone"></i>
                            <span><?php echo htmlspecialchars($_SESSION['user_contact']); ?></span>
                        </div>
                        <div class="user-info-item-compact">
                            <i class="fa fa-map-marker-alt"></i>
                            <span><?php echo htmlspecialchars($_SESSION['user_city'].', '.$_SESSION['user_country']); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Pinterest-style Image Carousel for logged-in users too -->
                <div class="pinterest-carousel">
                    <div class="carousel-column carousel-column-1">
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=500&fit=crop" alt="Headphones">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=600&fit=crop" alt="Watch">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=400&fit=crop" alt="Sunglasses">
                        </div>
                    </div>
                    <div class="carousel-column carousel-column-2">
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=400&h=550&fit=crop" alt="Shoes">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=400&h=450&fit=crop" alt="Sneakers">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=400&h=500&fit=crop" alt="Perfume">
                        </div>
                    </div>
                    <div class="carousel-column carousel-column-3">
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=600&fit=crop" alt="Red Shoes">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=400&h=400&fit=crop" alt="Backpack">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1611312449408-fcece27cdbb7?w=400&h=550&fit=crop" alt="Camera">
                        </div>
                    </div>
                    <div class="carousel-column carousel-column-4">
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=400&h=500&fit=crop" alt="Smart Watch">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1598532163257-ae3c6b2524b6?w=400&h=600&fit=crop" alt="Glasses">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1525904097878-94fb15835963?w=400&h=450&fit=crop" alt="Coffee">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Products Section (for logged-in users) -->
        <section class="featured-section">
            <div class="features-container">
                <h2 class="section-title"><?php echo $_SESSION['user_role']==1 ? 'Platform Features' : 'Why Shop With Us?'; ?></h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fa fa-shield-alt"></i>
                        </div>
                        <h3>Secure Platform</h3>
                        <p>Your data and transactions are protected with industry-leading security</p>
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
    <?php else: ?>
        <!-- Hero Section for guests -->
        <section class="hero-section">
            <div class="hero-container">
                <div class="hero-content">
                    <h1 class="hero-title">
                        Get your next <span class="highlight carousel-text" id="carouselText">amazing product</span>
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

                <!-- Pinterest-style Image Carousel -->
                <div class="pinterest-carousel">
                    <div class="carousel-column carousel-column-1">
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=500&fit=crop" alt="Headphones">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=600&fit=crop" alt="Watch">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=400&fit=crop" alt="Sunglasses">
                        </div>
                    </div>
                    <div class="carousel-column carousel-column-2">
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=400&h=550&fit=crop" alt="Shoes">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=400&h=450&fit=crop" alt="Sneakers">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=400&h=500&fit=crop" alt="Perfume">
                        </div>
                    </div>
                    <div class="carousel-column carousel-column-3">
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=600&fit=crop" alt="Red Shoes">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=400&h=400&fit=crop" alt="Backpack">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1611312449408-fcece27cdbb7?w=400&h=550&fit=crop" alt="Camera">
                        </div>
                    </div>
                    <div class="carousel-column carousel-column-4">
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=400&h=500&fit=crop" alt="Smart Watch">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1598532163257-ae3c6b2524b6?w=400&h=600&fit=crop" alt="Glasses">
                        </div>
                        <div class="carousel-image">
                            <img src="https://images.unsplash.com/photo-1525904097878-94fb15835963?w=400&h=450&fit=crop" alt="Coffee">
                        </div>
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
    <script>
        // Text carousel that changes every few seconds
        const carouselTexts = [
            { text: 'amazing product', color: '#1dbf73' },
            { text: 'fashion inspiration', color: '#ff6b6b' },
            { text: 'tech gadget', color: '#3b82f6' },
            { text: 'home décor idea', color: '#8b5cf6' },
            { text: 'lifestyle upgrade', color: '#f59e0b' }
        ];

        let currentIndex = 0;
        const carouselTextElement = document.getElementById('carouselText');

        if (carouselTextElement) {
            function changeCarouselText() {
                // Fade out
                carouselTextElement.style.opacity = '0';

                setTimeout(() => {
                    currentIndex = (currentIndex + 1) % carouselTexts.length;
                    carouselTextElement.textContent = carouselTexts[currentIndex].text;
                    carouselTextElement.style.color = carouselTexts[currentIndex].color;

                    // Fade in
                    carouselTextElement.style.opacity = '1';
                }, 300);
            }

            // Change text every 3 seconds
            setInterval(changeCarouselText, 3000);
        }
    </script>
</body>
</html>