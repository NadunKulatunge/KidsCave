 <?php  
 //fetch.php  
 $connect = mysqli_connect("localhost","root", "", "kidscave");  
 if(isset($_POST["id"]))  
 {  
      $output = array();  
      $procedure = "  
      CREATE PROCEDURE wherePayment(IN payment_id int(11))  
      BEGIN   
      SELECT * FROM student_payment_detail WHERE studentPaymentDetailID = payment_id;  
      END;   
      ";  
      if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS wherePayment"))  
      {  
           if(mysqli_query($connect, $procedure))  
           {  
                $query = "CALL wherePayment(".$_POST["id"].")";  
                $result = mysqli_query($connect, $query);  
                while($row = mysqli_fetch_array($result))  
                {  
                     $output['description'] = $row["description"];  
                     $output['totalAmount'] = $row["totalAmount"];  
                }  
                echo json_encode($output);  
           }  
      }  
 }  
 ?>  