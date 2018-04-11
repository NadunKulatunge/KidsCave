<!--
author: W3layouts
author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function valid_date($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = str_replace("/","-",$data);
    $dateArray = explode("-",$data);
    if( !checkdate($dateArray[1],$dateArray[2],$dateArray[0]) ){
        //invalid date
        return false;
    }else{
        //valid date
        return true;
    }
}
if(isset($_POST['btn-login'])){

	$email = trim($_POST['txtemail']);
	$upass = trim($_POST['txtupass']);

	if($user_login->login($email,$upass)){
		$user_login->redirect('profile.php');
	}

}
if(isset($_POST['btn-signup'])){
    $Err ="";

	$uname = test_input($_POST['txtuname']);
	$email = test_input($_POST['txtemail']);
	$upass = test_input($_POST['txtpass']);
    $upass2 = test_input($_POST['Password']);
    $dbirth = test_input($_POST['txtdbirth']);
    $gender = test_input($_POST['gender']);
    $gender1=$gender;
	$code = md5(uniqid(rand()));

    if ( empty($uname) || !preg_match("/^[a-zA-Z ]*$/",$uname) ) {
        $Err = "Invalid name, only letters and white spaces allowed";
    }
    elseif( empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        $Err = "Invalid Email";
    }
    elseif( empty($dbirth) ) {
        $Err = "Date of birth not provided";
    }
    elseif( !valid_date($dbirth)){
        $Err = "Date of birth not valid(yyyy/mm/dd)";
    }
    elseif( empty($upass) || empty($upass2) || ($upass!=$upass2) ) {
        $Err = "Password does'nt match";
    }
    elseif( empty($gender) || $gender="" ) {
        $Err = "Please select gender";
    }
    elseif( !preg_match('(Male|Female)', $gender) === 1 ) {
        $Err = "Invalid gender";
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
        $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userEmail=:email_id");
        $stmt->execute(array(":email_id" => $email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            $msg = "
		      <div class='alert alert-danger'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Sorry !</strong>  email allready exists , Please Try another one
			  </div>
			  ";
        } else {
            if ($user_login->register($uname, $email, $upass, $dbirth, $gender1, $code)) {
                $id = $user_login->lasdID();
                $key = base64_encode($id);
                $id = $key;

                $message = "					
						Hello $uname,
						<br /><br />
						Welcome to Coding Cage!<br/>
						To complete your registration  please , just click following link<br/>
						<br /><br />
						<a href='.SCRIPT_ROOT.'/verify.php?id=$id&code=$code'>Click HERE to Activate :)</a>
						<br /><br />
						Thanks,";

                $subject = "Confirm Registration";

                $user_login->send_mail($email, $message, $subject);
                $msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Success!</strong>  We've sent an email to $email.
                    Please click on the confirmation link in the email to create your account. 
			  		</div>
					";

            } else {
                echo "sorry , Query could no execute...";
            }
        }
    }

}

//Email Verification
if(isset($_GET['id']) && isset($_GET['code'])){
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];
	
	$statusY = "Y";
	$statusN = "N";
	
	$stmt = $user_login->runQuery("SELECT userID,userStatus FROM tbl_users WHERE userID=:uID AND tokenCode=:code LIMIT 1");
	$stmt->execute(array(":uID"=>$id,":code"=>$code));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount() > 0){
		if($row['userStatus']==$statusN){
			$stmt = $user_login->runQuery("UPDATE tbl_users SET userStatus=:status WHERE userID=:uID");
			$stmt->bindparam(":status",$statusY);
			$stmt->bindparam(":uID",$id);
			$stmt->execute();	
			
			$msg = "
		           <div class='alert alert-success'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  Thank you for validating your email.
			       </div>
			       ";	
		}else{
			$msg = "
		           <div class='alert alert-error'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  <strong>sorry !</strong>  Your Account is already Activated : <a href='#small-dialog'>Login here</a>
			       </div>
			       ";
		}
	}else{
		$msg = "
		       <div class='alert alert-error'>
			   <button class='close' data-dismiss='alert'>&times;</button>
			   <strong>sorry !</strong>  No Account Found : <a href='#small-dialog1'>Signup here</a>
			   </div>
			   ";
	}	
}
?>


<!-- top html header -->
<?php include('includes/top-header.php'); ?>
<!-- //top html header -->

<!-- header -->
<?php include('includes/header.php'); ?>
<!-- //header -->

<!-- banner -->
	<div data-vide-bg="<?php echo SCRIPT_ROOT; ?>/video/nursery">
		<div class="center-container">
			<div class="container">
				<div class="w3_agile_banner_info">
					<p class="w3_agileits_banner_para"><span>w3layouts Presents</span></p>
					<div class="agileits_w3layouts_header">
						<h2 class="test2">child care homes for <i>happy families</i></h2>
					</div>
					<p class="w3_elit_para">Duis in condimentum elit, fermentum vestibulum tellus. In dapibus non orci in tempus.</p>
					<div class="agile_more">
						<a href="#" class="btn btn-3 btn-3e icon-arrow-right" data-toggle="modal" data-target="#myModal">Learn More</a>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- bootstrap-pop-up -->
	<div class="modal video-modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					Nursery
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
				</div>
				<section>
					<div class="modal-body">
						<div class="w3_modal_body_left">
							<img src="<?php echo SCRIPT_ROOT; ?>/images/1.jpg" alt=" " class="img-responsive" />
						</div>
						<div class="w3_modal_body_right">
							<h4>Suspendisse et sapien ac diam suscipit posuere</h4>
							<p>
							Ut enim ad minima veniam, quis nostrum 
							exercitationem ullam corporis suscipit laboriosam, 
							nisi ut aliquid ex ea commodi consequatur? Quis autem 
							vel eum iure reprehenderit qui in ea voluptate velit 
							esse quam nihil molestiae consequatur.
							<i>" Quis autem vel eum iure reprehenderit qui in ea voluptate velit 
								esse quam nihil molestiae consequatur.</i>
								Fusce in ex eget ligula tempor placerat. Aliquam laoreet mi id felis commodo 
								interdum. Integer sollicitudin risus sed risus rutrum 
								elementum ac ac purus.</p>
						</div>
						<div class="clearfix"> </div>
					</div>
				</section>
			</div>
		</div>
	</div>
<!-- //bootstrap-pop-up -->
<!-- banner-bottom -->
	<div id="about" class="banner-bottom">
		<div class="container">
			<h3>a <span class="w3_child">c</span><span class="w3_child1">h</span><span class="w3_child2">i</span><span class="w3_child3">l</span><span class="w3_child4">d</span>'s life is like a piece of paper on which every person leaves a mark</h3>
			<p class="w3_agile_elit">Quisque dictum elit in nunc malesuada lacinia. Cras id porttitor turpis.</p>
			<div class="agile_banner_bottom_grids">
				<div class="col-md-3 agile_banner_bottom_grid">
					<div class="view view-first">
						<img src="<?php echo SCRIPT_ROOT; ?>/images/2.jpg" alt=" " class="img-responsive" />
						<div class="mask">
							<h5>Nursery</h5>
							<p>Integer ac condimentum ligula. Ut malesuada in purus convallis venenatis.</p>
						</div>
					</div>
					<div class="agile_banner_bottom_grid_pos">
						<h4>Drawing</h4>
					</div>
				</div>
				<div class="col-md-3 agile_banner_bottom_grid">
					<div class="view view-first">
						<img src="<?php echo SCRIPT_ROOT; ?>/images/3.jpg" alt=" " class="img-responsive" />
						<div class="mask">
							<h5 class="agileits_w3layouts1">Nursery</h5>
							<p>Integer ac condimentum ligula. Ut malesuada in purus convallis venenatis.</p>
						</div>
					</div>
					<div class="agile_banner_bottom_grid_pos">
						<h4 class="agileits_w3layouts1">Learning</h4>
					</div>
				</div>
				<div class="col-md-3 agile_banner_bottom_grid">
					<div class="view view-first">
						<img src="<?php echo SCRIPT_ROOT; ?>/images/4.jpg" alt=" " class="img-responsive" />
						<div class="mask">
							<h5 class="agileits_w3layouts2">Nursery</h5>
							<p>Integer ac condimentum ligula. Ut malesuada in purus convallis venenatis.</p>
						</div>
					</div>
					<div class="agile_banner_bottom_grid_pos">
						<h4 class="agileits_w3layouts2">Playing</h4>
					</div>
				</div>
				<div class="col-md-3 agile_banner_bottom_grid">
					<div class="view view-first">
						<img src="<?php echo SCRIPT_ROOT; ?>/images/5.jpg" alt=" " class="img-responsive" />
						<div class="mask">
							<h5 class="agileits_w3layouts3">Nursery</h5>
							<p>Integer ac condimentum ligula. Ut malesuada in purus convallis venenatis.</p>
						</div>
					</div>
					<div class="agile_banner_bottom_grid_pos">
						<h4 class="agileits_w3layouts3">Laughing</h4>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- //banner-bottom -->
<!-- programs -->
	<div id="programs" class="programs">
		<div class="container">
			<h3 class="w3_agileits_head"><span class="w3_child">O</span><span class="w3_child1">u</span><span class="w3_child4">r</span> Programs</h3>
			<p class="w3_agile_elit">Quisque dictum elit in nunc malesuada lacinia. Cras id porttitor turpis.</p>
			<div class="agile_banner_bottom_grids">
				<div id="verticalTab">
					<ul class="resp-tabs-list">
						<li><i class="fa fa-rocket" aria-hidden="true"></i>Playing Science</li>
						<li><i class="fa fa-music" aria-hidden="true"></i>Music Classes</li>
						<li><i class="fa fa-bed" aria-hidden="true"></i>Sleep Center</li>
						<li><i class="fa fa-gamepad" aria-hidden="true"></i>Sport Games</li>
					</ul>
					<div class="resp-tabs-container">
						<div class="w3layouts_vertical_tab">
							<p>Proin id arcu odio. Proin tincidunt ante lacus, at commodo felis 
								aliquam eu. Praesent ut turpis venenatis, aliquam mauris tempus, lobortis 
								nunc. Pellentesque maximus ipsum turpis.
								<i>" Cras feugiat dui augue, in malesuada sem porta id. Mauris tempor 
									aliquam risus eget sagittis. Nulla eu imperdiet mauris.</i></p>
							<ul>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Nulla eu imperdiet mauris in nunc</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Vestibulum posuere eros et ante auctor</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Curabitur leo nisl, viverra eu urna id</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Suspendisse potenti uisque dictum elit</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Phasellus a eros eleifend, vehicula ante</li>
							</ul>
						</div>
						<div class="w3layouts_vertical_tab">
							<p>Donec felis mi, tristique in sodales non, porttitor id orci. 
								Mauris vulputate placerat justo vitae sollicitudin. Nunc venenatis tortor 
								dapibus magna commodo gravida.
								<i>" Cras feugiat dui augue, in malesuada sem porta id. Mauris tempor 
									aliquam risus eget sagittis. Nulla eu imperdiet mauris.</i></p>
							<ul>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Nulla eu imperdiet mauris in nunc</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Vestibulum posuere eros et ante auctor</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Curabitur leo nisl, viverra eu urna id</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Suspendisse potenti uisque dictum elit</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Phasellus a eros eleifend, vehicula ante</li>
							</ul>
						</div>
						<div class="w3layouts_vertical_tab">
							<p>Integer ac condimentum ligula. Ut malesuada in purus convallis venenatis, 
								lobortis nunc. Pellentesque maximus ipsum turpis.Nulla eu imperdiet mauris.
								 Fusce cursus convallis malesuada.
								<i>" Cras feugiat dui augue, in malesuada sem porta id. Mauris tempor 
									aliquam risus eget sagittis. Nulla eu imperdiet mauris.</i></p>
							<ul>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Nulla eu imperdiet mauris in nunc</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Vestibulum posuere eros et ante auctor</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Curabitur leo nisl, viverra eu urna id</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Suspendisse potenti uisque dictum elit</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Phasellus a eros eleifend, vehicula ante</li>
							</ul>
						</div>
						<div class="w3layouts_vertical_tab">
							<p>Quisque dictum elit in nunc malesuada lacinia. Cras id porttitor turpis. 
								Nulla scelerisque ut lectus vitae tincidunt. Duis nec tellus at nunc blandit 
								malesuada.Cras rhoncus varius arcu.
								<i>" Cras feugiat dui augue, in malesuada sem porta id. Mauris tempor 
									aliquam risus eget sagittis. Nulla eu imperdiet mauris.</i></p>
							<ul>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Nulla eu imperdiet mauris in nunc</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Vestibulum posuere eros et ante auctor</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Curabitur leo nisl, viverra eu urna id</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Suspendisse potenti uisque dictum elit</li>
								<li><i class="fa fa-check-square-o" aria-hidden="true"></i>Phasellus a eros eleifend, vehicula ante</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- //programs -->
<!-- team -->
	<div id="team" class="team">
		<div class="container">
			<h3 class="w3_agileits_head">Our <span class="w3_child">T</span><span class="w3_child1">e</span><span class="w3_child2">a</span><span class="w3_child4">m</span> Players</h3>
			<p class="w3_agile_elit">Quisque dictum elit in nunc malesuada lacinia. Cras id porttitor turpis.</p>
			<div class="agile_banner_bottom_grids">
				<div class="w3_slider">
					<ul class="slides">
						<li class="slide">
							<div class="col-md-3 wthree_team_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/7.jpg" alt=" " class="img-responsive" />
								<div class="wthree_team_grid_w3">
									<h4>Olivia Wilde</h4>
									<p>Teacher</p>
									<div class="wthree_team_grid_w3_pos">
										<ul class="agileinfo_social_icons">
											<li><a href="#" class="w3ls_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
											<li><a href="#" class="agileits_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3l_google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-3 wthree_team_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/9.jpg" alt=" " class="img-responsive" />
								<div class="wthree_team_grid_w3">
									<h4>Brett Cullen</h4>
									<p>Teacher</p>
									<div class="wthree_team_grid_w3_pos">
										<ul class="agileinfo_social_icons">
											<li><a href="#" class="agileits_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3ls_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-3 wthree_team_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/8.jpg" alt=" " class="img-responsive" />
								<div class="wthree_team_grid_w3">
									<h4>Emma Stone</h4>
									<p>Teacher</p>
									<div class="wthree_team_grid_w3_pos">
										<ul class="agileinfo_social_icons">
											<li><a href="#" class="w3_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3l_google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3ls_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-3 wthree_team_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/10.jpg" alt=" " class="img-responsive" />
								<div class="wthree_team_grid_w3">
									<h4>Jorge Nicolas</h4>
									<p>Teacher</p>
									<div class="wthree_team_grid_w3_pos">
										<ul class="agileinfo_social_icons">
											<li><a href="#" class="w3l_google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3ls_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
											<li><a href="#" class="agileits_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="clearfix"> </div>
						</li>
						<li class="slide">
							<div class="col-md-3 wthree_team_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/7.jpg" alt=" " class="img-responsive" />
								<div class="wthree_team_grid_w3">
									<h4>Olivia Wilde</h4>
									<p>Teacher</p>
									<div class="wthree_team_grid_w3_pos">
										<ul class="agileinfo_social_icons">
											<li><a href="#" class="w3ls_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
											<li><a href="#" class="agileits_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3l_google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-3 wthree_team_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/9.jpg" alt=" " class="img-responsive" />
								<div class="wthree_team_grid_w3">
									<h4>Brett Cullen</h4>
									<p>Teacher</p>
									<div class="wthree_team_grid_w3_pos">
										<ul class="agileinfo_social_icons">
											<li><a href="#" class="agileits_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3ls_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-3 wthree_team_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/8.jpg" alt=" " class="img-responsive" />
								<div class="wthree_team_grid_w3">
									<h4>Emma Stone</h4>
									<p>Teacher</p>
									<div class="wthree_team_grid_w3_pos">
										<ul class="agileinfo_social_icons">
											<li><a href="#" class="w3_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3l_google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3ls_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-md-3 wthree_team_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/10.jpg" alt=" " class="img-responsive" />
								<div class="wthree_team_grid_w3">
									<h4>Jorge Nicolas</h4>
									<p>Teacher</p>
									<div class="wthree_team_grid_w3_pos">
										<ul class="agileinfo_social_icons">
											<li><a href="#" class="w3l_google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
											<li><a href="#" class="w3ls_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
											<li><a href="#" class="agileits_facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="clearfix"> </div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
<!-- //team -->
<!-- stats -->
	<div class="stats">
		<div class="container">
			<div class="col-md-3 w3layouts_stats_grid">
				<i class="fa fa-male w3_agile_i" aria-hidden="true"></i>
				<p class="counter">2314+</p>
				<h4>Students</h4>
				<div class="agile_stats_grid w3ls_stats_grid">
					<i></i>
				</div>
			</div>
			<div class="col-md-3 w3layouts_stats_grid">
				<i class="fa fa-flask w3_agile_i1" aria-hidden="true"></i>
				<p class="counter">1344+</p>
				<h4>Labs</h4>
				<div class="agile_stats_grid w3ls_stats_grid1">
					<i></i>
				</div>
			</div>
			<div class="col-md-3 w3layouts_stats_grid">
				<i class="fa fa-cloud w3_agile_i2" aria-hidden="true"></i>
				<p class="counter">4563+</p>
				<h4>Classes</h4>
				<div class="agile_stats_grid w3ls_stats_grid2">
					<i></i>
				</div>
			</div>
			<div class="col-md-3 w3layouts_stats_grid">
				<i class="fa fa-graduation-cap w3_agile_i3" aria-hidden="true"></i>
				<p class="counter">1257+</p>
				<h4>Team</h4>
				<div class="agile_stats_grid w3ls_stats_grid3">
					<i></i>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //stats -->
<!-- events -->
	<div id="events" class="events">
		<div class="container">
			<h3 class="w3_agileits_head">Our Latest <span class="w3_child">E</span><span class="w3_child1">v</span><span class="w3_child2">e</span><span class="w3_child4">n</span><span class="w3_child">t</span><span class="w3_child1">s</span></h3>
			<p class="w3_agile_elit">Quisque dictum elit in nunc malesuada lacinia. Cras id porttitor turpis.</p>
			<div class="agile_banner_bottom_grids">
				<div class="agile_events_grid">
					<img src="<?php echo SCRIPT_ROOT; ?>/images/1.jpg" alt=" " class="img-responsive" />
					<div class="agile_events_grid_pos agile_events_grid_pos1">
						<h5><span>01</span> 12 / 2016</h5>
						<h4><a href="#" data-toggle="modal" data-target="#myModal">nunc malesuada lacinia</a></h4>
						<p>Nunc non maximus augue, sit amet dictum diam. Etiam ultrices hendrerit sapien, 
							id volutpat tortor viverra et.</p>
					</div>
					<div class="agileits_w3layouts_events_grid_social">
						<ul class="agileinfo_social_icons">
							<li><a href="#" class="w3_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href="#" class="w3l_google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
							<li><a href="#" class="w3ls_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="agile_events_grid">
					<img src="<?php echo SCRIPT_ROOT; ?>/images/13.jpg" alt=" " class="img-responsive" />
					<div class="agile_events_grid_pos_sub agile_events_grid_pos1">
						<h5 class="w3_agileits_event_head"><span>05</span> 12 / 2016</h5>
						<h4><a href="#" data-toggle="modal" data-target="#myModal">consequat dictum sodales</a></h4>
						<p>Nunc non maximus augue, sit amet dictum diam. Etiam ultrices hendrerit sapien, 
							id volutpat tortor viverra et.</p>
					</div>
					<div class="agileits_w3layouts_events_grid_social1">
						<ul class="agileinfo_social_icons">
							<li><a href="#" class="w3_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href="#" class="w3l_google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
							<li><a href="#" class="w3ls_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div>
				<div class="agile_events_grid">
					<img src="<?php echo SCRIPT_ROOT; ?>/images/15.jpg" alt=" " class="img-responsive" />
					<div class="agile_events_grid_pos agile_events_grid_pos1">
						<h5><span>09</span> 12 / 2016</h5>
						<h4><a href="#" data-toggle="modal" data-target="#myModal">ultrices hendrerit amet</a></h4>
						<p>Nunc non maximus augue, sit amet dictum diam. Etiam ultrices hendrerit sapien, 
							id volutpat tortor viverra et.</p>
					</div>
					<div class="agileits_w3layouts_events_grid_social">
						<ul class="agileinfo_social_icons">
							<li><a href="#" class="w3_twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							<li><a href="#" class="w3l_google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
							<li><a href="#" class="w3ls_dribble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- //events -->
<!-- testimonials -->
	<div id="testimonials" class="testimonials">
		<div class="container">
			<h3 class="w3_agileits_head wthree_head">What Our <span class="w3_child">P</span><span class="w3_child1">a</span><span class="w3_child2">r</span><span class="w3_child4">e</span><span class="w3_child">n</span><span class="w3_child1">t</span><span class="w3_child2">s</span> Say</h3>
			<p class="w3_agile_elit">Quisque dictum elit in nunc malesuada lacinia. Cras id porttitor turpis.</p>
			<div class="agile_banner_bottom_grids">
				<div class="agileits_testimonials_grids">
					<ul id="flexiselDemo1">	
						<li>
							<div class="agileinfo_testimonials_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/17.jpg" alt=" " class="img-responsive" />
							</div>
						</li>
						<li>
							<div class="agileinfo_testimonials_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/18.jpg" alt=" " class="img-responsive" />
							</div>
						</li>
						<li>
							<div class="agileinfo_testimonials_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/19.jpg" alt=" " class="img-responsive" />
							</div>
						</li>
						<li>
							<div class="agileinfo_testimonials_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/20.jpg" alt=" " class="img-responsive" />
							</div>
						</li>
						<li>
							<div class="agileinfo_testimonials_grid">
								<img src="<?php echo SCRIPT_ROOT; ?>/images/21.jpg" alt=" " class="img-responsive" />
							</div>
						</li>
					</ul>
					<h3>About <span>Nursery</span> / Parent</h3>
					<p>Mauris vulputate placerat justo vitae sollicitudin. Nunc venenatis tortor dapibus 
						magna commodo gravida. Nunc non maximus augue, sit amet dictum diam. Etiam ultrices 
						hendrerit sapien, id volutpat tortor viverra et.</p>
				</div>
			</div>
		</div>
	</div>
<!-- //testimonials -->
<!-- work -->
	<div id="work" class="work">
		<div class="container">
			<h3 class="w3_agileits_head">Our <span class="w3_child">W</span><span class="w3_child1">o</span><span class="w3_child4">r</span><span class="w3_child2">k</span> in Nursery</h3>
			<p class="w3_agile_elit">Quisque dictum elit in nunc malesuada lacinia. Cras id porttitor turpis.</p>
			<div class="agile_work_single_grids">
				<div class="bs-example bs-example-tabs wthree_example_tab" role="tabpanel" data-example-id="togglable-tabs">
					<ul id="myTab" class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">All</a></li>
						<li role="presentation"><a href="#learning" role="tab" id="learning-tab" data-toggle="tab" aria-controls="learning">Category- 1</a></li>
						<li role="presentation"><a href="#playing" role="tab" id="playing-tab" data-toggle="tab" aria-controls="playing">Category- 2</a></li>
						<li role="presentation"><a href="#painting" role="tab" id="painting-tab" data-toggle="tab" aria-controls="painting">Category- 3</a></li>
					</ul>
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
							<div class="w3_tab_img agileinfo_img">
								<div class="col-md-4 w3_tab_img_left">
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/13.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/13.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/15.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/15.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
								</div>
								<div class="col-md-4 w3_tab_img_left">
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/1.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/1.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/22.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/22.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
								</div>
								<div class="col-md-4 w3_tab_img_left">
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/12.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/12.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/23.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/23.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="learning" aria-labelledby="learning-tab">
							<div class="w3_tab_img agileinfo_img">
								<div class="col-md-4 w3_tab_img_left">
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/15.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/15.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
								</div>
								<div class="col-md-4 w3_tab_img_left">
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/1.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/1.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
								</div>
								<div class="col-md-4 w3_tab_img_left">
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/23.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/23.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="playing" aria-labelledby="playing-tab">
							<div class="w3_tab_img agileinfo_img">
								<div class="col-md-4 w3_tab_img_left">
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/13.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/13.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
								</div>
								<div class="col-md-4 w3_tab_img_left">
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/23.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/23.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="painting" aria-labelledby="painting-tab">
							<div class="w3_tab_img agileinfo_img">
								<div class="col-md-4 w3_tab_img_left">
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/1.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/1.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
								</div>
								<div class="col-md-4 w3_tab_img_left">
									<div class="agileits_demo">
										<a href="<?php echo SCRIPT_ROOT; ?>/images/22.jpg">
											<figure class="w3layouts_work">
												<div class="w3layouts_work_sub">
													<img src="<?php echo SCRIPT_ROOT; ?>/images/22.jpg" alt=" " class="img-responsive" />
												</div>
												<figcaption>
													<span>Nursery</span>
												</figcaption>
											</figure>
										</a>
									</div>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- //work -->
<!-- newsletter -->
	<div id="newsletter" class="newsletter">
		<div class="container">
			<div class="col-md-5 w3layouts_newsletter_left">
				<h3>Subscribe to our newsletter</h3>
			</div>
			<div class="col-md-6 w3layouts_newsletter_right">
				<form action="#" method="post">
					<input type="email" name="Email" placeholder="Email..." required="">
					<input type="submit" value="Subscribe">
				</form>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //newsletter -->
<!-- contact -->
	<div id="mail" class="contact">
		<div class="container">
			<h3 class="w3_agileits_head">Get In <span class="w3_child">T</span><span class="w3_child1">o</span><span class="w3_child4">u</span><span class="w3_child2">c</span><span class="w3_child1">h</span></h3>
			<p class="w3_agile_elit">Quisque dictum elit in nunc malesuada lacinia. Cras id porttitor turpis.</p>
			<div class="agile_banner_bottom_grids">
				<div class="col-md-4 w3_agile_contact_grid">
					<div class="col-xs-4 agile_contact_grid_left">
						<i class="fa fa-map-marker" aria-hidden="true"></i>
					</div>
					<div class="col-xs-8 agile_contact_grid_right agilew3_contact">
						<h4>Address</h4>
						<p>435 City hall, NewYork City SD092.</p>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="col-md-4 w3_agile_contact_grid">
					<div class="col-xs-4 agile_contact_grid_left agileits_w3layouts_left">
						<i class="fa fa-mobile" aria-hidden="true"></i>
					</div>
					<div class="col-xs-8 agile_contact_grid_right agileits_w3layouts_right">
						<h4>Phone</h4>
						<p>+(1234) 2332 232 <span>+(1236) 2334 232</span></p>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="col-md-4 w3_agile_contact_grid">
					<div class="col-xs-4 agile_contact_grid_left agileits_w3layouts_left1">
						 <i class="fa fa-envelope-o" aria-hidden="true"></i>
					</div>
					<div class="col-xs-8 agile_contact_grid_right agileits_w3layouts_right1">
						<h4>Email</h4>
						<p><a href="mailto:info@example.com">info@example1.com</a>
							<span><a href="mailto:info@example.com">info@example2.com</a></span></p>
					</div>
					<div class="clearfix"> </div>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="agile_banner_bottom_grids">
				<form action="#" method="post">
					<div class="col-md-6 w3_agileits_contact_left">
						<span class="input input--akira">
							<input class="input__field input__field--akira" type="text" id="input-22" name="Name" placeholder="" required="" />
							<label class="input__label input__label--akira" for="input-22">
								<span class="input__label-content input__label-content--akira">Your Name</span>
							</label>
						</span>
						<span class="input input--akira">
							<input class="input__field input__field--akira" type="email" id="input-23" name="Email" placeholder="" required="" />
							<label class="input__label input__label--akira" for="input-23">
								<span class="input__label-content input__label-content--akira">Your Email</span>
							</label>
						</span>
						<span class="input input--akira">
							<input class="input__field input__field--akira" type="text" id="input-24" name="Subject" placeholder="" required="" />
							<label class="input__label input__label--akira" for="input-24">
								<span class="input__label-content input__label-content--akira">Your Subject</span>
							</label>
						</span>
					</div>
					<div class="col-md-6 w3_agileits_contact_right">
						<div class="w3_agileits_contact_right1">
							<textarea name="Message" placeholder="Your comment here..." required=""></textarea>
						</div>
						<div class="w3_agileits_contact_right2">
							<input type="submit" value=" ">
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="clearfix"> </div>
				</form>
			</div>
		</div>
	</div>
<!-- //contact -->
<!-- footer -->
<?php include('includes/footer.php'); ?>
<!-- //footer -->
<?php include('includes/bottom-footer.php'); ?>