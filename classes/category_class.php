<?php
require_once __DIR__.'/../settings/db_class.php';
//extend existing database connection so we can interact with the categories table
class Category extends db_connection
{
//add new category to database and creates new category ID if it is successful
public function add($cat_name)
{
    //check if category name already exists
    $check_sql="SELECT cat_id FROM categories WHERE cat_name=?";
    if($this->db_query($check_sql)){
        $stmt=$this->db->prepare($check_sql);
        $stmt->bind_param("s",$cat_name);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows>0){
            return false;
        }
    }
    $sql="INSERT INTO categories (cat_name) VALUES (?)";
    $stmt=$this->db->prepare($sql);
    $stmt->bind_param("s",$cat_name);
    if($stmt->execute()){
        return $this->last_insert_id();
    }
    return false;
}

//retrieve all categories from database to display the category list on admin page
public function get()
{
    $sql="SELECT * FROM categories ORDER BY cat_name ASC";
    return $this->db_fetch_all($sql);
}

//get single category by its id for editing or displaying single category details
public function getCategoryById($cat_id)
{
    $sql="SELECT * FROM categories WHERE cat_id=?";
    $stmt=$this->db->prepare($sql);
    $stmt->bind_param("i",$cat_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

//update existing category name
public function edit($cat_id,$cat_name)
{
    //check if new name already exists in other categories so new name doesn't conflict with others
    $check_sql="SELECT cat_id FROM categories WHERE cat_name=? AND cat_id!=?";
    $stmt=$this->db->prepare($check_sql);
    $stmt->bind_param("si",$cat_name,$cat_id);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows>0){
        return false;
    }
    $sql="UPDATE categories SET cat_name=? WHERE cat_id=?";
    $stmt=$this->db->prepare($sql);
    $stmt->bind_param("si",$cat_name,$cat_id);
    return $stmt->execute();
}

//remove category from database
public function delete($cat_id)
{
    $sql="DELETE FROM categories WHERE cat_id=?";
    $stmt=$this->db->prepare($sql);
    $stmt->bind_param("i",$cat_id);
    return $stmt->execute();
}

//find category by name for validation and lookup
public function getCategoryByName($cat_name)
{
    $sql="SELECT * FROM categories WHERE cat_name=?";
    $stmt=$this->db->prepare($sql);
    $stmt->bind_param("s",$cat_name);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
}
?>