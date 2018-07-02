<?php
session_start();
require_once 'class.user.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
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
    <div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Enter child Details</h1></div><br>
        <div class="row" >
            <!-- left panel -->
            <?php include('includes/left-panel.php'); ?>
            <!-- //left panel -->
            <!-- right panel -->
            <div class="col-md-9">

                <h3 align="center">Enter Child Details</h3>
                <br /><br />
                <div class='form-group'>
                    <label for='disabledInputEmail'>Parent Name</label>
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

                <label>Child Name</label>
                <input type="text" name="childname" id="childname" class="form-control"/>
                <br />

                <label>Gender</label>
                <select id="genderEdit" name="genderEdit" required class="form-control">
                    <option value="" >Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
                <br />
                <label>Birthday</label>
                <input type="date" name="birthday" id="birthday" class="form-control"/>
                <br />
                <label>Mobile</label>
                <input type="tel" pattern='[0-9]{10}' placeholder="07XXXXXXXX" name="phone" id="phone" class="form-control"/>
                <br />
                <label>Land Phone Number</label>
                <input type="tel" pattern='[0-9]{10}' placeholder="021XXXXXXX" name="phone" id="phone" class="form-control"/>
                <br/>

                <label>Address</label>
                <input type="text" name="address" id="address" class="form-control"/>
                <br />


            </div>
            <!-- right panel -->
        </div>
    </div>
</div>
<!-- footer -->
<?php include('includes/footer.php'); ?>
<!-- //footer -->
<?php include('includes/bottom-footer.php'); ?>

