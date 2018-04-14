 <?php
 session_start();
 if(isset($_POST["action"]) && ($_SESSION['userRole']== "Principal" || $_SESSION['userRole']== "Admin") )
 {  
      $output = '';  
       include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
      if($_POST["action"] =="Add")  
      {
            $name = mysqli_real_escape_string($connect, $_POST["name"]);
            $email = mysqli_real_escape_string($connect, $_POST["email"]);
            $role = mysqli_real_escape_string($connect, $_POST["role"]);
            $gender = mysqli_real_escape_string($connect, $_POST["gender"]);
            $birthday = mysqli_real_escape_string($connect, $_POST["birthday"]);

           $procedure = "  
                CREATE PROCEDURE insertUser(IN name varchar(100), email varchar(100), role varchar(9), gender varchar(6), birthday varchar(10) )  
                BEGIN  
                INSERT INTO tbl_users(userName, userEmail, userRole, gender, birthday) VALUES (name, email, role, gender, birthday);   
                END;  
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS insertUser"))
           {  
                if(mysqli_query($connect, $procedure))  
                {  
                     $query = "CALL insertUser('".$name."', '".$email."', '".$role."', '".$gender."', '".$birthday."')";
                     mysqli_query($connect, $query);  
                     echo 'Data Inserted';  
                }  
           }  
      }
      if($_POST["action"] == "Edit")  
      {  
            $name = mysqli_real_escape_string($connect, $_POST["name"]);
            $email = mysqli_real_escape_string($connect, $_POST["email"]);
            $role = mysqli_real_escape_string($connect, $_POST["role"]);
            $gender = mysqli_real_escape_string($connect, $_POST["gender"]);
            $birthday = mysqli_real_escape_string($connect, $_POST["birthday"]);

           $procedure = "  
                CREATE PROCEDURE updateUser(IN ID int(11), name varchar(100), email varchar(100), role varchar(9), gender varchar(6), birthday varchar(10) )  
                BEGIN   
                UPDATE tbl_users SET userName = name, userEmail = email, userRole = role, gender = gender, birthday = birthday
                WHERE userID = ID;  
                END;   
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS updateUser"))
           {  
                if(mysqli_query($connect, $procedure))  
                {  
                     $query = "CALL updateUser('".$_POST["id"]."', '".$name."', '".$email."', '".$role."', '".$gender."', '".$birthday."')";
                     mysqli_query($connect, $query);  
                     echo 'Data Updated';  
                }  
           }  
      }  
      if($_POST["action"] == "Delete")  
      {  
           $procedure = "  
           CREATE PROCEDURE deleteUser(IN ID int(11))  
           BEGIN   
           DELETE FROM tbl_users WHERE userID = ID;  
           END;  
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS deleteUser"))
           {  
                if(mysqli_query($connect, $procedure))  
                {  
                     $query = "CALL deleteUser('".$_POST["id"]."')";
                     mysqli_query($connect, $query);  
                     echo 'Data Deleted';
                }  
           }  
      }
     if($_POST["action"] == "Approve" && $_SESSION['userRole']== "Admin")
     {
         $procedure = "  
                CREATE PROCEDURE adminApproveUser(IN ID int(11))  
                BEGIN   
                UPDATE tbl_users SET adminApprove = '1' WHERE userID = ID;  
                END;   
           ";
         if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS adminApproveUser"))
         {
             if(mysqli_query($connect, $procedure))
             {
                 $query = "CALL adminApproveUser('".$_POST["id"]."')";
                 mysqli_query($connect, $query);
                 echo 'Data Updated';
             }
         }
     }
     if($_POST["action"] == "Approve" && $_SESSION['userRole']== "Principal")
     {
         $procedure = "  
                CREATE PROCEDURE principalApproveUser(IN ID int(11))  
                BEGIN   
                UPDATE tbl_users SET principalApprove = '1' WHERE userID = ID;  
                END;   
           ";
         if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS principalApproveUser"))
         {
             if(mysqli_query($connect, $procedure))
             {
                 $query = "CALL principalApproveUser('".$_POST["id"]."')";
                 mysqli_query($connect, $query);
                 echo 'Data Updated';
             }
         }
     }
 }  
 ?>