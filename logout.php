<?php
session_start();
require_once 'backend/class.user.php';
$user = new User();

if(!$user->is_logged_in())
{
	$user->redirect('index.php');
}

if($user->is_logged_in()!="")
{
	$user->logout();	
	$user->redirect('index.php');
}
?>