<?php
session_start();
require_once(__DIR__ . '/../controllers/cart_controller.php');

// Get customer ID and IP address
$customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$ip_address = $_SERVER['REMOTE_ADDR'];

// Get cart items
$cart_items = get_user_cart_ctr($customer_id, $ip_address);

// Calculate totals
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['subtotal'];
}
$tax = $subtotal * 0.0; // No tax for now, you can adjust this
$total = $subtotal + $tax;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Taste of Africa</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-store"></i> Taste of Africa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="all_product.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="cart.php">
                            <i class="fas fa-shopping-cart"></i> Cart
                            <span class="badge bg-danger cart-count"><?php echo count($cart_items); ?></span>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../login/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../login/login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <h1 class="mb-4">
            <i class="fas fa-shopping-cart"></i> Shopping Cart
        </h1>

        <?php if (empty($cart_items)): ?>
            <!-- Empty Cart Message -->
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
                <h3>Your cart is empty</h3>
                <p class="text-muted">Start shopping to add items to your cart!</p>
                <a href="all_product.php" class="btn btn-primary mt-3">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
            </div>
        <?php else: ?>
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Cart Items (<?php echo count($cart_items); ?>)</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($cart_items as $item): ?>
                                <div class="row border-bottom py-3 align-items-center">
                                    <!-- Product Image -->
                                    <div class="col-md-2">
                                        <img src="../images/<?php echo htmlspecialchars($item['product_image']); ?>"
                                             alt="<?php echo htmlspecialchars($item['product_title']); ?>"
                                             class="img-fluid rounded">
                                    </div>

                                    <!-- Product Details -->
                                    <div class="col-md-4">
                                        <h6><?php echo htmlspecialchars($item['product_title']); ?></h6>
                                        <p class="text-muted mb-0">
                                            <small>
                                                <?php if ($item['cat_name']): ?>
                                                    Category: <?php echo htmlspecialchars($item['cat_name']); ?>
                                                <?php endif; ?>
                                            </small>
                                        </p>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-2 text-center">
                                        <p class="mb-0"><strong>GHS <?php echo number_format($item['product_price'], 2); ?></strong></p>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-md-2 text-center">
                                        <input type="number"
                                               class="form-control quantity-input"
                                               value="<?php echo $item['qty']; ?>"
                                               min="1"
                                               max="100"
                                               data-product-id="<?php echo $item['p_id']; ?>">
                                    </div>

                                    <!-- Subtotal & Remove -->
                                    <div class="col-md-2 text-center">
                                        <p class="mb-2"><strong>GHS <?php echo number_format($item['subtotal'], 2); ?></strong></p>
                                        <button class="btn btn-sm btn-danger remove-item-btn"
                                                data-product-id="<?php echo $item['p_id']; ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="all_product.php" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Continue Shopping
                        </a>
                        <button class="btn btn-outline-danger" id="empty-cart-btn">
                            <i class="fas fa-trash-alt"></i> Empty Cart
                        </button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <strong>GHS <?php echo number_format($subtotal, 2); ?></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax:</span>
                                <strong>GHS <?php echo number_format($tax, 2); ?></strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <h5>Total:</h5>
                                <h5 class="text-success">GHS <?php echo number_format($total, 2); ?></h5>
                            </div>

                            <?php if (isset($_SESSION['user_id'])): ?>
                                <a href="checkout.php" class="btn btn-success w-100">
                                    <i class="fas fa-lock"></i> Proceed to Checkout
                                </a>
                            <?php else: ?>
                                <div class="alert alert-warning">
                                    <small>Please <a href="../login/login.php">login</a> to checkout</small>
                                </div>
                                <a href="../login/login.php" class="btn btn-primary w-100">
                                    <i class="fas fa-sign-in-alt"></i> Login to Checkout
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="card mt-3">
                        <div class="card-body">
                            <h6 class="card-title">Why Shop With Us?</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i> Secure Payment
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i> Fast Delivery
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i> 24/7 Support
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success"></i> Quality Products
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Cart JS -->
    <script src="../js/cart.js"></script>
</body>
</html>
