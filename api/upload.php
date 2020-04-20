<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once '../api/config/database.php';
include_once '../api/classes/Lecturer.php';
include_once '../api/classes/Project.php';
include_once '../api/classes/Upload.php';
include_once '../api/classes/UploadCategory.php';
include_once '../api/classes/ProjectCategory.php';

$conn = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
    if (empty($_POST)) {
        $_POST = json_decode(file_get_contents('php://input'), true) ? : [];
    }

    $data = $_POST;

}elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH'){
    if (empty($_PATCH)) {
        $_PATCH = json_decode(file_get_contents('php://input'), true) ? : [];
    }
    $upload= new Upload($conn);

    $data = $_PATCH;
    if (isset($data['approve'])){
        $uid = $data['approve']['upload_id'];
        if ($upload->uploadExists($uid)){
            $conn->beginTransaction();
            if ($upload->setUploadStatus($uid, 1)){
                $conn->commit();
                echo json_response(200, 'The upload has been approved successfully.');
                die();
            }else{
                $conn->rollBack();
                echo json_response(400,'There was error approving the upload. Please try again later.',true);
                die();
            }
        }else{
            echo json_response(409,' The provided upload id does not exist.
             Please provide a different one.',true);
            die();
        }
    }elseif (isset($data['reject'])){
        $uid = $data['reject']['upload_id'];
        if ($upload->uploadExists($uid)){
            $conn->beginTransaction();
            if ($upload->setUploadStatus($uid, 2)){
                $conn->commit();
                echo json_response(200, 'The upload has been rejected successfully.');
                die();
            }else{
                $conn->rollBack();
                echo json_response(400,'There was error rejecting the upload. Please try again later.',true);
                die();
            }
        }else{
            echo json_response(409,' The provided upload id does not exist.
             Please provide a different one.',true);
            die();
        }
    }elseif (isset($data['undo'])){
        $uid = $data['undo']['upload_id'];
        if ($upload->uploadExists($uid)){
            $conn->beginTransaction();
            if ($upload->setUploadStatus($uid, 0)){
                $conn->commit();
                echo json_response(200, 'The upload has been set to pending.');
                die();
            }else{
                $conn->rollBack();
                echo json_response(400,'An unexpected error occurred. Please try again later.',true);
                die();
            }
        }else{
            echo json_response(409,' The provided upload id does not exist.
             Please provide a different one.',true);
            die();
        }
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (empty($_DELETE)) {
        $_DELETE = json_decode(file_get_contents('php://input'), true) ?: [];
    }
    $data = $_DELETE;
    $upload= new Upload($conn);
    if (isset($data['upload_id'])){
        $uid = $data['upload_id'];
        if ($upload->uploadExists($uid)){
            $conn->beginTransaction();
            if ($upload->deleteUpload($uid)){
                $conn->rollBack();
                echo json_response(200, 'The upload was deleted successfully.');
                die();
            }else{
                $conn->rollBack();
                echo json_response(400,'There was error deleting the upload. Please try again later.',true);
                die();
            }
        }else{
            echo json_response(409,' The provided upload id does not exist.
             Please provide a different one.',true);
            die();
        }
    }

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
