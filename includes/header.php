	<div class="w3_agile_header" style="position: sticky; top: 0; z-index: 1000;">
		<div class="container">
			<div class="w3_agile_header_right">
				<ul>
					<li><a href="#small-dialog1" style="background: red;"class="play-icon popup-with-zoom-anim">Enroll Now!</a></li>
					<?php
					if($user_login->is_logged_in()!=""){
						echo '<li><a href="'.SCRIPT_ROOT.'/dashboard.php">MyAccount</a></li>';
					}else{
						echo '<li><a href="#small-dialog" class="play-icon popup-with-zoom-anim">Login</a></li>';
					}
					?>
					
					<li><i class="fa fa-phone" aria-hidden="true"></i> +(0123) 454 343</li>
				</ul>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<div class="w3_navigation">
		<div class="container">
			<nav class="navbar navbar-default">
				<div class="navbar-header navbar-left">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="w3_navigation_pos">
						<h1><a href="<?php echo SCRIPT_ROOT; ?>/index.php"><span>KidsCave</span><i>baby home</i></a></h1>
					</div>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
					<nav class="menu menu--miranda">
						<ul class="nav navbar-nav menu__list">
							<li class="menu__item menu__item--current"><a href="<?php echo SCRIPT_ROOT; ?>/index.php" class="menu__link">Home</a></li>
							<li class="menu__item"><a href="<?php echo SCRIPT_ROOT; ?>/index.php#events" class="scroll menu__link">Our Events</a></li>
							<li class="menu__item"><a href="<?php echo SCRIPT_ROOT; ?>/index.php#programs" class="scroll menu__link">Programs</a></li>
							<li class="menu__item"><a href="<?php echo SCRIPT_ROOT; ?>/index.php#work" class="scroll menu__link">Work</a></li>
							<li class="menu__item"><a href="<?php echo SCRIPT_ROOT; ?>/index.php#team" class="scroll menu__link">Team</a></li>
							<li class="menu__item"><a href="<?php echo SCRIPT_ROOT; ?>/index.php#mail" class="scroll menu__link">Mail Us</a></li>
						</ul>
					</nav>
				</div>
			</nav>	
		</div>
	</div>
<!--login errors-->
<?php
if(isset($_GET['inactive'])){
	?>
	<div class='alert alert-error'>
		<button class='close' data-dismiss='alert'>&times;</button>
		<strong>Sorry!</strong> Your account is not yet approved. 
	</div>
<?php
}
	?>

<?php
if(isset($_GET['error'])){
	?>
	<div class='alert alert-success'>
		<button class='close' data-dismiss='alert'>&times;</button>
		<strong>Wrong Login Details!</strong> 
	</div>
<?php
}
	?>
<!--enroll errors-->	
<?php if(isset($msg)) echo $msg;  ?>
<!-- pop-up-box -->
	<div id="small-dialog" class="mfp-hide w3ls_small_dialog wthree_pop">
		<h3>LOGIN</h3>		
		<div class="agileits_modal_body">
            //This info will be sent to index.php (Top of index.php)
			<form action="#" method="post">
				<?php 
				if(isset($_GET['inactive'])){
					?>
					<div class='alert alert-error'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Sorry!</strong> Your account is not approved. 
					</div>
				<?php
				}
					?>
				<?php
				if(isset($_GET['error'])){
					?>
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Wrong Login Details!</strong> 
					</div>
				<?php
				}
					?>
				<div class="agileits_w3layouts_user">
					<i class="fa fa-user" aria-hidden="true"></i>
					<input type="text" name="txtemail" placeholder="Email" required="">
				</div>
				<div class="agileits_w3layouts_user">
					<i class="fa fa-key" aria-hidden="true"></i>
					<input type="password" name="txtupass" placeholder="Password" required="">
				</div>
				<div class="agile_remember">
					<div class="agile_remember_left">
						<div class="check">
							<label class="checkbox"><input type="checkbox" name="checkbox"><i> </i>remember me</label>
						</div>
					</div>
					<div class="agile_remember_right">
						<a href="#">Forgot Password?</a>
					</div>
					<div class="clearfix"> </div>
				</div>
				<input type="submit" name="btn-login">
			</form>
			<h5>Don't have an account? <a href="#small-dialog1" class="play-icon popup-with-zoom-anim">Sign Up</a></h5>
		</div>
	</div>
    <style>
        .agileits_w3layouts_user input[type="date"]{
            outline: none;
            padding: 15px 10px 15px 80px;
            font-size: 14px;
            color: #212121;
            border:2px solid #e0e0e0;
            width: 100%;
            font-weight:600;
            line-height: 15px;
        }
        #gender {
            outline: none;
            padding: 15px 10px 15px 80px;
            font-size: 14px;
            color: #212121;
            border:2px solid #e0e0e0;
            width: 100%;
            font-weight:600;
            line-height: 15px;
        }
    </style>
	<div id="small-dialog1" class="mfp-hide w3ls_small_dialog wthree_pop">
		<h3>Application Form</h3>		
		<div class="agileits_modal_body">
            <?php //This info will be sent to index.php (Top of index.php)?>
			<form action="#" method="post">
			<?php if(isset($msg)) echo $msg;  ?>
				<h4>Child information :</h4>
				<div class="agileits_w3layouts_user">
					<i class="fa fa-user" aria-hidden="true"></i>
					<input type="text" name="txtuname" value="<?php if(isset($uname)){echo $uname;} ?>" placeholder="Full Name" required="">
				</div>
                <div class="agileits_w3layouts_user agileits_w3layouts_user_agileits">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <input type="date" name="txtdbirth" value="<?php if(isset($dbirth)){echo $dbirth;} ?>" placeholder="Date of Birth" required="">
                </div>
                <div class="agileits_w3layouts_user agileits_w3layouts_user_agileits">
                    <i class="fa fa-venus" aria-hidden="true"></i>
                    <select id="gender" name="gender" required>
                        <option value="" >Gender</option>
                        <option <?php if(isset($gender) && $gender=="Male"){echo "selected=\"true\"";} ?> value="Male">Male</option>
                        <option <?php if(isset($gender) && $gender=="Female"){echo "selected=\"true\"";} ?>  value="Female">Female</option>
                    </select>
                </div>
				<hr>
				<h4>Login information :</h4>
				<div class="agileits_w3layouts_user">
					<i class="fa fa-envelope-o" aria-hidden="true"></i>
					<input type="email"  name="txtemail" value="<?php if(isset($email)){echo $email;} ?>" placeholder="Email" required="">
				</div>
				<div class="agileits_w3layouts_user agileits_w3layouts_user_agileits">
					<i class="fa fa-key" aria-hidden="true"></i>
					<input type="password" name="txtpass" value="<?php if(isset($upass)){echo $upass;} ?>" placeholder="Password" required="">
				</div>
				<div class="agileits_w3layouts_user">
					<i class="fa fa-key" aria-hidden="true"></i>
					<input type="password" name="Password" value="<?php if(isset($upass2)){echo $upass2;} ?>" placeholder="Confirm Password" required="">
				</div>
				<div class="agileinfo_subscribe">
					<div class="check">
						<label class="checkbox"><input type="checkbox" name="checkbox" required><i> </i>i accept the terms and conditions</label>
					</div>
				</div>
				<input type="submit" name="btn-signup">
			</form>
			<h5>Already a member <a href="#small-dialog" class="play-icon popup-with-zoom-anim">Sign In</a></h5>
		</div>
	</div>
<!-- //pop-up-box -->
<script src="<?php echo SCRIPT_ROOT; ?>/js/jquery.magnific-popup.js" type="text/javascript"></script>
<script>
	$(document).ready(function() {
	$('.popup-with-zoom-anim').magnificPopup({
		type: 'inline',
		fixedContentPos: false,
		fixedBgPos: true,
		overflowY: 'auto',
		closeBtnInside: true,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
																	
	});
</script>