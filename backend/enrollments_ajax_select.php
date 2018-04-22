 <?php
 session_start();
 $output = '';  
 include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
 if(isset($_POST["action"])  && ($_SESSION['userRole']== "Principal" || $_SESSION['userRole']== "Admin") )
 {
     if($_SESSION['userRole']== "Admin") {
         $procedure = "  
              CREATE PROCEDURE selectUsers()  
              BEGIN  
              SELECT * FROM tbl_users WHERE adminApprove IS NULL ORDER BY userID ASC;  
              END;  
              ";
     }elseif($_SESSION['userRole']== "Principal") {
         $procedure = "  
              CREATE PROCEDURE selectUsers()  
              BEGIN  
              SELECT * FROM tbl_users WHERE principalApprove IS NULL ORDER BY userID ASC; 
              END;  
              ";
     }
      if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS selectUsers"))
      {  
           if(mysqli_query($connect, $procedure))  
           {  
                $query = "CALL selectUsers()";
                $result = mysqli_query($connect, $query);  
                $output .= '  
                     <table class="table table-bordered">  
                          <tr>  
                               <th>Name</th>  
                               <th>Email</th> 
                               <th>UserRole</th> 
                               <th>Gender</th>
                               <th>Birthday</th>
                               <th>Phone</th>
                               <th>Edit</th>
                               <th><i class="fa fa-check"></i></th>  
                               <th><i class="fa fa-times"></i></th>  
                          </tr>  
                ';  
                if(mysqli_num_rows($result) > 0)  
                {  
                     while($row = mysqli_fetch_array($result))  
                     {  
                          $output .= '  
                               <tr>  
                                    <td>'.$row["userName"].'</td>  
                                    <td>'.$row["userEmail"].'</td>
                                    <td>'.$row["userRole"].'</td>  
                                    <td>'.$row["gender"].'</td> 
                                    <td>'.$row["birthday"].'</td> 
                                    <td>'.$row["userPhone"].'</td> 
                                    <td><button type="button" name="update" id="'.$row["userID"].'" class="update btn btn-warning btn-xs"><i class="fa fa-edit"></i></button></td>
                                    <td><button type="button" name="approve" id="'.$row["userID"].'" class="approve btn btn-success btn-xs"><i class="fa fa-check"></i></button></td>  
                                    <td><button type="button" name="disapprove" id="'.$row["userID"].'" class="disapprove btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>  
                               </tr>  
                          ';  
                     }  
                }  
                else  
                {  
                     $output .= '  
                          <tr>  
                               <td colspan="4">No Records to be Approved</td>  
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
