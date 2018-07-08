<?php
session_start();
require_once '../class.user.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
$user_login = new USER();

if(!$user_login->is_logged_in())
{
    $user_login->redirect('index.php');
}

//Restrict Access
if($_SESSION['userRole']!= "Parent"){
    $user_login->redirect('index.php');
}

$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$userid = $row['userID'];
$msgsuccess = '';

$stmt = $user_login->runQuery("SELECT * FROM student_guardian WHERE userID=:userid");
$stmt->execute(array(":userid" => $userid));
$row1 = $stmt->fetch(PDO::FETCH_ASSOC);
$parentName = '';
$gender = 'Gender';
$address = '';
$mobile = '';
$phone = '';

if ($stmt->rowCount() > 0) {
    $parentName = $row1['parentName'];
    $gender = $row1['gender'];
    $address = $row1['address'];
    $mobile = $row1['mobile'];
    $phone = $row1['phone'];
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if(isset($_POST['btn-submitinfo'])){
    $Err ="";
    $pname = test_input($_POST['parentname']);
    $gender = test_input($_POST['genderEdit']);
    $mobile = test_input($_POST['txtmobile']);
    $phone = test_input($_POST['phone']);
    $address = test_input($_POST['address']);
    $gender1=$gender;

    if ( empty($pname) || !preg_match("/^[a-zA-Z ]*$/",$pname) ) {
        $Err = "Invalid name, only letters and white spaces allowed";
    }
    elseif( empty($gender) || $gender="" ) {
        $Err = "Please select gender";
    }
    elseif( !preg_match('(Male|Female)', $gender) === 1 ) {
        $Err = "Invalid gender";
    }
    elseif( empty($mobile) || !preg_match("/^[0-9]{10}$/", $mobile) ){
        $Err = "Invalid mobile number format 07X XXX XXXX";
    }
    elseif( empty($phone) || !preg_match("/^[0-9]{10}$/", $phone) ){
        $Err = "Invalid phone number format 07X XXX XXXX";
    }
    elseif ( empty($address) || strlen($address)<5 || strlen($address)>200) {
        $Err = "Invalid address, length should be between 5 and 200 characters";
    }

    if($Err!=""){
        //if error msg found in registration form don't save to database
        $msg = "
		      <div class='alert alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry !</strong> ".$Err."
			  </div>
			  ";
    }else {
        //if no error msg found in the registration form
        if ($stmt->rowCount() > 0) {

            if ($_SERVER["REQUEST_METHOD"]=="POST"){

                $sql = "UPDATE student_guardian SET studentName=? ,parentName=? ,gender=? ,address=? , mobile=? , phone=? WHERE userID=?";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param('ssssiii' ,  $studentName,$parentName,$gender, $address, $mobile, $phone, $userID );
                $userID = $row['userID'];
                $studentName = $row['userName'];
                $parentName = $_POST["parentname"];
                $gender = $_POST["genderEdit"];
                $address = $_POST["address"];
                $mobile = $_POST["txtmobile"];
                $phone = $_POST["phone"];
                $stmt->execute();
                $stmt->close();

                //echo "Success ! data updated.";
                /*$msgsuccess = "
		            <div class='alert alert-danger'>
				        <button class='close' data-dismiss='alert'>&times;</button>
					        <strong>Success !</strong>  data updated.
			        </div>
			        ";*/
                $user_login->redirect('parentinfo.php?q=success');
            }

        } else {

            if ($_SERVER["REQUEST_METHOD"]=="POST"){

                $stmt = $connect->prepare("INSERT INTO student_guardian(userID ,studentName ,parentName,gender ,address , mobile, phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param('issssii', $userID , $studentName, $parentName,$gender, $address, $mobile, $phone );
                $userID = $row['userID'];
                $studentName = $row['userName'];
                $parentName = $_POST["parentname"];
                $gender = $_POST["genderEdit"];
                $address = $_POST["address"];
                $mobile = $_POST["txtmobile"];
                $phone = $_POST["phone"];
                $stmt->execute();
                $stmt->close();
                //echo "Success ! data saved.";
                /*$msgsuccess = "
		            <div class='alert alert-danger'>
				        <button class='close' data-dismiss='alert'>&times;</button>
					        <strong>Success !</strong>  data saved.
			        </div>
			        ";*/
                $user_login->redirect('parentinfo.php');
            }

        }
    }

}
?>

<!-- top html header -->
<?php include('../includes/top-header.php'); ?>
<!-- //top html header -->
<!-- header -->
<?php include('../includes/header.php'); ?>
<!-- //header -->
<div style="min-height: calc(100vh - 190px); margin-top: 1em; margin-bottom:3em;">
    <div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Parent Information Form</h1></div><br>
        <div class="row" >
            <!-- left panel -->
            <?php include('../includes/left-panel.php'); ?>
            <!-- //left panel -->
            <!-- right panel -->
            <div class="col-md-9">

                <h3 align="center">Enter Parent Details</h3>
                <form action="#" method="post">
                    <?php if(isset($msg)) echo $msg;  ?>
                    <?php if(isset($_GET["q"]) && ($_GET["q"]=="success")){echo $msgsuccess;}
			        ?>
                    <br /><br />
                    <div class='form-group'>
                        <label for='disabledInputEmail'>Student Name</label>
                        <input class='form-control' id='disabledInputuserName' type='text' value='<?php echo $row['userName']; ?>' disabled >
                    </div>
                    <br />
                    <div class='form-group'>
                        <label for='disabledInputEmail'>Email address</label>
                        <input class='form-control' id='disabledInputEmail' type='email' value='<?php echo $row['userEmail']; ?>' disabled>
                    </div>
                    <br />

                    <div class='form-group'>
                        <label for='disabledInputUserRole'>User Role</label>
                        <input class='form-control' id='disabledInputUserRole' type='text' value='<?php echo $row['userRole']; ?>' disabled>
                    </div>
                    <br />

                    <div class='form-group'>
                        <label for='disabledInputUserID'>User ID</label>
                        <input class='form-control' id='disabledInputUserID' type='text' value='<?php echo $row['userID']; ?>' disabled>
                    </div>
                    <br />

                    <label>Parent Name</label>
                    <input type="text" name="parentname" pattern=".{5,100}" placeholder="5 to 100 characters" value='<?php echo $parentName; ?>' required="" id="parentname" class="form-control"/>
                    <br />

                    <label>Parent Gender</label>
                    <select id="genderEdit" name="genderEdit" required="" class="form-control">

                        <option <?php if($gender=="Male"){echo"selected";}?> value="Male">Male</option>
                        <option <?php if($gender=="Female"){echo"selected";}?>value="Female">Female</option>
                    </select>
                    <br />
                    <label>Mobile</label>
                    <input id="txtmobile" class="form-control" type="tel" pattern='[0-9]{10}' name="txtmobile" required="" value='<?php echo $mobile; ?>' placeholder="0XX XXX XXX" >
                    <br />
                    <label>Land Phone Number</label>
                    <input type="tel"  pattern='[0-9]{10}' placeholder="0XX XXX XXXX" name="phone" id="phone" required="" value='<?php echo $phone; ?>' class="form-control"/>
                    <br/>

                    <label>Address</label>
                    <input type="text"  name="address" pattern=".{5,200}" placeholder="5 to 200 characters" required="" value='<?php echo $address; ?>' id="address" class="form-control"/>
                    <br />

                    <br /><br />

                    <div align="center">
                    <input type="submit" name="btn-submitinfo" >
                    </div>

                </form>
                <br />
                <br />
                <div id="result" class="table-responsive" style="border: none;"></div>

            </div>
            <!-- right panel -->
        </div>
    </div>
</div>

<!-- footer -->
<?php include('../includes/footer.php'); ?>
<!-- //footer -->
<?php include('../includes/bottom-footer.php'); ?>

