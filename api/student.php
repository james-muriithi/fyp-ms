<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once '../api/config/database.php';
include_once 'classes/Student.php';
include_once '../api/classes/User.php';

$conn = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
    if (empty($_POST)) {
        $_POST = json_decode(file_get_contents('php://input'), true) ? : [];
    }

    $data = $_POST;

    if(isset($data['regno'],$data['name'],$data['email'],$data['phone'])){
        $reg_no = $data['regno'];
        $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];

        $student = new Student($conn);
        if ($student->regExists($reg_no)){
            echo json_response(409,'That registration number already exists',true);
            die();
        }elseif ($student->emailExists($email)){
            echo json_response(409,'That email already exists',true);
            die();
        }else{
            $conn->beginTransaction();
            if ($student->saveUser($reg_no, $name, $email, $phone)){
                $conn->commit();
                echo json_response(200, 'Student'.$reg_no.' was added successfully.');
                die();
            }else{
                $conn->rollBack();
                echo json_response(400,'There was error adding the student. Please try again later.',true);
                die();
            }
        }


    }else{
        echo json_response(400,'Please make sure you provide all the required fields. i.e regno, name, phone and email',true);
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH'){
    if (empty($_PATCH)) {
        $_PATCH = json_decode(file_get_contents('php://input'), true) ? : [];
    }
    $data = $_PATCH;

    if(isset($data['regno']) && !empty($data['regno'])) {
        $reg_no = $data['regno'];
        $student = new Student($conn);
        $student->setUsername($reg_no);
        $studentDetails = $student->getUser();
        if ($student->regExists($reg_no)){
            $name = empty($data['name']) ? $studentDetails['full_name'] : $data['name'];
            $phone = empty($data['phone']) ? $studentDetails['phone_no'] : $data['phone'];
            $newEmail = empty($data['email']) ? $studentDetails['email'] : $data['email'];

            if (($newEmail != $studentDetails['email']) && $student->emailExists($newEmail)) {
                echo json_response(409,'That email already exists. Please provide another one.',true);
                die();
            }
            $conn->beginTransaction();
            if ($student->updateUser($reg_no ,$name,$newEmail,$phone)){
                $conn->commit();
                echo json_response(201, 'The Student Details were updated successfully.');
                die();
            }else{
                $conn->rollBack();
                echo json_response(400,'There was error updating the student details. Please try again later.',true);
                die();
            }
        }else{
            echo json_response(400,'That registration no does not exist! Please provide a correct reg no.',true);
            die();
        }
    }else{
        echo json_response(400,'Please make sure you provide all the required fields. i.e regno and  name or phone or email',true);
        die();
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (empty($_DELETE)) {
        $_DELETE = json_decode(file_get_contents('php://input'), true) ?: [];
    }
    $data = $_DELETE;

    if(isset($data['student']) && !empty($data['student'])) {
        $reg_no = $data['student'];
        $student = new Student($conn);
        $student->setUsername($reg_no);
        if ($student->regExists($reg_no)) {
            $conn->beginTransaction();
            if ($student->deleteUser($reg_no)){
                $conn->rollBack();
                echo json_response(201, 'The Student was deleted successfully.');
                die();
            }else{
                $conn->rollBack();
                echo json_response(400,'There was error deleting the student. Please try again later.',true);
                die();
            }
        }else{
            echo json_response(400,'That registration no does not exist! Please provide a correct reg no.',true);
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
