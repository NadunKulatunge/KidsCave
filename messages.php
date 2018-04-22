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
<!-- header -->
<?php include('includes/header.php'); ?>
<!-- //header -->
<div style="min-height: calc(100vh - 190px); margin-top: 1em; margin-bottom:3em;">
	<div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Messages</h1></div><br>
		<div class="row" >
			<!-- left panel -->
			<?php include('includes/left-panel.php'); ?>
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





