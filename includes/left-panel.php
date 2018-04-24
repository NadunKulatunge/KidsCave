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

.left_panel_menu ul li a:hover {
	color: black;
}
.left_panel_menu ul li{
	list-style-type:none;
	text-transform:uppercase;
	color:#fa3d03;
	margin-bottom:1em;
}
.left_panel_menu ul li i{
	padding-right:1em;
}
.left_panel_menu ul li:last-child,.wthree_footer_grid_right1 ul li:last-child{
	margin:0;
}
.left_panel_menu ul li a,.wthree_footer_grid_right1 ul li a{
	color:#212121;
	text-decoration:none;
}

.box > a:hover, .box > a:focus {
    text-decoration: none;
    background-color: #14a1ff;
}
</style>
";
if($_SESSION['userRole']=="Parent"){
	echo'<div class="col-md-3 left_panel_menu ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/leave.php">Leave Request</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/messages.php">Announcements</a></li>					
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/appointments.php">Appointments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Teacher"){
	echo'<div class="col-md-3 left_panel_menu ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/leave.php">Leave Request</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/backend/payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/childdetails.php">Child Details</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/messages.php">Announcements</a></li>					
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/appointments.php">Appointments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Principal"){
	echo'<div class="col-md-3 left_panel_menu">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/leave.php">Leave Request</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/backend/payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/backend/enrollments.php">Enrollments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/childdetails.php">Child Details</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/messages.php">Announcements</a></li>					
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Admin"){
	echo'<div class="col-md-3 left_panel_menu ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/profile.php">Profile</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/backend/timetable.php">TimeTable</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/attendance.php">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/backend/payments.php">Payments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/backend/enrollments.php">Enrollments</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/childdetails.php">Child Details</a></li>
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/messages.php">Announcements</a></li>					
					<li role="presentation" class="box"><a href="'.SCRIPT_ROOT.'/logout.php">Log Out</a></li>
				</ul>
			</div>';
}?>
			