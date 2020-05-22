<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: *');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Africa/Nairobi');

define( 'TIMEBEFORE_NOW',         'now' );
define( 'TIMEBEFORE_MINUTE',      '{num} minute ago' );
define( 'TIMEBEFORE_MINUTES',     '{num} minutes ago' );
define( 'TIMEBEFORE_HOUR',        '{num} hour ago' );
define( 'TIMEBEFORE_HOURS',       '{num} hours ago' );
define( 'TIMEBEFORE_YESTERDAY',   'yesterday, {time}' );
define( 'TIMEBEFORE_THISWEEK',   '%a, %H:%M' );
define( 'TIMEBEFORE_FORMAT',      '%e %b, %H:%M' );
define('MYTIMEBEFORE_FORMAT', '%H:%M');
define( 'TIMEBEFORE_FORMAT_YEAR', '%D, %H:%M' );


include_once '../api/config/database.php';
include_once '../api/classes/Lecturer.php';
include_once '../api/classes/User.php';
include_once '../api/classes/Student.php';
include_once '../api/classes/Messages.php';
include_once '../api/classes/Project.php';

$conn = Database::getInstance();
$user = new User($conn);
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if (empty($_POST)) {
        $_POST = json_decode(file_get_contents('php://input'), true) ?: [];
    }

    $data = $_POST;

    if (isset($data['new_message'])){
        $data = $data['new_message'];
        if (isset($data['sender'], $data['message'], $data['recipient'])){
            $user1 = $data['sender'];
            $user2 = $data['recipient'];
            if ($user->userExists($user1) && $user->userExists($user2) && $user1 != $user2){
                $msg = trim($data['message']);
                $message = new Messages($conn, $user1);
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
            }elseif ($user1 == $user2){
                echo json_response('400', 'You cannot send a message to yourself.', true);
                exit();
            }
        }
    }
    elseif (isset($data['mark_as_read'])){
        $data = $data['mark_as_read'];
        if (isset($data['sender'], $data['recipient'])){
            $user1 = $data['sender'];
            $user2 = $data['recipient'];
            if ($user->userExists($user1) && $user->userExists($user2)) {
                $message = new Messages($conn, $user2);
                if ($message->markSenderMessagesRead($user1)){
                    echo json_response('200', 'The messages were marked as read');
                    exit();
                }
                echo json_response('400', 'There was an error marking the message read.');
                exit();
            }
        }
    }
}elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (empty($_GET)) {
        $_GET = json_decode(file_get_contents('php://input'), true) ?: [];
    }
    $data = $_GET;
    if (isset($data['conversation'], $data['sender'], $data['recipient'])) {

        $user1 = $data['sender'];
        $user2 = $data['recipient'];
        if ($user->userExists($user1) && $user->userExists($user2)) {
            $message = new Messages($conn, $data['recipient']);
            $messageArray = [];
            $messageArray['messages'] = [];
            $user->setUsername($user1);

            if ((int)$user->getLevel() === 3) {
                $student = new Student($conn);
                $student->setUsername($user1);
                $messageArray['sender'] = $student->getUser();
                $p = new Project($conn);
                $messageArray['sender']['project'] = $p->viewStudentProject($user1);
            } else {
                $lecturer = new Lecturer($conn);
                $lecturer->setUsername($user1);
                $messageArray['sender'] = $lecturer->getUser();
            }

            foreach ($message->getSenderAllMessages($data['sender']) as $msg) {
                $msg['created_at'] = time_ago(strtotime($msg['created_at']));
                $messageArray['messages'][] = $msg;
            }

//            print_r($messageArray);

            echo json_response(200, $messageArray);
            exit();
        }

    } elseif (isset($data['new_messages'], $data['sender'], $data['recipient'])) {
        $user1 = $data['sender'];
        $user2 = $data['recipient'];
        if ($user->userExists($user1) && $user->userExists($user2)) {
            $message = new Messages($conn, $data['recipient']);
            $messageArray = [];
            $messageArray['messages'] = [];
            $user->setUsername($user1);

            if ((int)$user->getLevel() === 3) {
                $student = new Student($conn);
                $student->setUsername($user1);
                $messageArray['sender'] = $student->getUser();
                $p = new Project($conn);
                $messageArray['sender']['project'] = $p->viewStudentProject($user1);
            } else {
                $lecturer = new Lecturer($conn);
                $lecturer->setUsername($user1);
                $messageArray['sender'] = $lecturer->getUser();
            }

            foreach ($message->getSenderAllUnreadMessages($user1) as $msg) {
                $msg['created_at'] = time_ago(strtotime($msg['created_at']));
                $messageArray['messages'][] = $msg;
            }

            echo json_response(200, $messageArray);
        }
    }
}

function time_ago( $time )
{
    $now    = time(); // current time
    $diff   = $now - $time; // difference between the current and the provided dates

    if( $diff < 60 ) // it happened now
        return TIMEBEFORE_NOW;

    elseif( $diff < 3600 ) // it happened X minutes ago
        return strftime(MYTIMEBEFORE_FORMAT, $time);

    elseif( $diff < 3600 * 24 ) // it happened X hours ago
        return strftime(MYTIMEBEFORE_FORMAT, $time);

    elseif( $diff < 3600 * 24 * 2 ) // it happened yesterday
        return str_replace( '{time}', strftime(MYTIMEBEFORE_FORMAT, $time), TIMEBEFORE_YESTERDAY );

    elseif( $diff < 3600 * 24 * 8 ) // it happened this week
        return strftime( TIMEBEFORE_THISWEEK, $time );


    else // falling back on a usual date format as it happened later than yesterday
        return strftime( date( 'Y', $time ) == date( 'Y' ) ? TIMEBEFORE_FORMAT : TIMEBEFORE_FORMAT_YEAR, $time );
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