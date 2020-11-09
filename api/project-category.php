<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once '../api/config/database.php';
include_once '../api/classes/ProjectCategory.php';

$conn = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
    if (empty($_POST)) {
        $_POST = json_decode(file_get_contents('php://input'), true) ? : [];
    }

    $data = $_POST;
    if(isset($data['category_name'])){
        $catName = $data['category_name'];

        $uc = new ProjectCategory($conn);
        if ($uc->categoryNameExists($catName)){
            echo json_response(409,$catName.' already exists. Please choose a different name.',true);
            die();
        }else{
            $conn->beginTransaction();
            if ($uc->addCategory($catName)){
                $conn->commit();
                echo json_response(200, $catName.' has been added successfully.');
                die();
            }else{
                $conn->rollBack();
                echo json_response(400,'There was error adding the category. Please try again later.',true);
                die();
            }
        }


    }else{
        echo json_response(400,'Please make sure you provide all the required fields. i.e category_name, startDate, endDate and description',true);
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH'){
    if (empty($_PATCH)) {
        $_PATCH = json_decode(file_get_contents('php://input'), true) ? : [];
    }

    $data = $_PATCH;

    if(isset($data['category']) && !empty($data['category'])){
        $cat_id = $data['category'];
        $uc = new ProjectCategory($conn);
        $uc->setCatId($cat_id);
        $catDetails = $uc->viewCategory();

        if ($uc->categoryExists($cat_id)){
            $name = empty($data['category']) ? $catDetails['name'] : $data['category_name'];

            if (($name != $catDetails['name']) && $uc->categoryNameExists($name)) {
                echo json_response(409,'That category name already exists. Please provide another one.',true);
                die();
            }
            $conn->beginTransaction();
            if ($uc->editCategory($cat_id, $data['category_name'])){
                $conn->commit();
                echo json_response(201, 'The category was updated successfully.');
                die();
            }else{
                $conn->rollBack();
                echo json_response(400,'There was error updating the category. Please try again later.',true);
                die();
            }

        }else{
            echo json_response(400,'That category id does not exist! Please provide a correct category id.',true);
            die();
        }
    }else{
        print_r($data);
        echo json_response(400,'Please make sure you provide all the required fields. i.e empid and  name or phone or email or expertise',true);
        die();
    }

}
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (empty($_DELETE)) {
        $_DELETE = json_decode(file_get_contents('php://input'), true) ?: [];
    }
    $data = $_DELETE;

    if(isset($data['category']) && !empty($data['category'])) {
        $catId = $data['category'];
        $uc = new ProjectCategory($conn);
        $uc->setCatId($catId);
        if ($uc->categoryExists($catId)) {
            $conn->beginTransaction();
            if ($uc->deleteCategory($catId)){
                $conn->commit();
                echo json_response(201, 'The category was deleted successfully.');
                die();
            }

            $conn->rollBack();
            echo json_response(400,'There was error deleting the category. Please try again later.',true);
            die();
        }

        echo json_response(400,'That category id does not exist! Please provide a correct category.',true);
        die();
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $uc = new UploadCategory($conn);
    echo json_encode($uc->viewAllCategories());
}


function json_response($code = 200, $message = null, $error = false)
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);
    // set the header to make sure cache is forced
    header('Cache-Control: no-transform,public,max-age=300,s-maxage=900');
    // treat this as json
    header('Content-Type: application/json');
    $status = array(
        200 => '200 OK',
        201 => '201 Created',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        404 => '404 Not Found',
        409 => '409 Conflict',
        422 => 'Unprocessable Entity',
        500 => '500 Internal Server Error'
    );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    // return the encoded json
    if ($error){
        return json_encode(array(
            'status' => $status[$code] === 200,
            'error' => array('errorCode'=>0,'message' => $message)
        ));
    }
    return json_encode(array(
        'success' => array('message' => $message)
    ));
}
