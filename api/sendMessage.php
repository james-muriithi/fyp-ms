<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/api/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (empty($_POST)) {
    $_POST = json_decode(file_get_contents('php://input'), true) ? : [];
}

$data = $_POST;

if (isset($data['phone'], $data['message']) && !empty($data['phone']) && !empty($data['message'])) {
    $phone = $data['phone'];
    $message = $data['message'];
    if (!@fsockopen('www.google.com',80)){
        echo json_response(['sent'=> false]);
    }else{
        sendMsg($phone,$message);
        echo json_encode(['sent'=> true]);
    }
    die();
}
//sendMsg('0746792699', 'hello there your code is 12345');
function sendMsg($phone, $msg){

    //    required headers
    $stkheader = array('Content-Type:application/json','Cache-Control:no-cache');
//    url to post the data
    $url = 'https://indexfand.com/api/sendMessage.php';

    # initiating curl
    $curl = curl_init();
//    set curl url
    curl_setopt($curl, CURLOPT_URL, $url);
//    set cur headers
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

//    data to be posted to the url
    $curl_post_data = array(
        'message' => $msg,
        'phone' => $phone
    );

//json encode the data
    $data_string = json_encode($curl_post_data);
//    expect to return value from url
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//    set method to POST
    curl_setopt($curl, CURLOPT_POST, true);
//    set the data to post
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
//    print the response
    curl_exec($curl);

    return true;
}

function sendMail($to, $msg, $subject, $from=''){
//    required headers
    $stkheader = array('Content-Type:application/json','Cache-Control:no-cache');
//    url to post the data
    $url = 'https://indexfand.com/api/sendMail.php';

    # initiating curl
    $curl = curl_init();
//    set curl url
    curl_setopt($curl, CURLOPT_URL, $url);
//    set cur headers
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

//    data to be posted to the url
    $curl_post_data = array(
        'message' => $msg,
        'to' => $to,
        'subject' =>  $subject,
        'from'=>$from
    );

//json encode the data
    $data_string = json_encode($curl_post_data);
//    expect to return value from url
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//    set method to POST
    curl_setopt($curl, CURLOPT_POST, true);
//    set the data to post
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
//    print the response
    curl_exec($curl);
    
    return true;
}