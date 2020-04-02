<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (empty($_POST)) {
    $_POST = json_decode(file_get_contents('php://input'), true) ? : [];
}

$data = $_POST;

if (isset($data['message'],$data['phone'])) {
    $message = $data['message'];
    $phone = $data['phone'];
	header('Cache-Control: no-transform,public,max-age=300,s-maxage=900');
    // treat this as json
    header('Content-Type: application/json');
	
    echo sendSms($phone,$message);
}

function sendSms($phone, $message){
    $stkheader = array('Content-Type:application/json','Cache-Control:no-cache');
    $url = 'https://api.vaspro.co.ke/v3/BulkSMS/api/create';

    # initiating the transaction
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header

    $curl_post_data = array(
        'apiKey' => '8609f2c5db6795f9aecb7e791a704ef1',
        'shortCode' => 'VasPro',
        'enqueue' =>  1,
        'message' => $message,
        'recipient' =>$phone,
        'callbackURL' => 'http://vaspro.co.ke/dlr'
    );

    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    return curl_exec($curl);
}