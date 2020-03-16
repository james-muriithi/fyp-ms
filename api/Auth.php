<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/api/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include_once 'config/database.php';
include_once 'classes/User.php';

$conn = Database::getInstance();

if (empty($_POST)) {
    $_POST = json_decode(file_get_contents('php://input'), true) ? : [];
}

$data = $_POST;

if (isset($data['name'], $data['password']) && !empty($data['name']) && !empty($data['password'])) {
    $username = $data['name'];
    $password = $data['password'];
    $user = new User($conn);

    $user->setUsername($username);
    $user->setPassword($password);

    if ($user->verifyUser()){
        echo json_response(200, 'successful login',false,$user->getUser());
        $_SESSION['login'] = 1;
        $_SESSION['username'] = $username;
        $_SESSION['level'] = $user->getUser()['level'];
    }else{
        echo json_response(404, 'User does not exist!',true);
    }
}elseif (!empty($data['name']) && empty($data['password'])){
    echo json_response(400, 'password was not provided',true);
}
elseif (!empty($data['password']) && empty($data['name'])){
    echo json_response(400, 'username was not provided',true);
}
else{
    echo json_response(400, 'username and password was not provided',true);
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

