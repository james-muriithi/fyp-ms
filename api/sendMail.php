<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (empty($_POST)) {
    $_POST = json_decode(file_get_contents('php://input'), true) ? : [];
}

$data = $_POST;

if (isset($data['message'],$data['to'], $data['subject'])) {
    $message = $data['message'];
    $to = $data['to'];
    $subject = $data['subject'];
    if (isset($data['from']) && !empty($data['from'])){
        echo json_encode(sendMail($to,$message,$subject,$data['from']));
        die();
    }
    echo json_encode(sendMail($to,$message,$subject));
    die();
}

function sendMail($to, $message, $subject, $from = 'James Muriithi', $cc='')
{
    // To send HTML mail, the Content-type header must be set
    $headers  = 'From: ' .$from." < support@theschemaqhigh.co.ke >\r\n";
    $headers .= 'X-Sender: ' .$from." < support@theschemaqhigh.co.ke >\r\n";
    $headers .= 'X-Mailer: PHP/' . PHP_VERSION ."\r\n";
    $headers .= "X-Priority: 1\r\n"; // Urgent message!
    $headers .= "Return-Path: support@theschemaqhigh.co.ke\r\n"; // Return path for errors
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
    if(!empty($cc) ){
        $headers .= 'Cc: '.$cc . "\r\n";
    }

    return array('sent' => @mail($to, $subject, $message, $headers),
        'details'=> array(
            'to'=>$to,
            'from' => $from,
            'message' => $message,
            'fromEmail'=> 'support@theschemaqhigh.co.ke'
        )
    );
}