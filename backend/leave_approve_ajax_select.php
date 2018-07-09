<?php

session_start();
$output = '';
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
if(isset($_POST["action"])  && ($_SESSION['userRole']== "Principal" ) )
{
    if($_SESSION['userRole']== "Principal") {

        $procedure = "  
              CREATE PROCEDURE selectUsers()  
              BEGIN  
              SELECT * FROM leave_user WHERE principalApprove IS NULL ORDER BY userLeaveID ASC; 
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
                               <th>User ID</th>    
                               <th>UserRole</th> 
                               <th>Date</th>
                               <th>Reason</th>                                                           
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
                                    <td>'.$row["name"].'</td> 
                                    <td>'.$row["userID"].'</td> 
                                    <td>'.$row["role"].'</td>
                                    <td>'.$row["date"].'</td>  
                                    <td>'.$row["reason"].'</td>                                                                        
                                    <td><button type="button" name="approve" id="'.$row["userLeaveID"].'" class="approve btn btn-success btn-xs"><i class="fa fa-check"></i></button></td>  
                                    <td><button type="button" name="disapprove" id="'.$row["userLeaveID"].'" class="disapprove btn btn-danger btn-xs"><i class="fa fa-times"></i></button></td>  
                               </tr>  
                          ';
                }
            }
            else
            {
                $output .= '  
                          <tr>  
                               <td colspan="4">No Leave Records to be Approved</td>  
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
