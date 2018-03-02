<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if(!$user_login->is_logged_in())
{
	$user_login->redirect('index.php');
}

$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!-- top html header -->
<?php include('includes/top-header.php'); ?>
<!-- //top html header -->
<style>
.box {
	border:2px solid #14a1ff;
}
.box:hover{
	background-color:#14a1ff;
}
.box:focus{
	background-color:#14a1ff;
}
.wthree_footer_grid_left1 ul li a:hover {
	color: black;
}
.box > a:hover, .box > a:focus {
    text-decoration: none;
    background-color: #14a1ff;
}
</style>
<!-- header -->
<?php include('includes/header.php'); ?>
<!-- //header -->
<div style="min-height: calc(100vh - 190px); margin-top: 1em; margin-bottom:3em;">
	<div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Profile</h1></div><br>
		<div class="row" >
			<!-- left panel -->
			<div class="col-md-3 wthree_footer_grid_left1 ">
			<ul class="nav nav-pills nav-stacked">
				<li role="presentation" class="box"><a href="#">Profile</a></li>
				<li role="presentation" class="box"><a href="#">Leave Request</a></li>
				<li role="presentation" class="box"><a href="#">Payments</a></li>
				<li role="presentation" class="box"><a href="#">Messages</a></li>
				<li role="presentation" class="box"><a href="#">Student Attendance</a></li>
				<li role="presentation" class="box"><a href="#">Settings</a></li>
				<li role="presentation" class="box"><a href="logout.php">Log Out</a></li>
			</ul>
			</div>
			<!-- //left panel -->
			<!-- right panel -->
			<div class="col-md-9">.col-md-6</div>
			<!-- right panel -->
		</div>
	</div>
</div>
<!-- footer -->
<?php include('includes/footer.php'); ?>
<!-- //footer -->
<?php include('includes/bottom-footer.php'); ?>