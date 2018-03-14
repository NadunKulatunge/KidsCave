 <?php  
 //select.php  
 $output = '';  
 $connect = mysqli_connect("localhost", "root", "", "kidscave");  
 if(isset($_POST["action"]))  
 {  
      $procedure = "  
      CREATE PROCEDURE selectPayment()  
      BEGIN  
      SELECT * FROM student_payment_detail ORDER BY studentPaymentDetailID DESC;  
      END;  
      ";  
      if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS selectPayment"))  
      {  
           if(mysqli_query($connect, $procedure))  
           {  
                $query = "CALL selectPayment()";  
                $result = mysqli_query($connect, $query);  
                $output .= '  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="35%">Description</th>  
                               <th width="35%">Amount</th>  
                               <th width="15%">Update</th>  
                               <th width="15%">Delete</th>  
                          </tr>  
                ';  
                if(mysqli_num_rows($result) > 0)  
                {  
                     while($row = mysqli_fetch_array($result))  
                     {  
                          $output .= '  
                               <tr>  
                                    <td>'.$row["description"].'</td>  
                                    <td>'.$row["totalAmount"].'</td>  
                                    <td><button type="button" name="update" id="'.$row["studentPaymentDetailID"].'" class="update btn btn-warning btn-xs">Update</button></td>  
                                    <td><button type="button" name="delete" id="'.$row["studentPaymentDetailID"].'" class="delete btn btn-danger btn-xs">Delete</button></td>  
                               </tr>  
                          ';  
                     }  
                }  
                else  
                {  
                     $output .= '  
                          <tr>  
                               <td colspan="4">Data not Found</td>  
                          </tr>  
                     ';  
                }  
                $output .= '</table>';  
                echo $output;  
           }  
      }  
 }  
 ?>