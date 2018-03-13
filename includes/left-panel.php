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
					<li role="presentation" class="box"><a href="profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="leave.php">Leave Request</a></li>
					<li role="presentation" class="box"><a href="payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="messages.php">Messages</a></li>					
					<li role="presentation" class="box"><a href="appointments.php">Appointments</a></li>
					<li role="presentation" class="box"><a href="logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Teacher"){
	echo'<div class="col-md-3 wthree_footer_grid_left1 ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="leave.php">Leave Request</a></li>
					<li role="presentation" class="box"><a href="payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="childdetails.php">Child Details</a></li>
					<li role="presentation" class="box"><a href="messages.php">Messages</a></li>					
					<li role="presentation" class="box"><a href="appointments.php">Appointments</a></li>
					<li role="presentation" class="box"><a href="logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Principal"){
	echo'<div class="col-md-3 wthree_footer_grid_left1 ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="leave.php">Leave Request</a></li>
					<li role="presentation" class="box"><a href="payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="enrollments.php">Enrollments</a></li>
					<li role="presentation" class="box"><a href="childdetails.php">Child Details</a></li>
					<li role="presentation" class="box"><a href="messages.php">Messages</a></li>					
					<li role="presentation" class="box"><a href="appointments.php">Appointments</a></li>
					<li role="presentation" class="box"><a href="logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Admin"){
	echo'<div class="col-md-3 wthree_footer_grid_left1 ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="enrollments.php">Enrollments</a></li>
					<li role="presentation" class="box"><a href="childdetails.php">Child Details</a></li>
					<li role="presentation" class="box"><a href="messages.php">Messages</a></li>					
					<li role="presentation" class="box"><a href="logout.php">Log Out</a></li>
				</ul>
			</div>';
}?>
			