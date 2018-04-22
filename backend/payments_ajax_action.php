 <?php
 require_once 'validator_functions.php';
 $Err = "";

 if(isset($_POST["action"])) {
      $output = '';  
       include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
      if($_POST["action"] =="Add") {
           $description = test_input($_POST["description"]);
           $totalAmount = test_input($_POST["totalAmount"]);

          //validate
          if(!valid_payment_description($description)){
              $Err = "Invalid description";
          }elseif(!valid_payment_amount($totalAmount)){
              $Err = "Invalid amount";
          }

           $procedure = "  
                CREATE PROCEDURE insertPayment(IN description varchar(250), totalAmount varchar(250))  
                BEGIN  
                INSERT INTO student_payment_detail(description, totalAmount) VALUES (description, totalAmount);   
                END;  
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS insertPayment")) {

               if($Err=="") {
                   if (mysqli_query($connect, $procedure)) {
                       $query = "CALL insertPayment('" . $description . "', '" . $totalAmount . "')";
                       mysqli_query($connect, $query);
                       echo 'Data Inserted';
                   }
               }else{
                   echo $Err;
                   $Err= "";
               }
           }  
      }
      if($_POST["action"] == "Edit") {
           $description = test_input($_POST["description"]);
           $totalAmount = test_input($_POST["totalAmount"]);

          //validate
          if(!valid_payment_description($description)){
              $Err = "Invalid description";
          }elseif(!valid_payment_amount($totalAmount)){
              $Err = "Invalid amount";
          }

           $procedure = "  
                CREATE PROCEDURE updatePayment(IN payment_id int(11), description varchar(250), totalAmount varchar(250))  
                BEGIN   
                UPDATE student_payment_detail SET description = description, totalAmount = totalAmount  
                WHERE studentPaymentDetailID = payment_id;  
                END;   
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS updatePayment")) {
                if(mysqli_query($connect, $procedure)) {
                     $query = "CALL updatePayment('".$_POST["id"]."', '".$description."', '".$totalAmount."')";  
                     mysqli_query($connect, $query);  
                     echo 'Data Updated';  
                }  
           }  
      }  
      if($_POST["action"] == "Delete") {
           $procedure = "  
           CREATE PROCEDURE deletePayment(IN payment_id int(11))  
           BEGIN   
           DELETE FROM student_payment_detail WHERE studentPaymentDetailID = payment_id;  
           END;  
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS deletePayment")) {

               if($Err=="") {
                   if (mysqli_query($connect, $procedure)) {
                       $query = "CALL deletePayment('" . $_POST["id"] . "')";
                       mysqli_query($connect, $query);
                       echo 'Data Deleted';
                   }
               }else{
                   echo $Err;
                   $Err= "";
               }
           }  
      }  
 }  
 ?>
 <?php
 //close connections
 include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/close_connections.php');
 ?>
