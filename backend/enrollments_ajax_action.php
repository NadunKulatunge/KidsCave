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
            $phone = mysqli_real_escape_string($connect, $_POST["phone"]);
            $classroom = mysqli_real_escape_string($connect, $_POST["classroom"]);

           $procedure = "  
                CREATE PROCEDURE insertUser(IN name varchar(100), email varchar(100), role varchar(9), gender varchar(6), birthday varchar(10), phone varchar(12), classroom int(11) )  
                BEGIN 
                    INSERT INTO tbl_users(userName, userEmail, userRole, classID, gender, birthday, userPhone) VALUES (name, email, role, classroom, gender, birthday, phone);
                END;  
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS insertUser"))
           {  
                if(mysqli_query($connect, $procedure))  
                {  
                    $query = "CALL insertUser('".$name."', '".$email."', '".$role."', '".$gender."', '".$birthday."', '".$phone."', '".$classroom."')";
                     mysqli_query($connect, $query);
                      echo 'New user created';
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
            $phone = mysqli_real_escape_string($connect, $_POST["phone"]);
            $classroom = mysqli_real_escape_string($connect, $_POST["classroom"]);

           $procedure = "  
                CREATE PROCEDURE updateUser(IN ID int(11), name varchar(100), email varchar(100), role varchar(9), gender varchar(6), birthday varchar(10), phone varchar(12), classroom int(11) )  
                BEGIN
                    UPDATE tbl_users SET userName = name, userEmail = email, userRole = role, classID = classroom, gender = gender, birthday = birthday, userPhone = phone WHERE userID = ID;        
                END;   
           ";
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS updateUser"))
           {  
                if(mysqli_query($connect, $procedure))  
                {  
                    $query = "CALL updateUser('".$_POST["id"]."', '".$name."', '".$email."', '".$role."', '".$gender."', '".$birthday."', '".$phone."', '".$classroom."')";
                     mysqli_query($connect, $query);  
                     echo 'Data Updated';  
                }  
           }  
      }  
      if($_POST["action"] == "Disapprove" && $_SESSION['userRole']== "Admin")
      {  
           $procedure = "  
           CREATE PROCEDURE adminDisapproveUser(IN ID int(11))  
           BEGIN   
                UPDATE tbl_users SET adminApprove = '0' WHERE userID = ID;  
           END;  
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS adminDisapproveUser"))
           {  
                if(mysqli_query($connect, $procedure))  
                {  
                     $query = "CALL adminDisapproveUser('".$_POST["id"]."')";
                     mysqli_query($connect, $query);  
                     echo 'User Disapproved';
                }  
           }  
      }
     if($_POST["action"] == "Disapprove" && $_SESSION['userRole']== "Principal")
     {
         $procedure = "  
           CREATE PROCEDURE principalDisapproveUser(IN ID int(11))  
           BEGIN   
                UPDATE tbl_users SET principalApprove = '0' WHERE userID = ID;  
           END;  
           ";
         if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS principalDisapproveUser"))
         {
             if(mysqli_query($connect, $procedure))
             {
                 $query = "CALL principalDisapproveUser('".$_POST["id"]."')";
                 mysqli_query($connect, $query);
                 echo 'User Disapproved';
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
                 echo 'User Approved';
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
                 echo 'User Approved';
             }
         }
     }
 }  
 ?>