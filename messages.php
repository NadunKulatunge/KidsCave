<?php
session_start();
require_once 'backend/class.user.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
$user_login = new User();

if(!$user_login->is_logged_in())
{
	$user_login->redirect('index.php');
}

$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$userID = $row['userID'];

if ($_SESSION['userRole']=="Teacher"){
	$sqli = "SELECT teacherID FROM teacher WHERE userID='".$userID."'";
	$rslt = mysqli_query($connect,$sqli);
	if (mysqli_num_rows($rslt)>0){
		$row2 = mysqli_fetch_array($rslt);
		$teacherID = $row2['teacherID'];
	}
}elseif($_SESSION['userRole']=="Parent"){
	$sqli = "SELECT studentID FROM student_guardian WHERE userID='".$userID."'";
	$rslt = mysqli_query($connect,$sqli);
	if (mysqli_num_rows($rslt)>0){
		$row2 = mysqli_fetch_array($rslt);
		$studentID = $row2['studentID'];
	}
	$sqli = "SELECT classID FROM student WHERE studentID='".$studentID."'";
	$rslt = mysqli_query($connect,$sqli);
	if (mysqli_num_rows($rslt)>0){
		$row2 = mysqli_fetch_array($rslt);
		$classID = $row2['classID'];
	}
}

?>
<?php
if ($_SERVER["REQUEST_METHOD"]=="POST"){

	$stmt = $connect->prepare("INSERT INTO class_announcement(announcement ,teacherID , classID) VALUES (?, ?, ?)");
	$stmt->bind_param("sii", $message , $teacherID, $classid);
	$classid = $_POST["classid"];
	$message = $_POST["announcement"];
	$stmt->execute();
	$stmt->close();
	}	
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
			<div class="col-md-9" id ="form1">
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
							<textarea type='text' class='form-group' name='announcement' id='announcement' placeholder='type your message here' style="height:150px ; width:900px ;resize:none ; margin:auto" required></textarea>
						</div>
						<button type='submit' class='btn btn-primary' style="width:50%; display:block ; margin:auto" onclick="sentAlert('classid','announcement');"> Send </button><br>
					</form>
					<div style =" border-bottom:2px solid #14a1ff;"><h2>Recent Messages</h2></div><br>
					<div class="box1" name="recentMesseges" id="recentMesseges" style="border: thin solid black" > 
						<div class="col-xs-6">
							<?php
								$sql = ("SELECT announcement,timestamp,classID FROM class_announcement WHERE teacherID='".$teacherID."'");
								$result = mysqli_query($connect,$sql);
								if (mysqli_num_rows($result)>0){
									$messages=array();
									while($row3 = mysqli_fetch_assoc($result)){
										$date = date('Y-m-d',strtotime($row3['timestamp']));
										$time = date('H:i',strtotime($row3['timestamp']));
										$messages[]= "date : ".$date."<br>time : ".$time."<br>classID : ".$row3['classID']."<br> Announcement : ".$row3['announcement']."<br>";
									}
									$messages = array_reverse($messages);
									foreach ($messages as $value){
										echo $value;
										echo "----------------------------------------------------------------<br>";
									}
								}else{
									echo "no recent messages";
								}
							?>
						</div>
					</div>
				<?php ;}
					elseif($_SESSION['userRole']=="Parent"){?>
					<div class='form-group'>
						<label for='disabledInputEmail'>Your Are Logged in as</label>
						<input class='form-control' name='Name' id='Name' type='text' value="<?php echo $row['userName']?>" disabled>
					</div>
					<div class="box2" name="Messeges" id="Messeges" style="border: thin solid black" > 
						<div class="col-xs-6">
							<?php
								$sql = ("SELECT announcement,timestamp,classID FROM class_announcement WHERE classID='".$classID."'");
								$result = mysqli_query($connect,$sql);
								if (mysqli_num_rows($result)>0){
									$messages=array();
									while($row3 = mysqli_fetch_assoc($result)){
										$date = date('Y-m-d',strtotime($row3['timestamp']));
										$time = date('H:i',strtotime($row3['timestamp']));
										$messages[]= "date : ".$date."<br>time : ".$time."<br>classID : ".$row3['classID']."<br> Announcement : ".$row3['announcement']."<br>";
									}
									$messages = array_reverse($messages);
									foreach ($messages as $value){
										echo $value;
										echo "----------------------------------------------------------------<br>";
									}
								}else{
									echo "no messages to display";
								}
							?>
						</div>
					</div>
				<?php ;}
					elseif ($_SESSION['userRole']=="Admin" || $_SESSION['userRole']=="Principal" ){ ?>
						<div class='form-group'>
							<label for='disabledInputEmail'>Your Are Logged in as</label>
							<input class='form-control' name='Name' id='Name' type='text' value="<?php echo $row['userName']?>" disabled>
						</div>
						<div class="box2" name="recentMesseges" id="recentMesseges" style="border: thin solid black" > 
						<div class="col-xs-6">
							<?php
								$sql = ("SELECT announcement,timestamp,teacherID,classID FROM class_announcement");
								$result = mysqli_query($connect,$sql);
								if (mysqli_num_rows($result)>0){
									$messages=array();
									while($row3 = mysqli_fetch_assoc($result)){
										$date = date('Y-m-d',strtotime($row3['timestamp']));
										$time = date('H:i',strtotime($row3['timestamp']));
										$messages[]= "date : ".$date."<br>time : ".$time."<br>teacherID : ".$row3['teacherID']."<br>classID : ".$row3['classID']."<br> Announcement : ".$row3['announcement']."<br>";
									}
									$messages = array_reverse($messages);
									foreach ($messages as $value){
										echo $value;
										echo "----------------------------------------------------------------<br>";
									}
								}else{
									echo "no messages to display";
								}
							?>
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
	if (a != "" && b != ""){
	alert("message sent succesefully");
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
<?php $connect->close();?>
<!-- footer -->
<?php include('includes/footer.php'); ?>
<!-- //footer -->
<?php include('includes/bottom-footer.php'); ?>