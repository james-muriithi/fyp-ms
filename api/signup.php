<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once 'config/database.php';
include_once 'classes/User.php';

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
        echo 'hey';
    }else{
        echo 'ney';
    }
}