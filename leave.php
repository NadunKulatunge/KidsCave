<?php
session_start();
require_once 'backend/class.user.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
$user_login = new USER();

if(!$user_login->is_logged_in())
{
	$user_login->redirect('index.php');
}

$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$userID = $row['userID'];

if ($_SESSION['userRole']!="Admin"){
    $sqli = "SELECT userID FROM tbl_users WHERE userID='".$userID."'";
    $rslt = mysqli_query($connect,$sqli);
    if (mysqli_num_rows($rslt)>0){
        $row2 = mysqli_fetch_array($rslt);
        $userID = $row2['userID'];
    }
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $stmt = $connect->prepare("INSERT INTO leave_user(userID ,name,role ,date , reason) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $userID , $name,$role,$timestamp,$reason );
    $date = $_POST["date"];
    $timestamp = date('Y-m-d', strtotime($date));
    $reason = $_POST["reason"];
    $name = $row['userName'];
    $role = $row['userRole'];
    $stmt->execute();
    $stmt->close();
    $user_login->redirect('leave.php?q=success');
}
?>
<!-- top html header -->
<?php include('includes/top-header.php'); ?>
<!-- //top html header -->
<!-- header -->
<?php include('includes/header.php'); ?>
<!-- //header -->
<div style="min-height: calc(100vh - 190px); margin-top: 1em; margin-bottom:3em;">
	<div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Leave Request</h1></div><br>
		<div class="row" >
			<!-- left panel -->
			<?php include('includes/left-panel.php'); ?>
			<!-- //left panel -->
			<!-- right panel -->
			<div class="col-md-9">
                <?php if(isset($_GET["q"]) && ($_GET["q"]=="success")){
                    echo '<div class=\'alert alert-success\'>
	                        <button class=\'close\' data-dismiss=\'alert\'>&times;</button>
		                    <strong>Leave request has been sent!</strong>
                        </div>';
                }
                ?>
            <div>
                <?php if ($_SESSION['userRole']=="Teacher" || $_SESSION['userRole']=="Admin" || $_SESSION['userRole']=="Parent" ){?>
                    <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ;?>" method="post" >
                        <div class='form-group'>
                            <label for='disabledInputEmail'>Your Are Logged in as</label>
                            <input class='form-control' name='name' id='name' type='text' value="<?php echo $row['userName']?>" disabled>
                        </div>
                        <div class='form-group'>
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="<?php if(isset($date)){echo $date;} ?>" placeholder="Date of Leave" required="" max="<?php echo date("Y-m-d",strtotime("4 years")); ?>" min="<?php echo date("Y-m-d",strtotime("-1 months")); ?>">
                        </div>
                        <div class='form-group'>
                            <label> Reason to leave </label><br/>
                            <textarea type='text'  class='form-group' name='reason' id='reason'  placeholder='type your message here...' style="height:150px ; width:900px ;resize:none ; margin:auto" required=""maxlength="500"  minlength="5""></textarea>
                        </div>
                        <button type='submit' class='btn btn-primary' style="width:50%; display:block ; margin:auto" > Send </button><br>
                    </form>
                    <div style =" border-bottom:2px solid #14a1ff;"><h2>Recent Messages</h2></div><br>
                    <div class="box1" name="recentMesseges" id="recentMesseges" style="border: thin solid black" >
                        <div class="col-xs-6">
                            <?php
                            $sql = ("SELECT name,role,date,reason,principalApprove FROM leave_user WHERE userID='".$userID."'");
                            $result = mysqli_query($connect,$sql);
                            if (mysqli_num_rows($result)>0){
                                $messages=array();
                                while($row3 = mysqli_fetch_assoc($result)){
                                    $responce = '';
                                    if ($row3['principalApprove']==1){
                                        $responce = "APPROVED";
                                    }elseif($row3['principalApprove']==NULL){
                                        $responce = "DECISION PENDING .. ";
                                    }elseif($row3['principalApprove']==0){
                                        $responce = "REJECTED";
                                    }
                                    $messages[]= "name : ".$row3['name']."<br>role : ".$row3['role']."<br>date : ".$row3['date']."<br> reason : ".$row3['reason']."<br>responce : ".$responce."<br>";
                                }
                                $messages = array_reverse($messages);
                                foreach ($messages as $value){
                                    echo $value;
                                    echo "<hr><br>";
                                }
                            }else{
                                echo "no recent messages";
                            }
                            ?>
                        </div>
                    </div>
                    <?php ;} ?>
            </div>
        </div>
        </div>
			<!-- right panel -->
		</div>
	</div>
</div>



<!-- footer -->
<?php include('includes/footer.php'); ?>
<!-- //footer -->
<?php include('includes/bottom-footer.php'); ?>