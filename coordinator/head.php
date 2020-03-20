<?php
session_start();
include_once '../api/config/database.php';
include_once '../api/classes/Lecturer.php';
include_once '../api/classes/User.php';

$conn = Database::getInstance();

if (!isset($_SESSION['login'],$_SESSION['username'], $_SESSION['level'])) {
    $_SESSION['error'] = 'You are not authorized to access that page. Please login';
    header('Location: ../index.php');
    die();
}

$lec = new Lecturer($conn);
$lec->setUsername($_SESSION['username']);

if (!$lec->userExists($_SESSION['username'])){
    $_SESSION['error'] = 'You are not authorized to access that page. Please login';
    header('Location: ../index.php');
    die();
}
$lecDetails = $lec->getUser();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>FYPMS | Final Year Project Management System</title>
    <!-- meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#25274d">
    <meta name="description" content="A final year project management system for pwani university">
    <meta name="author" content="James Muriitih">
    <meta name="keywords" content="fyp,fypms, final year project">
    <meta property="og:site_name" content="google.com">
    <meta property="og:title" content="Final Year Project Management System" />
    <meta property="og:description" content="A final year project management system for pwani university made by james muriithi" />
    <meta property="og:image:url" itemprop="image" content="https://james-muriithi.github.io/fyp-ms/assets/images/logo-lg.png">
    <meta property="og:image" content="https://james-muriithi.github.io/fyp-ms/assets/images/logo-lg.png" />
    <meta property="og:image:url" content="https://james-muriithi.github.io/fyp-ms/assets/images/logo-lg.png" />
    <meta property="og:image:secure_url" content="https://james-muriithi.github.io/fyp-ms/assets/images/logo-lg.png" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="400" />
    <meta property="og:locale" content="en_GB" />
    <meta property="og:type" content="website" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link href="../assets/libs/chartist/chartist.min.css" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <!-- aniamte css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/animate.css">
    <!-- Sweet Alert-->
    <link href="../assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- util css -->
    <link rel="stylesheet" type="text/css" href="../assets/css/util.css">
    <!-- style -->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>