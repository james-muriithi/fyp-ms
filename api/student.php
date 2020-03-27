<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once '../api/config/database.php';
include_once '../api/classes/Student.php';
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
                echo json_response(201, 'Student'.$reg_no.' was added successfully.');
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
