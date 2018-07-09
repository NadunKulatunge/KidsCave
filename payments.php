<?php

session_start();
require_once 'backend/class.user.php';


$user_login = new User();

/**check user is logged in**/

if(!$user_login->is_logged_in()){
	$user_login->redirect('index.php');
}
if($_SESSION['userRole']== "Admin" && $_SESSION['userRole']== "Principal"){
	$user_login->redirect('../backend/payments.php');
}
if($_SESSION['userRole']== "Teacher"){
    $user_login->redirect('index.php');
}

include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/payments_frontend.php');

?>

<!-- top html header -->
<?php include('includes/top-header.php'); ?>
<!-- //top html header -->
<!-- header -->
<?php include('includes/header.php'); ?>
<!-- //header -->
<div style="min-height: calc(100vh - 190px); margin-top: 1em; margin-bottom:3em;">
	<div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Payments</h1></div><br>
		<div class="row" >
			<!-- left panel -->
			<?php include('includes/left-panel.php'); ?>
			<!-- //left panel -->
			<!-- right panel -->
			<div class="col-md-9">
			<br/>
				<?php 
				$output .= '</table>'; 
				echo $output; ?>
				<?php if($dueAmount<=0){echo ("<span class='text-danger'>You have done all the Payments</span>");} elseif($startDate!=date("Y").'-01-01'){echo ("<b><span class='text-danger'>Payment due date : " . $startDate ."</span></b>");}?>
				<br/>
				<br/>
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" <?php if($dueAmount<=0){echo ("style='display:none;'");}?>>
					<div class="form-group">
						<div class= "row">
							<div class="col-xs-6">
								<label for="radioDuration">Payment Duration</label>
							</div>
							<div class="col-xs-3">
								<label class="radio-inline">
									<input <?php if (isset($paymentDuration) && $paymentDuration=="Term") echo "checked";?> type="radio" name="PaymentDurationOption" id="inlineRadio1" onclick='termEnable()' value="Term" required> Term
								</label>
							</div>
							<div class="col-xs-3">
								<label class="radio-inline">
									<input <?php if (isset($paymentDuration) && $paymentDuration=="Year") echo "checked";?> type="radio" name="PaymentDurationOption" id="inlineRadio2" <?php if($amountpaid!=0){echo 'Disabled';} ?> onclick='yearEnable()' value="Year"> Year
								</label>
							</div>
							<span class="text-danger"><?php echo $paymentDurationErr;?></span>
						</div>
					</div>
					<div class="form-group">
						<div class= "row">
							<div class="col-xs-6">
								<label for="labelTotalPayment">Discount</label>
							</div>
							<div class="col-xs-6">
								<label for="labelTotalPayment" id="DiscountPercentage">0 %</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class= "row">
							<div class="col-xs-6">
								<label for="labelTotalPayment">Total Payment</label>
							</div>
							<div class="col-xs-6">
								<label for="labelTotalPayment" id="TotalPayment">Rs 0</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class= "row">
							<div class="col-xs-6">
								<label for="radioDuration">Payment Method</label>
							</div>
							<div class="col-xs-3">
								<label class="radio-inline">
									<input <?php if (isset($paymentMethod) && $paymentMethod=="Cash") echo "checked";?> type="radio" name="PaymentMethodOption" id="inlineRadio3" value="Cash" onclick="cashEnable()" required> Cash
								</label>
							</div>
							<div class="col-xs-3">
								<label class="radio-inline">
									<input <?php if (isset($paymentMethod) && $paymentMethod=="Card") echo "checked";?> type="radio" name="PaymentMethodOption" id="inlineRadio4" value="Card" onclick="cardEnable()"> Card
								</label>
							</div>
							<span class="text-danger"><?php echo $paymentMethodErr;?></span>
						</div>
					</div>
					<div id="CardPaymentDiv" style="display:none;">
						<div class="form-group">
							<div class= "row">
								<div class="col-xs-6">
									<label for="labelName">Name on Card</label>
								</div>
								<div class="col-xs-6">
									<input disabled value="<?php echo $name;?>" name ="name" id="name" type="text" class="form-control" id="inputName" placeholder="A B C JOHN" required=""  minlength="4">
									<span class="text-danger"><?php echo $nameErr;?></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class= "row">
								<div class="col-xs-6">
									<label for="labelCardNumber">Card Number</label>
								</div>
								<div class="col-xs-6">
									<input disabled value="<?php echo $cardNumber;?>" name ="cardNumber" id="cardNumber" type="tell" value="" required="" data-required-message="Please enter card number." pattern="[0-9]{16,19}" max-length="19" autocomplete="off" class="form-control" id="inputCardNumber">
									<span class="text-danger"><?php echo $cardNumberErr;?></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class= "row">
								<div class="col-xs-6">
									<label for="labelValidTill">Valid till</label>
								</div>
								<div class="col-xs-6">
									<input disabled value="<?php echo $duration;?>" name="validTill" id="validTill" type="month" min="<?php echo date("Y-m",strtotime("today")); ?>" max="<?php echo date("Y-m",strtotime("+5 years")); ?>" class="form-control" id="inputValidTill" placeholder="month/year">
									<span class="text-danger"><?php echo $durationErr;?></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class= "row">
								<div class="col-xs-6">
									<label for="labelCVV">CVV</label>
								</div>
								<div class="col-xs-6">
									<input disabled value="<?php echo $cvv;?>" type="text" class="form-control" name = "cvv" id="cvv" placeholder="xxx" required=""  pattern="\d{3}" autocomplete="off" >
									<span class="text-danger"><?php echo $cvvErr;?></span>
								</div>
							</div>
						</div>
					</div>
					<br/>
					<div align="center"> 
						<button type="submit" class="btn btn-primary" style="width:50%;">Submit</button>
					</div>
				</form>
			
			</div>
			<!-- right panel -->
		</div>
	</div>
</div>
<script>
function cardEnable() {
    document.getElementById('CardPaymentDiv').style.display='block';
	document.getElementById('name').disabled = false;
	document.getElementById('cardNumber').disabled = false;
	document.getElementById('validTill').disabled = false;
	document.getElementById('cvv').disabled = false;
}
function cashEnable() {
    document.getElementById('CardPaymentDiv').style.display='none';
	document.getElementById('name').disabled = true;
	document.getElementById('cardNumber').disabled = true;
	document.getElementById('validTill').disabled = true;
	document.getElementById('cvv').disabled = true;
}
function termEnable() {
		<?php
 		if($dueAmount<($total/3)){
			$amounttopay = $dueAmount;
		}else{
			$amounttopay = $total/3;
		} ?>
    document.getElementById("DiscountPercentage").innerHTML = "0 %";
	document.getElementById("TotalPayment").innerHTML = "<?php echo "Rs " .$amounttopay; ?>";	
}
function yearEnable() {
    document.getElementById("DiscountPercentage").innerHTML = "15 %";
	document.getElementById("TotalPayment").innerHTML = "<?php echo "Rs " .$dueAmount*0.85; ?>";
}
</script>
<!-- footer -->
<?php include('includes/footer.php'); ?>
<!-- //footer -->
<?php include('includes/bottom-footer.php'); ?>