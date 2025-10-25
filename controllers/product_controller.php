<?php
require_once __DIR__ . '/../classes/product_class.php';

// Add product
function add_product_ctr($cat_id, $brand_id, $title, $price, $desc, $image, $keywords)
{
    $product = new Product();
    $product_id = $product->add($cat_id, $brand_id, $title, $price, $desc, $image, $keywords);
    if ($product_id) {
        return $product_id;
    } else {
        return false;
    }
}

// Get all products
function get_all_products_ctr()
{
    $product = new Product();
    $result = $product->get();
    if ($result) {
        return $result;
    } else {
        return false;
    }
}

// Get product by ID
function get_product_by_id_ctr($product_id)
{
    $product = new Product();
    $result = $product->getProductById($product_id);
    if ($result) {
        return $result;
    } else {
        return false;
    }
}

// Update product
function update_product_ctr($product_id, $cat_id, $brand_id, $title, $price, $desc, $image, $keywords)
{
    $product = new Product();
    $updated = $product->edit($product_id, $cat_id, $brand_id, $title, $price, $desc, $image, $keywords);
    if ($updated) {
        return true;
    } else {
        return false;
    }
}

// Delete product
function delete_product_ctr($product_id)
{
    $product = new Product();
    $deleted = $product->delete($product_id);
    if ($deleted) {
        return true;
    } else {
        return false;
    }
}

// Get products by category
function get_products_by_category_ctr($cat_id)
{
    $product = new Product();
    $result = $product->getProductsByCategory($cat_id);
    if ($result) {
        return $result;
    } else {
        return false;
    }
}

// Get products by brand
function get_products_by_brand_ctr($brand_id)
{
    $product = new Product();
    $result = $product->getProductsByBrand($brand_id);
    if ($result) {
        return $result;
    } else {
        return false;
    }
}

// Search products
function search_products_ctr($keyword)
{
    $product = new Product();
    $result = $product->searchProducts($keyword);
    if ($result) {
        return $result;
    } else {
        return false;
    }
}
?>
