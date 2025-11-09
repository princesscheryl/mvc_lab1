<?php
session_start();
require_once(__DIR__ . '/../settings/core.php');
require_once(__DIR__ . '/../controllers/cart_controller.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$customer_id = $_SESSION['user_id'];
$ip_address = $_SERVER['REMOTE_ADDR'];

// Get cart items
$cart_items = get_user_cart_ctr($customer_id, $ip_address);

// Redirect to cart if empty
if (empty($cart_items)) {
    header("Location: cart.php");
    exit();
}

// Calculate totals
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['subtotal'];
}
$tax = $subtotal * 0.0; // Adjust tax rate as needed
$total = $subtotal + $tax;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Taste of Africa</title>

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
                        <a class="nav-link" href="cart.php">
                            <i class="fas fa-shopping-cart"></i> Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container my-5">
        <!-- Progress Steps -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <div class="text-center mx-3">
                        <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        <p class="mt-2 text-success"><strong>Cart</strong></p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>
                    <div class="text-center mx-3">
                        <i class="fas fa-credit-card fa-2x text-primary"></i>
                        <p class="mt-2 text-primary"><strong>Checkout</strong></p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>
                    <div class="text-center mx-3">
                        <i class="fas fa-check-circle fa-2x text-muted"></i>
                        <p class="mt-2 text-muted">Complete</p>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="mb-4">
            <i class="fas fa-credit-card"></i> Checkout
        </h1>

        <div class="row">
            <!-- Order Summary -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart_items as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="../images/<?php echo htmlspecialchars($item['product_image']); ?>"
                                                         alt="<?php echo htmlspecialchars($item['product_title']); ?>"
                                                         class="img-thumbnail me-2"
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div>
                                                        <strong><?php echo htmlspecialchars($item['product_title']); ?></strong>
                                                        <?php if ($item['cat_name']): ?>
                                                            <br><small class="text-muted"><?php echo htmlspecialchars($item['cat_name']); ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>GHS <?php echo number_format($item['product_price'], 2); ?></td>
                                            <td><?php echo $item['qty']; ?></td>
                                            <td class="text-end"><strong>GHS <?php echo number_format($item['subtotal'], 2); ?></strong></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Customer Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Country:</strong> <?php echo htmlspecialchars($_SESSION['user_country']); ?></p>
                                <p><strong>City:</strong> <?php echo htmlspecialchars($_SESSION['user_city']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Section -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Payment Details</h5>
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

                        <button class="btn btn-success w-100 mb-3" id="proceed-to-checkout-btn">
                            <i class="fas fa-lock"></i> Simulate Payment
                        </button>

                        <div class="alert alert-info">
                            <small>
                                <i class="fas fa-info-circle"></i>
                                This is a simulated payment for demonstration purposes only.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Security Info -->
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Secure Checkout</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-lock text-success"></i> SSL Encrypted
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-shield-alt text-success"></i> Buyer Protection
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-undo text-success"></i> Easy Returns
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Cart Button -->
        <div class="row mt-3">
            <div class="col-12">
                <a href="cart.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Cart
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Checkout JS -->
    <script src="../js/checkout.js"></script>
</body>
</html>
