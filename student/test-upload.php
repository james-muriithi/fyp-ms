<?php
session_start();
include_once '../api/config/database.php';
include_once '../api/classes/Student.php';
include_once '../api/classes/Upload.php';
include_once '../api/classes/Project.php';
include_once '../api/classes/UploadCategory.php';
$conn = Database::getInstance();
$student = new Student($conn);
$upload = new Upload($conn);
$project = new Project($conn);
define('UPLOAD_DIR', 'uploads/');
if(!is_dir(UPLOAD_DIR)){
    if (!mkdir(UPLOAD_DIR, '0777', true) && !is_dir(UPLOAD_DIR)) {
        echo json_response(400, 'There was an error creating a directory', true);
        die();
    }
}
if (isset($_FILES['file'], $_POST['student'], $_POST['category']) && count($_FILES) === 1){
    $reg_no = $_POST['student'];
    $cat_id = $_POST['category'];

    validateDetails($reg_no, $cat_id);

    $pid = $project->viewStudentProject($reg_no)['id'];
    $uc = new UploadCategory($conn);

    if (!isset($_POST['edit']) && $uc->hasUpload($pid, $cat_id)) {
        echo json_response(400, 'You have already uploaded a file. Please edit to remove the current one.', true);
        die();
    }

    uploadFIle($_FILES, $reg_no, $cat_id);

}

function uploadFIle($file, $reg_no, $cat_id){
    global $upload,$student, $uc, $project, $conn;
    $uploadDir = UPLOAD_DIR.str_replace('/','', $reg_no).'/'.$cat_id.'/';
    $_FILES = $file;
    $file_name = $_FILES['file']['name'];
    $file_size =$_FILES['file']['size'];
    $file_tmp =$_FILES['file']['tmp_name'];
    $file_type=$_FILES['file']['type'];
    $arr = explode('.',$_FILES['file']['name']);
    $file_ext= strtolower(end($arr));
    $extensions= array('tar.gz', 'docx','pdf', 'doc', 'zip', 'odf');


    if (!in_array($file_ext, $extensions, false)){
        echo json_response(400, 'Please provide only an image of types '. implode(', ', $extensions), true);
        die();
    }

    if($file_size > 15097152){
        echo json_response(400, 'Please provide a  file  of size less than 15MB', true);
        die();
    }

    if (!is_dir($uploadDir)){
        if (!mkdir($uploadDir, '0777', true) && !is_dir($uploadDir)) {
            echo json_response(400, 'Directory '.$uploadDir.' was not created', true);
            die();
        }
    }

    try {
        $filename = bin2hex(random_bytes(5)) . '.' . $file_ext;  //.'-'.$uc->viewCategory($cat_id)['name']
    } catch (Exception $e) {
        echo json_response(400, 'Unable to crate a file name', true);
        die();
    }
    if (file_exists($uploadDir.$filename)){
        $filename = bin2hex(random_bytes(5)). '.' .$file_ext;
    }


    $oldUpload = '';
    $pid = $project->viewStudentProject($reg_no)['id'];
    $uc = new UploadCategory($conn);

    if ($uc->hasUpload($pid, $cat_id)){
        $oldUpload = $uc->getStudentCategoryUpload($cat_id, $pid)['name'];
        if (!$upload->deleteUpload($uc->getStudentCategoryUpload($cat_id, $pid)['id'])){
            echo json_response(400, 'There was an error trying to upload your file. Please try again later.', true);
            die();
        }
    }

    if (move_uploaded_file($file_tmp,$uploadDir.$filename) && $upload->addUpload($filename, $pid, $cat_id)){
        echo json_response(200, 'Your file was uploaded successfully');
        @unlink($uploadDir.$oldUpload);
    }else{
        @unlink($uploadDir.$filename);
        echo json_response(400, 'There was an error trying to upload your file. Please try again later.', true);
    }

    die();
}

function validateDetails($reg_no, $cat_id){
    global $conn, $student;
    $uc = new UploadCategory($conn);
    $student->setUsername($reg_no);
    if (!$student->regExists($reg_no)){
        echo json_response(404, 'The provided registration number does not exist', true);
        die();
    }
    elseif (!$uc->categoryExists($cat_id)){
        echo json_response(404, 'The provided category does not exist', true);
        die();
    }
}

function json_response($code = 200, $message = null, $error = false, $args = [])
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
        400 => '400 Bad Request',
        404 => '404 Not Found',
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
    $payload = array('success' => array('message' => $message));
    if (count($args) != 0){
        $payload['payload'] = $args;
    }
    return json_encode($payload);
}