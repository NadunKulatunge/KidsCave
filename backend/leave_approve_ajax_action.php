
<?php

session_start();
require_once 'validator_functions.php';
$Err = "";

if(isset($_POST["action"]) && ($_SESSION['userRole']== "Principal" ) ) {
    $output = '';
    include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');

    if($_POST["action"] == "Disapprove" && $_SESSION['userRole']== "Principal")
    {
        $procedure = "  
           CREATE PROCEDURE principalDisapproveUser(IN ID int(11))  
           BEGIN   
                UPDATE leave_user SET principalApprove = '0' WHERE userLeaveID = ID;  
           END;  
           ";
        if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS principalDisapproveUser"))
        {
            if(mysqli_query($connect, $procedure))
            {
                $query = "CALL principalDisapproveUser('".$_POST["id"]."')";
                mysqli_query($connect, $query);
                echo 'Leave Disapproved';
            }
        }
    }

    if($_POST["action"] == "Approve" && $_SESSION['userRole']== "Principal")
    {
        $procedure = "  
                CREATE PROCEDURE principalApproveUser(IN ID int(11))  
                BEGIN   
                UPDATE leave_user SET principalApprove = '1' WHERE userLeaveID = ID;  
                END;   
           ";
        if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS principalApproveUser"))
        {
            if(mysqli_query($connect, $procedure))
            {
                $query = "CALL principalApproveUser('".$_POST["id"]."')";
                mysqli_query($connect, $query);
                echo 'Leave Approved';
            }
        }
    }
}
?>
<?php
//close connections
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/close_connections.php');
?>
