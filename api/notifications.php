<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once './classes/NotificationsManager.php';
require_once './classes/Notification.php';
require_once './config/database.php';
require_once './classes/NewUploadNotification.php';
require_once './classes/NotificationAdapter.php';
require_once './classes/User.php';

$conn = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    if (empty($_GET)) {
        $_GET = json_decode(file_get_contents('php://input'), true) ? : [];
    }

    $data = $_GET;
    if (isset($data['user']) && !empty($data['user'])){
        $user = new User($conn);
        if ($user->userExists($data['user'])){
            $user->setUsername($data['user']);//sb30/pu/41769/16
            $x = new Notification($conn, $user);

            $notifications = $x->get($user);
            $notArray = [];
            foreach ($notifications as $notification) {
//    print_r($notification);
                switch ($notification['notifications'][0]['type']) {
                    case 'upload.new':
                        $x1 = new NewUploadNotification($conn, $user);
                        $notArray[] = $x1->messageForNotifications($notification['notifications']);
                        break;

                }
            }

            echo json_response(200,$notArray);
        }else{
            echo json_response(400,'The user does not exist.', true);
        }
    }
}else if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
    if (empty($_POST)) {
        $_POST = json_decode(file_get_contents('php://input'), true) ? : [];
    }

    $data = $_POST;

    if (isset($data['mark_as_read'])){
        $data = $data['mark_as_read'];
        if(isset($data['recipient'],$data['type'],$data['reference_id'])){
            $user = new User($conn);
            if ($user->userExists($data['recipient'])){
                $user->setUsername($data['recipient']);//sb30/pu/41769/16
                $x = new Notification($conn, $user);
                $x->setRecipient($data['recipient']);
                $x->setReferenceId($data['reference_id']);
                $x->setType($data['type']);

                if ($x->markRead($x)){
                    echo json_response(200, 'The notification was marked as read');
                }else{
                    echo json_response(400,'There was an error marking the notification.', true);
                }

            }else{
                echo json_response(400,'The recipient does not exist.', true);
            }
        }
        elseif (isset($data['mark_all'],$data['recipient'])){
            $user = new User($conn);
            if ($user->userExists($data['recipient'])){
                $user->setUsername($data['recipient']);//sb30/pu/41769/16
                $x = new Notification($conn, $user);
                $x->setRecipient($data['recipient']);

                if ($x->markAllAsRead($x)){
                    echo json_response(200, 'All your notifications were marked as read');
                }else{
                    echo json_response(400,'There was an error marking the notifications.', true);
                }

            }else{
                echo json_response(400,'The recipient does not exist.', true);
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
