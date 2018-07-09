<?php
session_start();
require_once ($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/class.user.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
$user_login = new User();

if(!$user_login->is_logged_in())
{
	$user_login->redirect($_SERVER['DOCUMENT_ROOT'].'/KidsCave/index.php');
}

$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$userID = $row['userID'];
$teacherID = $userID ;


if($_SESSION['userRole']=="Parent")
{
	$stmt = $user_login->runQuery("SELECT classID FROM tbl_users WHERE userID=:userID");
	$stmt->execute(array(":userID"=>$userID));
	$row2 = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($stmt->rowCount()>0)
	{
		$classID = $row2['classID'];
	}
}

?>
<?php
if ($_SERVER["REQUEST_METHOD"]=="POST")
{
		$classid = $_POST["classid"];
		$message = $_POST["announcement"];
	
		$stmt = $user_login->runQuery("INSERT INTO class_announcement(announcement, teacherID, classID) VALUES(:message, :teacherID, :classID)");
		$stmt->bindparam(":message",$message);
		$stmt->bindparam(":teacherID",$teacherID);
		$stmt->bindparam(":classID",$classid);
		$stmt->execute();
		echo "<script> alert('announcement sent succesfuly');</script>";
}	
?>

<!-------- functions for tables ----->
<?php

function getTeacherTable($teacherID,$user_login)
{
	$stmt = $user_login->runQuery("SELECT announcement,timestamp,classID FROM class_announcement WHERE teacherID=:teacherID");
	$stmt->execute(array(":teacherID"=>$teacherID));
	
	if ($stmt->rowCount()>0)
	{
		while ($row3 = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$date = date('Y-m-d',strtotime($row3['timestamp']));
			$time = date('H:i',strtotime($row3['timestamp']));
			$messages[]= "date : ".$date."<br>time : ".$time."<br>classID : ".$row3['classID']."<br> Announcement : ".$row3['announcement']."<br>";
		}
		$messages = array_reverse($messages);
		foreach ($messages as $value)
		{
			echo $value;
			echo "<hr><br>";
		}
	}else
	{
		echo "no recent messages";
	}
}

function getParentTable($classID,$user_login){
	$stmt = $user_login->runQuery("SELECT announcement,timestamp,teacherID,classID FROM class_announcement WHERE classID=:classID");
	$stmt->execute(array(":classID"=>$classID));
	
	if ($stmt->rowCount()>0)
	{
		while ($row3 = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$date = date('Y-m-d',strtotime($row3['timestamp']));
			$time = date('H:i',strtotime($row3['timestamp']));
			$messages[]= "date : ".$date."<br>time : ".$time."<br>teacherID :".$row3['teacherID']."<br>classID : ".$row3['classID']."<br> Announcement : ".$row3['announcement']."<br>";
		}
		$messages = array_reverse($messages);
		foreach ($messages as $value)
		{
			echo $value;
			echo "<hr><br>";
		}
	}else
	{
		echo "no recent messages";
	}
	
}

function getAllTable($user_login){
	$stmt = $user_login->runQuery("SELECT announcement,timestamp,teacherID,classID FROM class_announcement");
	$stmt->execute(array());
	
	if ($stmt->rowCount()>0)
	{
		while ($row3 = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$date = date('Y-m-d',strtotime($row3['timestamp']));
			$time = date('H:i',strtotime($row3['timestamp']));
			$messages[]= "date : ".$date."<br>time : ".$time."<br>teacherID :".$row3['teacherID']."<br>classID : ".$row3['classID']."<br> Announcement : ".$row3['announcement']."<br>";
		}
		$messages = array_reverse($messages);
		foreach ($messages as $value)
		{
			echo $value;
			echo "<hr><br>";
		}
	}else
	{
		echo "no recent messages";
	}
	
}
?>


<!-- top html header -->
<?php include($_SERVER['DOCUMENT_ROOT'].'/KidsCave/includes/top-header.php'); ?>
<!-- //top html header -->
<!-- header -->
<?php include($_SERVER['DOCUMENT_ROOT'].'/KidsCave/includes/header.php'); ?>
<!-- //header -->
<div style="min-height: calc(100vh - 190px); margin-top: 1em; margin-bottom:3em;">
	<div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Messages</h1></div><br>
		<div class="row" >
			<!-- left panel -->
			<?php include($_SERVER['DOCUMENT_ROOT'].'/KidsCave/includes/left-panel.php'); ?>
			<!-- //left panel -->
			<!-- right panel -->
			<div class="col-md-9" id ="form1">
				<!---- teacher------------------------------------------------------------------------------------>
				<div>
				<?php if ($_SESSION['userRole']=="Teacher"){?>
					<form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ;?>" method="post" >
						<div class='form-group'>
								<label for='disabledInputEmail'>Your Are Logged in as</label>
								<input class='form-control' name='teacherName' id='teacherName' type='text' value="<?php echo $row['userName']?>" disabled>
						</div>
						<div class='form-group'>
							<label> Enter class id </label>
							<input type='number' class='form-contol' name= 'classid' id='classid' placeholder='class id' min="1" max="20" required >
						</div>
						<div class='form-group'>
							<label> Enter the Announcement </label><br/>
							<textarea type='text' class='form-group' name='announcement' id='announcement' placeholder='type your message here' style="height:150px ; width:850px ;resize:none ; margin:auto" required></textarea>
						</div>
						<input style='display:none' name='submit_form' value='teacher'>
						<button type='submit' class='btn btn-primary' style="width:50%; display:block ; margin:auto" onclick="sentAlert('classid','announcement');"> Send </button><br>
					</form>
					<div style =" border-bottom:2px solid #14a1ff;"><h2>Recent Messages</h2></div><br>
					<div class="box1" name="recentMesseges" id="recentMesseges" style="border: thin solid black" > 
						<div class="col-xs-6">
						
							<?php getTeacherTable($teacherID,$user_login);?>
							
						</div>
					</div>
				<!---- parent------------------------------------------------------------------------------------>	
				<?php ;}
					elseif($_SESSION['userRole']=="Parent"){?>
					<div class='form-group'>
						<label for='disabledInputEmail'>Your Are Logged in as</label>
						<input class='form-control' name='Name' id='Name' type='text' value="<?php echo $row['userName']?>" disabled>
					</div>
					<div class="box2" name="Messeges" id="Messeges" style="border: thin solid black" > 
						<div class="col-xs-6">
						
							<?php getParentTable($classID,$user_login);?>
								
						</div>
					</div>
				<!---- admin/principal------------------------------------------------------------------------------------>
				<?php ;}
					elseif ($_SESSION['userRole']=="Admin" || $_SESSION['userRole']=="Principal" ){ ?>
						<div class='form-group'>
							<label for='disabledInputEmail'>Your Are Logged in as</label>
							<input class='form-control' name='Name' id='Name' type='text' value="<?php echo $row['userName']?>" disabled>
						</div>
						<div class="box2" name="recentMesseges" id="recentMesseges" style="border: thin solid black" > 
						<div class="col-xs-6">
							
							<?php getAllTable($user_login);?>
						
						</div>
					</div>
				<?php ;} ?>
				</div>
			</div>
			<!-- right panel -->
		</div>
	</div>
</div>

<script>
function sentAlert(id1,id2) {
	var a = document.getElementById(id1).value;
	var b = document.getElementById(id2).value;
	if (a == "" || b == ""){
	alert("please fill all the fileds correctly");
	} 
}
function showElement(id){
	var a = document.getElementsById(id);
	if (a.style.display==="none"){
		a.style.display="block";
	}else {
		a.style.display="none";
	}
		
}
</script>
<!-- footer -->
<?php include($_SERVER['DOCUMENT_ROOT'].'/KidsCave/includes/footer.php'); ?>
<!-- //footer -->
<?php include($_SERVER['DOCUMENT_ROOT'].'/KidsCave/includes/bottom-footer.php'); ?>
