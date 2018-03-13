<?php 
echo"<style>
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
";
if($_SESSION['userRole']=="Parent"){
	echo'<div class="col-md-3 wthree_footer_grid_left1 ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/leave.php">Leave Request</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/messages.php">Messages</a></li>					
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/appointments.php">Appointments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Teacher"){
	echo'<div class="col-md-3 wthree_footer_grid_left1 ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/leave.php">Leave Request</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/childdetails.php">Child Details</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/messages.php">Messages</a></li>					
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/appointments.php">Appointments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Principal"){
	echo'<div class="col-md-3 wthree_footer_grid_left1 ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/leave.php">Leave Request</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/enrollments.php">Enrollments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/childdetails.php">Child Details</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/messages.php">Messages</a></li>					
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/appointments.php">Appointments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Admin"){
	echo'<div class="col-md-3 wthree_footer_grid_left1 ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/enrollments.php">Enrollments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/childdetails.php">Child Details</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/messages.php">Messages</a></li>					
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/logout.php">Log Out</a></li>
				</ul>
			</div>';
}?>
			