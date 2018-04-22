 <?php  
 
 $output = '';  
 include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
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
                               <th width="35%" class="text-center">Description</th>  
                               <th width="35%" class="text-center">Amount (Rs)</th>  
                               <th width="15%" class="text-center">Update</th>  
                               <th width="15%" class="text-center">Delete</th>  
                          </tr>  
                ';  
                if(mysqli_num_rows($result) > 0)  
                {  
                     while($row = mysqli_fetch_array($result))  
                     {  
                          $output .= '  
                               <tr>  
                                    <td>'.$row["description"].'</td>  
                                    <td  class="text-right">'.number_format($row["totalAmount"],2).'</td>  
                                    <td class="text-center"><button type="button" name="update" id="'.$row["studentPaymentDetailID"].'" class="update btn btn-warning btn-xs">Update</button></td>  
                                    <td class="text-center"><button type="button" name="delete" id="'.$row["studentPaymentDetailID"].'" class="delete btn btn-danger btn-xs">Delete</button></td>  
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
 <?php
 //close connections
 include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/close_connections.php');
 ?>
