<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/class.user.php');
$user_login = new User();
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/appointments.php');

$stmt = $user_login->runQuery("DELETE FROM teacher_appointment WHERE appointmentDateTime < NOW()");
$stmt->execute();
if ($stmt->rowCount()> 0) 
	{
		echo "expired Records deleted successfully";
	}



?> 