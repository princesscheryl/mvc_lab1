<?php
require_once __DIR__.'/../settings/db_class.php';

class Product extends db_connection
{
    public function __construct()
    {
        $this->db_connect();
    }

    // Add new product to database
    public function add($cat_id, $brand_id, $title, $price, $desc, $image, $keywords)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO products (product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords)
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("iisdsss", $cat_id, $brand_id, $title, $price, $desc, $image, $keywords);

        if ($stmt->execute()) {
            return $this->last_insert_id();
        }
        return false;
    }

    // Retrieve all products
    public function get()
    {
        $sql = "SELECT p.*, c.cat_name, b.brand_name
                FROM products p
                INNER JOIN categories c ON p.product_cat = c.cat_id
                INNER JOIN brands b ON p.product_brand = b.brand_id
                ORDER BY p.product_id DESC";
        return $this->db_fetch_all($sql);
    }

    // Get single product by ID
    public function getProductById($product_id)
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.cat_name, b.brand_name
            FROM products p
            INNER JOIN categories c ON p.product_cat = c.cat_id
            INNER JOIN brands b ON p.product_brand = b.brand_id
            WHERE p.product_id = ?"
        );
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update existing product
    public function edit($product_id, $cat_id, $brand_id, $title, $price, $desc, $image, $keywords)
    {
        // If image is empty, don't update it
        if (empty($image)) {
            $stmt = $this->db->prepare(
                "UPDATE products
                SET product_cat = ?, product_brand = ?, product_title = ?, product_price = ?,
                    product_desc = ?, product_keywords = ?
                WHERE product_id = ?"
            );
            $stmt->bind_param("iisdssi", $cat_id, $brand_id, $title, $price, $desc, $keywords, $product_id);
        } else {
            $stmt = $this->db->prepare(
                "UPDATE products
                SET product_cat = ?, product_brand = ?, product_title = ?, product_price = ?,
                    product_desc = ?, product_image = ?, product_keywords = ?
                WHERE product_id = ?"
            );
            $stmt->bind_param("iisdsssi", $cat_id, $brand_id, $title, $price, $desc, $image, $keywords, $product_id);
        }

        return $stmt->execute();
    }

    // Delete product from database
    public function delete($product_id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        return $stmt->execute();
    }

    // Get products by category
    public function getProductsByCategory($cat_id)
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.cat_name, b.brand_name
            FROM products p
            INNER JOIN categories c ON p.product_cat = c.cat_id
            INNER JOIN brands b ON p.product_brand = b.brand_id
            WHERE p.product_cat = ?
            ORDER BY p.product_id DESC"
        );
        $stmt->bind_param("i", $cat_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get products by brand
    public function getProductsByBrand($brand_id)
    {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.cat_name, b.brand_name
            FROM products p
            INNER JOIN categories c ON p.product_cat = c.cat_id
            INNER JOIN brands b ON p.product_brand = b.brand_id
            WHERE p.product_brand = ?
            ORDER BY p.product_id DESC"
        );
        $stmt->bind_param("i", $brand_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Search products by keyword
    public function searchProducts($keyword)
    {
        $searchTerm = "%{$keyword}%";
        $stmt = $this->db->prepare(
            "SELECT p.*, c.cat_name, b.brand_name
            FROM products p
            INNER JOIN categories c ON p.product_cat = c.cat_id
            INNER JOIN brands b ON p.product_brand = b.brand_id
            WHERE p.product_title LIKE ? OR p.product_desc LIKE ? OR p.product_keywords LIKE ?
            ORDER BY p.product_id DESC"
        );
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
