<?php
require_once 'api/config/database.php';
require_once 'api/classes/Student.php';

$conn = Database::getInstance();
$student = new Student($conn);
//$conn->beginTransaction();
echo $student->saveUser('SB30/PU/41760/16','JAMES MURIITHI','muriithijames556@gmail.com','0746792699','0000');