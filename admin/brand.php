<?php
// Using the core functions, check if the user is logged in
require_once '../settings/core.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: ../login/login.php");
    exit();
}

// Also check if the user is an admin
if (!isAdmin()) {
    // If the user is not an admin, redirect to the login page
    header("Location: ../login/login.php");
    exit();
}

// Include controllers for database operations
require_once '../controllers/brand_controller.php';

// RETRIEVE - Display brands in the system
$brands = get_all_brands_ctr();

// Get brands grouped by category (for organized display)
$brands_grouped = get_brands_grouped_by_category_ctr();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .container {
            max-width: 1200px;
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
        .table {
            margin-bottom: 0;
        }
        .category-group {
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
        }
        .category-title {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
            font-size: 1.2rem;
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
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1><i class="fa fa-tag"></i> Brand Management</h1>
        <p class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>

        <!-- CREATE - A form that takes brand name -->
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3><i class="fa fa-plus"></i> Add New Brand</h3>
                    </div>
                    <div class="card-body">
                        <form id="addBrandForm">
                            <div class="mb-3">
                                <label for="brandName" class="form-label">Brand Name</label>
                                <input type="text" class="form-control" id="brandName" name="brand_name" required>
                                <div class="form-text">Enter a unique brand name (e.g., Nike, Adidas, Jollof Express).</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Brand</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- RETRIEVE - Display brands in the system -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fa fa-list"></i> All Brands</h3>
            </div>
            <div class="card-body">
                <div id="brandsContainer">
                    <?php if (empty($brands)): ?>
                        <p>No brands found. Add your first brand above.</p>
                    <?php else: ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Brand Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="brandTableBody">
                                <?php foreach ($brands as $brand): ?>
                                    <tr id="brand_<?php echo $brand['brand_id']; ?>">
                                        <td><?php echo htmlspecialchars($brand['brand_id']); ?></td>
                                        <td class="brand-name"><?php echo htmlspecialchars($brand['brand_name']); ?></td>
                                        <td>
                                            <!-- UPDATE - Only the name is editable, not the ID -->
                                            <button class="btn btn-sm btn-warning edit-btn"
                                                onclick="editBrand(<?php echo $brand['brand_id']; ?>, '<?php echo htmlspecialchars($brand['brand_name'], ENT_QUOTES); ?>')">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>
                                            <!-- DELETE - Delete a brand -->
                                            <button class="btn btn-sm btn-danger delete-btn"
                                                onclick="deleteBrand(<?php echo $brand['brand_id']; ?>, '<?php echo htmlspecialchars($brand['brand_name'], ENT_QUOTES); ?>')">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (!empty($brands_grouped)): ?>
        <!-- Display brands organized by categories (based on products) -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fa fa-list"></i> Brands by Category (Based on Products)</h3>
            </div>
            <div class="card-body">
                <?php
                // Group brands by category
                $brandsByCategory = [];
                foreach ($brands_grouped as $brand) {
                    if (!empty($brand['cat_name'])) {
                        $catName = $brand['cat_name'];
                        if (!isset($brandsByCategory[$catName])) {
                            $brandsByCategory[$catName] = [];
                        }
                        // Avoid duplicates
                        $exists = false;
                        foreach ($brandsByCategory[$catName] as $existing) {
                            if ($existing['brand_id'] == $brand['brand_id']) {
                                $exists = true;
                                break;
                            }
                        }
                        if (!$exists) {
                            $brandsByCategory[$catName][] = $brand;
                        }
                    }
                }
                ?>

                <?php if (empty($brandsByCategory)): ?>
                    <p class="text-muted">No brands are currently linked to products in any category.</p>
                <?php else: ?>
                    <?php foreach ($brandsByCategory as $catName => $categoryBrands): ?>
                        <div class="category-group">
                            <div class="category-title">
                                <i class="fa fa-folder"></i> <?php echo htmlspecialchars($catName); ?>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($categoryBrands as $brand): ?>
                                    <span class="badge bg-primary" style="font-size: 0.9rem;">
                                        <?php echo htmlspecialchars($brand['brand_name']); ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="navigation-buttons">
            <a href="../index.php" class="btn btn-secondary"><i class="fa fa-home"></i> Back to Home</a>
            <a href="category.php" class="btn btn-info"><i class="fa fa-tags"></i> Manage Categories</a>
            <a href="product.php" class="btn btn-info"><i class="fa fa-box"></i> Manage Products</a>
            <a href="../login/logout.php" class="btn btn-outline-danger"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- UPDATE Modal - Only name is editable, not the ID -->
    <div class="modal fade" id="editBrandModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editBrandForm">
                    <div class="modal-body">
                        <!-- ID is not editable -->
                        <input type="hidden" id="editBrandId" name="brand_id">
                        <div class="mb-3">
                            <label class="form-label">Brand ID</label>
                            <input type="text" class="form-control" id="displayBrandId" disabled>
                            <div class="form-text">ID cannot be changed</div>
                        </div>
                        <!-- Only the name is editable -->
                        <div class="mb-3">
                            <label for="editBrandName" class="form-label">Brand Name</label>
                            <input type="text" class="form-control" id="editBrandName" name="brand_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Alert Messages Container -->
    <div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1060;"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/brand.js"></script>
</body>
</html>
