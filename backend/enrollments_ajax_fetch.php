 <?php
 session_start();
 include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
 if(isset($_POST["id"]) && ($_SESSION['userRole']== "Principal" || $_SESSION['userRole']== "Admin") )
 {  
      $output = array();  
      $procedure = "  
      CREATE PROCEDURE whereUser(IN ID int(11))  
      BEGIN   
          SELECT * FROM tbl_users WHERE userID = ID;
      END;   
      ";  
      if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS whereUser"))
      {  
           if(mysqli_query($connect, $procedure))  
           {  
                $query = "CALL whereUser(".$_POST["id"].")";
                $result = mysqli_query($connect, $query);
                while($row = mysqli_fetch_array($result))  
                {  
                    $output['name'] = $row["userName"];
                    $output['email'] = $row["userEmail"];
                    $output['role'] = $row["userRole"];
                    $output['gender'] = $row["gender"];
                    $output['birthday'] = $row["birthday"];
                    $output['phone'] = $row["userPhone"];
                    $output['classroom'] = $row["classID"];
                }  
                echo json_encode($output);  
           }  
      }  
 }  
 ?>
 <?php
 //close connections
 include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/close_connections.php');
 ?>