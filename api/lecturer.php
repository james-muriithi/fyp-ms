<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once '../api/config/database.php';
include_once '../api/classes/Lecturer.php';
include_once '../api/classes/User.php';

$conn = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
    if (empty($_POST)) {
        $_POST = json_decode(file_get_contents('php://input'), true) ? : [];
    }

    $data = $_POST;

    if(isset($data['empid'],$data['name'],$data['email'],$data['phone'], $data['expertise'])){
        $emp_id = $data['empid'];
        $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];
        $expertise = $data['expertise'];

        $lecturer = new Lecturer($conn);

        if ($lecturer->empIdExists($emp_id)){
            echo json_response(409,'That employee id already exists',true);
            die();
        }elseif ($lecturer->emailExists($email)){
            echo json_response(409,'That email already exists',true);
            die();
        }else{
            $conn->beginTransaction();
            if ($lecturer->saveUser($emp_id, $name, $email, $phone, $expertise)){
                $conn->commit();
                echo json_response(201, 'Lecturer '.$name.' was added successfully.');
                die();
            }else{
                $conn->rollBack();
                echo json_response(400,'There was error adding the lecturer. Please try again later.',true);
                die();
            }
        }


    }else{
        echo json_response(400,'Please make sure you provide all the required fields. i.e empid, name, phone, email and expertise',true);
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH'){
    if (empty($_PATCH)) {
        $_PATCH = json_decode(file_get_contents('php://input'), true) ? : [];
    }

    $data = $_PATCH;

    if(isset($data['empid']) && !empty($data['empid'])){
        $emp_id = $data['empid'];
        $lecturer = new Lecturer($conn);
        $lecturer->setUsername($emp_id);
        $lecDetails = $lecturer->getUser();
        if ($lecturer->userExists($emp_id)){
            $name = empty($data['name']) ? $lecDetails['full_name'] : $data['name'];
            $phone = empty($data['phone']) ? $lecDetails['phone_no'] : $data['phone'];
            $expertise = empty($data['expertise']) ? $lecDetails['expertise'] : $data['expertise'];
            $newEmail = empty($data['email']) ? $lecDetails['email'] : $data['email'];

            if (($newEmail != $lecDetails['email']) && $lecturer->emailExists($newEmail)) {
                echo json_response(409,'That email already exists. Please provide another one.',true);
                die();
            }
            $conn->beginTransaction();
            if ($lecturer->updateUser($emp_id ,$name,$newEmail,$phone,$expertise)){
                $conn->commit();
                echo json_response(201, 'Your Details were updated successfully.');
                die();
            }else{
                $conn->rollBack();
                echo json_response(400,'There was error updating your details. Please try again later.',true);
                die();
            }

        }else{
            echo json_response(400,'That employee id does not exist! Please provide a correct employee id.',true);
            die();
        }
    }else{
        echo json_response(400,'Please make sure you provide all the required fields. i.e empid and  name or phone or email or expertise',true);
        die();
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
