<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once 'config/database.php';
include_once 'classes/Student.php';
include_once 'classes/User.php';
include_once 'sendMessage.php';

$conn = Database::getInstance();

if (empty($_POST)) {
    $_POST = json_decode(file_get_contents('php://input'), true) ? : [];
}

$data = $_POST;

if (isset($data['name']) && !empty($data['name'])) {
    $username = $data['name'];
    $user = new User($conn);

    $user->setUsername($username);
    if ($user->userExists($username)){
        $token = $user->getDbToken()['token'];
        if (empty($token)) {
            $token = $user->saveToken()['token'];
        }
        $otp = $user->generateOTP()['otp'];
        $phone = '';
        $email = '';
        if ($user->getLevel() == 3){
            $student = new Student($conn);
            $student->setRegNo($username);
            $phone = $student->getUser()['phone_no'];
            $email = $student->getUser()['email'];
        }
        if (!@fsockopen('www.google.com',80)){
            echo json_response(500, 'Please make sure you have a working internet connection.', true);
        }else{
            sendMsg($phone, 'Your one time password is '.$otp);
            sendMail($email,'Your one time password is '.$otp,'Password Reset Code');
            echo json_response(200,$token);
        }
    }else{
        echo json_response(404, 'username does not exist', true);
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
    return json_encode(array(
        'success' => array('message' => $message)
    ));
}