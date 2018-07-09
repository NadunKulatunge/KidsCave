<?php

$output = '';
$total = 0;
$amountpaid = 0;
$newdate1='2012-01-01'; //default for date

/**get users earlier payments**/

$sql1 = "SELECT totalAmount,startDate,endDate FROM `student_payment` where paymentYear='".date("Y")."' AND userID='".$_SESSION['userSession']."' ORDER BY endDate ASC";
$result1 = mysqli_query($connect, $sql1);

if(mysqli_num_rows($result1) > 0){      //user has done payments
    while($row1 = mysqli_fetch_array($result1)){       //calculate total amount user has payed (Termly / Yearly)
        $amountpaid = $amountpaid + $row1["totalAmount"];
        $startDate = $row1["endDate"];
    }

}else{      //user has'nt done any payments
    $amountpaid = 0;
    $startDate = date("Y").'-01-01';
}

/**get users payment detailed description**/

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

    //payment description table made by admin
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
    //if admin has'nt provided payment info
    $output .= '  
                          <tr>  
                               <td colspan="4">Data not Found</td>  
                          </tr>  
                     ';

}




/**add users payments to database**/

$paymentMethodErr = $paymentDurationErr = $nameErr = $cardNumberErr = $cvvErr = $durationErr = $paymentMethodErr ="";
$paymentMethod = $paymentDuration = $name = $cardNumber = $cvv = $duration = $paymentMethod = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Validations
    if ( (int)($dueAmount)<=0 ){
        $paymentDurationErr = "Sorry you don't have any due payments";

    } elseif(empty($_POST["PaymentDurationOption"])){
        $paymentDurationErr = "Select payment duration";

    } elseif( ($amountpaid != 0) && ($_POST["PaymentDurationOption"]=="Year") ) {
        $paymentDurationErr = "You cannot pay for a year";

    } elseif( ($_POST["PaymentDurationOption"]=="Year") ){ //Payment for Year Validation
        $paymentDuration = $_POST["PaymentDurationOption"];
        $newdate1 = strtotime ( '+12 months' , strtotime($startDate) ) ; //adding 12 months into start date
        $newdate1 = date ( 'Y-m-j' , $newdate1 );

        $totalAmount = $total; //amount user has to pay before discount
        $discount = 15; //discount for year payments
        $amountPaid = ($total*0.85); //amount user has to pay after discount


    }elseif( ($_POST["PaymentDurationOption"]=="Term") ){	//Payment for Term Validation
        $paymentDuration = $_POST["PaymentDurationOption"];
        $newdate1 = strtotime ( '+4 months' , strtotime($startDate) ) ; //adding 4 months into start date
        $newdate1 = date ( 'Y-m-j' , $newdate1 );


        if($dueAmount<($total/3)){ //due amount is less than normal term payment
            $totalAmount = $dueAmount; //amount user has to pay before discount
            $discount = 0;
            $amountPaid = $dueAmount; //amount user has to pay after discount
        }else{
            $totalAmount = $total/3; //amount user has to pay before discount
            $discount = 0;
            $amountPaid = $total/3; //amount user has to pay after discount
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


    //add payment info to database
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