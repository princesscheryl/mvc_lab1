<?php
// Using the core functions, check if the user is logged in
require_once '../settings/core.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: ../login/login.php");
    exit();
}

// Also check if the user is an admin (unless your design allows sellers to add products)
if (!isAdmin()) {
    header("Location: ../login/login.php");
    exit();
}

// Include controllers for database operations
require_once '../controllers/product_controller.php';
require_once '../controllers/category_controller.php';
require_once '../controllers/brand_controller.php';

// RETRIEVE - Display products in the system
$products = get_all_products_ctr();
$categories = get_all_categories_ctr();
$brands = get_all_brands_ctr();

// Check if editing a product
$editing = false;
$edit_product = null;
if (isset($_GET['edit']) && intval($_GET['edit']) > 0) {
    $editing = true;
    $edit_product = get_product_by_id_ctr(intval($_GET['edit']));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $editing ? 'Edit' : 'Add'; ?> Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .container {
            max-width: 1400px;
        }
        h1 {
            color: white;
            margin-bottom: 10px;
        }
        .welcome-text {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        .card-header h3 {
            margin: 0;
            font-size: 1.3rem;
        }
        .product-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            background: white;
            transition: all 0.3s;
        }
        .product-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .product-image-placeholder {
            width: 100%;
            height: 200px;
            background: #f0f0f0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
        }
        .navigation-buttons {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1><i class="fa fa-box"></i> Product Management</h1>
        <p class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>

        <!-- CREATE / UPDATE - Form for adding or editing product -->
        <div class="card mb-4">
            <div class="card-header">
                <h3><i class="fa fa-<?php echo $editing ? 'edit' : 'plus'; ?>"></i> <?php echo $editing ? 'Edit' : 'Add New'; ?> Product</h3>
            </div>
            <div class="card-body">
                <form id="productForm">
                    <input type="hidden" id="productId" name="product_id" value="<?php echo $editing ? $edit_product['product_id'] : ''; ?>">
                    <input type="hidden" id="productImagePath" name="product_image" value="<?php echo $editing ? $edit_product['product_image'] : ''; ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productCategory" class="form-label">Product Category *</label>
                                <select class="form-select" id="productCategory" name="cat_id" required>
                                    <option value="">Select a category</option>
                                    <?php if ($categories): ?>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['cat_id']; ?>"
                                                <?php echo ($editing && $edit_product['product_cat'] == $category['cat_id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($category['cat_name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="productBrand" class="form-label">Product Brand *</label>
                                <select class="form-select" id="productBrand" name="brand_id" required>
                                    <option value="">Select a brand</option>
                                    <?php if ($brands): ?>
                                        <?php foreach ($brands as $brand): ?>
                                            <option value="<?php echo $brand['brand_id']; ?>"
                                                <?php echo ($editing && $edit_product['product_brand'] == $brand['brand_id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($brand['brand_name']); ?> (<?php echo htmlspecialchars($brand['cat_name']); ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="productTitle" class="form-label">Product Title *</label>
                                <input type="text" class="form-control" id="productTitle" name="product_title"
                                    value="<?php echo $editing ? htmlspecialchars($edit_product['product_title']) : ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Product Price *</label>
                                <input type="number" class="form-control" id="productPrice" name="product_price"
                                    step="0.01" min="0.01" value="<?php echo $editing ? $edit_product['product_price'] : ''; ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Product Description</label>
                                <textarea class="form-control" id="productDescription" name="product_desc"
                                    rows="4"><?php echo $editing ? htmlspecialchars($edit_product['product_desc']) : ''; ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="productKeywords" class="form-label">Product Keywords</label>
                                <input type="text" class="form-control" id="productKeywords" name="product_keywords"
                                    value="<?php echo $editing ? htmlspecialchars($edit_product['product_keywords']) : ''; ?>"
                                    placeholder="e.g., african, food, jollof">
                                <div class="form-text">Separate keywords with commas</div>
                            </div>

                            <div class="mb-3">
                                <label for="productImage" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="productImage" accept="image/*">
                                <div class="form-text">JPG, JPEG, PNG, or GIF (max 5MB)</div>
                                <div id="imagePreview">
                                    <?php if ($editing && !empty($edit_product['product_image'])): ?>
                                        <img src="../<?php echo htmlspecialchars($edit_product['product_image']); ?>"
                                            class="image-preview" alt="Current product image">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> <?php echo $editing ? 'Update' : 'Add'; ?> Product
                        </button>
                        <?php if ($editing): ?>
                            <a href="product.php" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Cancel Edit
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- RETRIEVE - Display products in the system -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fa fa-list"></i> Products</h3>
            </div>
            <div class="card-body">
                <div id="productsContainer">
                    <?php if (empty($products)): ?>
                        <p>No products found. Add your first product above.</p>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($products as $product): ?>
                                <div class="col-md-4">
                                    <div class="product-card">
                                        <?php if (!empty($product['product_image'])): ?>
                                            <img src="../<?php echo htmlspecialchars($product['product_image']); ?>"
                                                class="product-image" alt="<?php echo htmlspecialchars($product['product_title']); ?>">
                                        <?php else: ?>
                                            <div class="product-image-placeholder">
                                                <i class="fa fa-image fa-3x"></i>
                                            </div>
                                        <?php endif; ?>

                                        <h5 class="mt-3"><?php echo htmlspecialchars($product['product_title']); ?></h5>
                                        <p class="text-muted mb-1">
                                            <i class="fa fa-tag"></i> <?php echo htmlspecialchars($product['cat_name']); ?> |
                                            <i class="fa fa-bookmark"></i> <?php echo htmlspecialchars($product['brand_name']); ?>
                                        </p>
                                        <p class="text-muted mb-2">
                                            <small><?php echo htmlspecialchars(substr($product['product_desc'], 0, 100)); ?><?php echo strlen($product['product_desc']) > 100 ? '...' : ''; ?></small>
                                        </p>
                                        <h6 class="text-primary">$<?php echo number_format($product['product_price'], 2); ?></h6>

                                        <div class="d-flex gap-2 mt-3">
                                            <a href="product.php?edit=<?php echo $product['product_id']; ?>" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteProduct(<?php echo $product['product_id']; ?>, '<?php echo htmlspecialchars($product['product_title'], ENT_QUOTES); ?>')">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="navigation-buttons">
            <a href="../index.php" class="btn btn-secondary"><i class="fa fa-home"></i> Back to Home</a>
            <a href="category.php" class="btn btn-info"><i class="fa fa-tags"></i> Categories</a>
            <a href="brand.php" class="btn btn-info"><i class="fa fa-bookmark"></i> Brands</a>
            <a href="../login/logout.php" class="btn btn-outline-danger"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Alert Messages Container -->
    <div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1060;"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/product.js"></script>
</body>
</html>
