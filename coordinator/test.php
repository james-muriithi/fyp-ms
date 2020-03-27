<?php
session_start();
include_once '../api/config/database.php';
include_once '../api/classes/Lecturer.php';
if (isset($_FILES['file']) && count($_FILES) === 1){
    $uploadDir = 'assets/images/users/';
    $file_name = $_FILES['file']['name'];
    $file_size =$_FILES['file']['size'];
    $file_tmp =$_FILES['file']['tmp_name'];
    $file_type=$_FILES['file']['type'];
    $arr = explode('.',$_FILES['file']['name']);
    $file_ext= strtolower(end($arr));
    $extensions= array('jpeg', 'jpg', 'png', 'gif');

    if (!in_array($file_ext, $extensions, false)){
        echo json_response(400, 'Please provide only an image of types '. implode(', ', $extensions), true);
        die();
    }
    if($file_size > 2097152){
        echo json_response(400, 'Please provide an image of types of size less than 2MB', true);
        die();
    }

    if (!is_dir($uploadDir)){
        if (!mkdir($uploadDir, '0777', true) && !is_dir($uploadDir)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $uploadDir));
        }
    }

    $filename = bin2hex(random_bytes(5)). '.' .$file_ext;
    if (file_exists($uploadDir.$filename)){
        $filename = bin2hex(random_bytes(5)). '.' .$file_ext;
    }
    $conn = Database::getInstance();
    $lec = new Lecturer($conn);
    $lec->setUsername($_SESSION['username']);
    $oldImage = $lec->getUser()['profile'];
    move_uploaded_file($file_tmp,$uploadDir.$filename);
    if ($lec->updateImage($filename)){
        echo json_response(200, 'Your image was uploaded successfully');
        unlink($uploadDir.$oldImage);
    }else{
        unlink($uploadDir.$filename);
        echo json_response(400, 'There was an error trying to upload your image. Please try again later.', true);
    }

    die();

}

echo json_response(400, 'You did not provide any image to upload', true);
die();

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