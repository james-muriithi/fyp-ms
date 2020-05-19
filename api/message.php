<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once '../api/config/database.php';
include_once '../api/classes/Lecturer.php';
include_once '../api/classes/User.php';
include_once '../api/classes/Student.php';
include_once '../api/classes/Messages.php';

$conn = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if (empty($_POST)) {
        $_POST = json_decode(file_get_contents('php://input'), true) ?: [];
    }

    $data = $_POST;
    $user = new User($conn);

    if (isset($data['new_message'])){
        $data = $data['new_message'];
        if (isset($data['user'], $data['message'], $data['recipient'])){

            $user1 = $data['user'];
            $user2 = $data['recipient'];
            if ($user->userExists($user1) && $user->userExists($user2)){
                $msg = trim($data['message']);
                $message = new Messages($conn, $user);
                if (!empty($msg)){
                    if ($message->saveMessage($user2, $msg)){
                        echo json_response('200', 'The message was sent successfully');
                        exit();
                    }
                    echo json_response('400', 'There was an error sending the message.');
                    exit();
                }
            }elseif (!$user->userExists($user1)){
                echo json_response('400', 'The sender id does not exist', true);
                exit();
            }
            elseif (!$user->userExists($user2)){
                echo json_response('400', 'The receiver id does not exist', true);
                exit();
            }
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