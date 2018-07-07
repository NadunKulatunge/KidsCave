<?php

session_start();
require_once 'class.user.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');

$user_login = new USER();

if(!$user_login->is_logged_in()){
	$user_login->redirect('index.php');
}
if($_SESSION['userRole']== "Admin" && $_SESSION['userRole']== "Principal" && $_SESSION['userRole']== "Teacher"){
	$user_login->redirect('../backend/payments.php');
}

 $output = '';
 $total = 0;
 $amountpaid = 0;
 $newdate1='2012-01-01';
$sql1 = "SELECT totalAmount,startDate,endDate FROM `student_payment` where paymentYear='".date("Y")."' AND userID='".$_SESSION['userSession']."' ORDER BY endDate ASC";
$result1 = mysqli_query($connect, $sql1);
if(mysqli_num_rows($result1) > 0){
 while($row1 = mysqli_fetch_array($result1)){
	 $amountpaid = $amountpaid + $row1["totalAmount"];
	 $startDate=$row1["endDate"];
 }
	
}else{
	$amountpaid = 0;
	$startDate=date("Y").'-01-01';
} 

$sql = "SELECT * FROM `student_payment_detail`";
$result = mysqli_query($connect, $sql);
                $output .= '  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="50%" class="text-center">Description</th>  
                               <th width="50%" class="text-center">Amount (Rs)</th>  
                          </tr>  
                ';  
                if(mysqli_num_rows($result) > 0){
					
                    while($row = mysqli_fetch_array($result)){						
                          $output .= '  
                               <tr>  
                                    <td>'.$row["description"].'</td>  
                                    <td class="text-right">'.number_format($row["totalAmount"],2).'</td>  
                               </tr>  
							';
							
							$total = $total + (int) $row["totalAmount"];							
					}
					$output .= '  
                               <tr>  
                                    <td>Total</td>  
                                    <td class="text-right">'.number_format($total,2).'</td>  
                               </tr>
							';
					$output .= '  
                               <tr>  
                                    <td>Amount paid</td>  
                                    <td class="text-right">'.number_format($amountpaid,2).'</td>  
                               </tr>
							';
					$dueAmount =$total-$amountpaid;
					$output .= '  
                               <tr>  
                                    <td>Amount Due</td>  
                                    <td class="text-right">'.number_format($dueAmount,2).'</td>  
                               </tr>
							';
							
				}else{  
				
                     $output .= '  
                          <tr>  
                               <td colspan="4">Data not Found</td>  
                          </tr>  
                     '; 
					 
                }  
                 

                


$paymentMethodErr = $paymentDurationErr = $nameErr = $cardNumberErr = $cvvErr = $durationErr = $paymentMethodErr ="";
$paymentMethod = $paymentDuration = $name = $cardNumber = $cvv = $duration = $paymentMethod = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if ( (int)($dueAmount)<=0 ){
		$paymentDurationErr = "Sorry you don't have any due payments";
		
	} elseif(empty($_POST["PaymentDurationOption"])){
		$paymentDurationErr = "Select payment duration";
		
	} elseif( ($amountpaid != 0) && ($_POST["PaymentDurationOption"]=="Year") ) {
		$paymentDurationErr = "You cannot pay for a year";
		
	} elseif( ($_POST["PaymentDurationOption"]=="Year") ){
		$paymentDuration = $_POST["PaymentDurationOption"];
		$newdate1 = strtotime ( '+12 months' , strtotime($startDate) ) ; //adding 12 months into start date
		$newdate1 = date ( 'Y-m-j' , $newdate1 );
		
		$totalAmount = $total;
		$discount = 15;
		$amountPaid = ($total*0.85);
		
		
	}elseif( ($_POST["PaymentDurationOption"]=="Term") ){	
		$paymentDuration = $_POST["PaymentDurationOption"];			
		$newdate1 = strtotime ( '+4 months' , strtotime($startDate) ) ; //adding 4 months into start date
		$newdate1 = date ( 'Y-m-j' , $newdate1 );
		
		
		if($dueAmount<($total/3)){
			$totalAmount = $dueAmount;
			$discount = 0;
			$amountPaid = $dueAmount;
		}else{
			$totalAmount = $total/3;
			$discount = 0;
			$amountPaid = $total/3;
		}
		
		
	} else {
		$paymentDurationErr = "Invalid payment duration";
	}
	
	if (empty($_POST["PaymentMethodOption"])) {
		$paymentMethodErr = "Select payment method";
		
	} elseif( !empty($_POST["PaymentMethodOption"]) && ($_POST["PaymentMethodOption"] == 'Card') ) {
		
		$paymentMethod = test_input($_POST["PaymentMethodOption"]);
		
		if (empty($_POST["name"])) {
			$nameErr = "Name is required";
		} else {
			$name = test_input($_POST["name"]);
			if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
			$nameErr = "Only letters and white space allowed"; 
			}
		}
	  
		if (empty($_POST["cardNumber"])) {
			$cardNumberErr = "Card Number is required";
		} else {
			$cardNumber = test_input($_POST["cardNumber"]);
			if (!preg_match("/^[0-9]{16,19}$/",$cardNumber)){
			$cardNumberErr = "Invalid Card Number"; 
			}
		}
		
		if (empty($_POST["validTill"])) {
			$durationErr = "Validity period is required";
		} else {
			$duration = test_input($_POST["validTill"]);
			if (!validateMonth($duration)) {
			$durationErr = "Date is not valid"; 
			}
		}

		if (empty($_POST["cvv"])) {
			$cvvErr = "CVV is required";
		} else {
			$cvv = test_input($_POST["cvv"]);
			if (!preg_match("/^[0-9]{3}$/",$cvv)) {
			$cvvErr = "Only 3 numbers allowed"; 
			}
		} 
	} elseif( (!empty($_POST["PaymentMethodOption"]) && ($_POST["PaymentMethodOption"] == 'Cash') )) {
		$paymentMethod = test_input($_POST["PaymentMethodOption"]);
	} else {
		$paymentMethodErr = "Payment method not valid";
	}
	
	
	
	if($paymentMethodErr =="" && $paymentDurationErr == "" && $nameErr == "" && $cardNumberErr == "" && $cvvErr == "" && $durationErr == "" && $paymentMethodErr ==""){
	$stmt = $connect->prepare("INSERT INTO student_payment (paymentYear,userID,totalAmount,discount,amountPaid,startDate,endDate,paymentMethod,cashNote)
									VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

	$stmt->bind_param("iiiiissss", $paymentYear, $userID, $totalAmount, $discount, $amountPaid, $startDate, $endDate, $paymentMethod, $cashNote);

			$paymentYear=date("Y");
			$userID=$_SESSION['userSession'];
			$totalAmount=$totalAmount;
			$discount=$discount;
			$amountPaid=$amountPaid;
			$startDate=$startDate;
			$endDate=$newdate1;
			$paymentMethod=$paymentMethod;
			//
			if($paymentMethod=='Cash'){$cashNote='0';}elseif($paymentMethod=='Card'){$cashNote=NULL;}
			$cashNote=$cashNote;
			//

	$stmt->execute();
	
	$stmt->close();
	header("Location: payments.php");
	}

}



function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
function validateMonth($date){
	$d = DateTime::createFromFormat('Y-m', $date);
	if($d && $d->format('Y-m') == $date){
	  return true;
	}else{
		return false;
	}
}

$connect->close();
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
									<input disabled value="<?php echo $duration;?>" name="validTill" id="validTill" type="month" class="form-control" id="inputValidTill" placeholder="month/year">
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
									<input disabled value="<?php echo $cvv;?>" type="number" class="form-control" name = "cvv" id="cvv" placeholder="xxx" required="" maxlength="3" pattern="([0-9]|[0-9]|[0-9])" autocomplete="off" >
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
    document.getElementById("DiscountPercentage").innerHTML = "0 %";
	document.getElementById("TotalPayment").innerHTML = "<?php echo "Rs " .$dueAmount; ?>";	
}
</script>
<!-- footer -->
<?php include('includes/footer.php'); ?>
<!-- //footer -->
<?php include('includes/bottom-footer.php'); ?>