<?php
require_once 'api/config/database.php';
require_once 'api/classes/User.php';

$conn = Database::getInstance();
//$student = new Student($conn);
//$conn->beginTransaction();
//var_dump($student->saveUser('SB30/PU/41760/16','JAMES MURIITHI','muriithijames556@gmail.com','0746792699'));
//$student->setRegNo('SB30/PU/41760/16');
////var_dump($student->regExists($student->getRegNo()));
//if ($student->userExists($student->getRegNo())){
////    var_dump($student->getToken());
//    if (!isset($student->getToken()['token'])){
//        echo json_encode($student->signUp('0000'));
//    }else{
//        echo json_encode(array('error'=>'user already signed up'));
//    }
//}
//echo json_encode($student->getUser());
//$student->setPassword('0000');
//var_dump($student->verifyUser());
$user = new User($conn);
$user->setUsername('SB30/PU/41760/16');
print_r($user->getLevel());
//print_r($user->generateOTP());
var_dump(@fsockopen('www.google.com',80));
