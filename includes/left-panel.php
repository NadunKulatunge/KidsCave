<?php if($_SESSION['userRole']=="Parent"){
	echo'<div class="col-md-3 wthree_footer_grid_left1 ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="#">Profile</a></li>
					<li role="presentation" class="box"><a href="#">TimeTable</a></li>
					<li role="presentation" class="box"><a href="#">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="#">Leave Request</a></li>
					<li role="presentation" class="box"><a href="#">Payments</a></li>
					<li role="presentation" class="box"><a href="#">Messages</a></li>					
					<li role="presentation" class="box"><a href="#">Appointments</a></li>
					<li role="presentation" class="box"><a href="logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Teacher"){
	echo'<div class="col-md-3 wthree_footer_grid_left1 ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="#">Profile</a></li>
					<li role="presentation" class="box"><a href="#">TimeTable</a></li>
					<li role="presentation" class="box"><a href="#">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="#">Leave Request</a></li>
					<li role="presentation" class="box"><a href="#">Child Details</a></li>
					<li role="presentation" class="box"><a href="#">Messages</a></li>					
					<li role="presentation" class="box"><a href="#">Appointments</a></li>
					<li role="presentation" class="box"><a href="logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Principal"){
	echo'<div class="col-md-3 wthree_footer_grid_left1 ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="#">Profile</a></li>
					<li role="presentation" class="box"><a href="#">TimeTable</a></li>
					<li role="presentation" class="box"><a href="#">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="#">Leave Request</a></li>
					<li role="presentation" class="box"><a href="#">Enrollments</a></li>
					<li role="presentation" class="box"><a href="#">Child Details</a></li>
					<li role="presentation" class="box"><a href="#">Messages</a></li>					
					<li role="presentation" class="box"><a href="#">Appointments</a></li>
					<li role="presentation" class="box"><a href="logout.php">Log Out</a></li>
				</ul>
			</div>';
}elseif($_SESSION['userRole']=="Admin"){
	echo'<div class="col-md-3 wthree_footer_grid_left1 ">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="box"><a href="#">Profile</a></li>
					<li role="presentation" class="box"><a href="#">TimeTable</a></li>
					<li role="presentation" class="box"><a href="#">Student Attendance</a></li>
					<li role="presentation" class="box"><a href="#">Enrollments</a></li>
					<li role="presentation" class="box"><a href="#">Child Details</a></li>
					<li role="presentation" class="box"><a href="#">Messages</a></li>					
					<li role="presentation" class="box"><a href="logout.php">Log Out</a></li>
				</ul>
			</div>';
}?>
			