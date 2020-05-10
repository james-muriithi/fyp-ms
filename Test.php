<?php
require_once 'api/config/database.php';
require_once 'api/classes/Lecturer.php';
require_once 'api/classes/Project.php';
require_once 'api/sendMessage.php';
require_once 'api/classes/Student.php';
require_once 'api/classes/UploadCategory.php';
require_once 'api/classes/Upload.php';

$conn = Database::getInstance();
$uc = new UploadCategory($conn);
$up = new Upload($conn);
$uc->setCatId(1);

//echo json_encode($uc->hasUpload(1,2));
//echo json_encode($uc->getStudentCategoryUpload(2,1));

$project = new Project($conn);
$student = new Student($conn);
//$lec = new Lecturer($conn);
$student->setUsername('SB30/PU/41760/16');
$student->setPassword('9641');
//$lecDetails =  $lec->getUser();
//echo $lecDetails['coordinator'];
//echo (strtotime(date('Y-m-d')) - strtotime('2020-04-27'))/60/60/24;
var_dump($project->statusUpdate(1,0));
$me = 0;
var_dump(isset($me));
//mkdir('60/');
//echo json_encode($student->verifyUser());
//echo json_encode($project->viewAllProjects());
//function extractIds($project){
//    return $project['id'];
//}
//$assignedArrIds = array_map('extractIds', $project->getLecurerProjects('12345'));
//echo json_encode($assignedArrIds);
//$removedProjects = array_diff($assignedArrIds,['1','3', '5']);
//echo json_encode($removedProjects);
//$student->setUsername('SB30/PU/41760/16');
//if (!$project->studentHasProject()){
//    $conn->beginTransaction();
//    $desc = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
//tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
//quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
//consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
//cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
//proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
//    if ($project->addProject('Church Management System', $desc, 1, '','')){
//        $conn->commit();
//        echo json_encode(['message'=>'added successfully']);
//    }else{
//
//        echo json_encode(['message'=>'not added']);
//        $conn->rollBack();
//    }
//}else{
//    echo json_encode($project->viewStudentProject($project->getRegNo()));
//}
//echo json_encode($project->isAssignedToMe(8, '12345'));
//echo json_encode($student->getUser());
//$lec = new Lecturer($conn);
//echo json_encode($lec->getAllUsers());
//echo json_encode($student->getAllUsers());
//$conn->beginTransaction();
//var_dump($student->saveUser('SB30/PU/41769/16','JAMES MURIITHI','muriithijames506@gmail.com','0746792699'));
//print_r($conn->errorInfo());
//$student->setRegNo('SB30/PU/41760/16');
//var_dump($student->emailExists('muriithijames556@gmail.com'));
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
//$user = new User($conn);
//$user->setUsername('SB30/PU/41760/16');
//print_r($user->getLevel());
//print_r($user->generateOTP());
//var_dump(@fsockopen('www.google.com',80));
$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
</head>
<body style="
        padding:0px !important;
        margin:0px !important;
        width: 100%;
    ">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
            <td class="container" width="600" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
                <div class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="alert alert-warning" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #3c4ccf; margin: 0; padding: 20px;" align="center" bgcolor="#71b6f9" valign="top">
                                Reset Your Password
                            </td>
                        </tr>
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
                                <table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                            Your one time password is:
                                        </td>
                                    </tr>
                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 20px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align: center;" valign="top">
                                            <b style="font-weight: 900;font-size: 20px;">123456</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block" style="font-style:italic; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                            You are receiving this email because you requested to change your password.
                                        </td>
                                    </tr>
                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 10px;" valign="top">
                                            <b>FYPMS</b>
                                            <p>Support Team</p>
                                        </td>
                                    </tr>

                                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                        <td class="content-block" style="text-align: center;font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0;" valign="top">
                                            © 2020 FYPMS
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    </body>
    </html>';
//sendMail('muriithijames556@gmail.com',$msg, 'Password Reset', 'FYPMS');
