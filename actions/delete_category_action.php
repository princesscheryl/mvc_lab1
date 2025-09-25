<?php
header('Content-Type: application/json');
session_start();

require_once '../controllers/category_controller.php';
require_once '../settings/core.php';

$response=array();

//check if user is logged in and is admin
if(!isLoggedIn()){
    $response['success']=false;
    $response['message']='Please log in first';
    echo json_encode($response);
    exit();
}

if(!isAdmin()){
    $response['success']=false;
    $response['message']='Access denied. Admin privileges required';
    echo json_encode($response);
    exit();
}

$cat_id=isset($_POST['category_id'])?(int)$_POST['category_id']:0;

//validate category id
if($cat_id<=0){
    $response['success']=false;
    $response['message']='Invalid category ID';
}else{
    //delete category using controller
    $deleted=delete_category_ctr($cat_id);
    if($deleted){
        $response['success']=true;
        $response['message']='Category deleted successfully';
    }else{
        $response['success']=false;
        $response['message']='Failed to delete category';
    }
}

echo json_encode($response);
?>