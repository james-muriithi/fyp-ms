<?php
header('Access-Control-Allow-Origin: http://localhost/fyp_ms/');
header('Access-Control-Allow-Methods: POST');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../api/classes/NotificationsManager.php';
require_once '../api/classes/Notification.php';
require_once '../api/classes/NewUploadNotification.php';
require_once '../api/classes/NotificationAdapter.php';
require_once '../api/classes/User.php';
require_once  '../api/classes/NewCategoryNotification.php';
require_once  '../api/classes/NewUpdateNotification.php';
require_once  '../api/classes/ProjectUpdateNotification.php';
