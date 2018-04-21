 <?php
 session_start();
 require_once 'validator_functions.php';
 $Err = "";

 if(isset($_POST["action"]) && ($_SESSION['userRole']== "Principal" || $_SESSION['userRole']== "Admin") ) {
      $output = '';  
       include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
      if($_POST["action"] =="Add") {

          $name = test_input($_POST["name"]);
          $email = test_input($_POST["email"]);
          $role = test_input($_POST["role"]);
          $gender = test_input($_POST["gender"]);
          $birthday = test_input($_POST["birthday"]);
          $phone = test_input($_POST["phone"]);
          $classroom = test_input($_POST["classroom"]);

          //validate
          if(!valid_name($name)){
              $Err = "Invalid name";
          }elseif(!valid_email($email)){
              $Err = "Invalid email";
          }elseif(!isAvailable_email($email,$connect)){
              $Err = "Email address is available";
          }elseif(!valid_role($role)){
              $Err = "Invalid role";
          }elseif(!valid_gender($gender)){
              $Err = "Invalid gender";
          }elseif(!valid_date($birthday)){
              $Err = "Invalid birthday";
          }elseif(!valid_phone($phone)){
              $Err = "Invalid phone";
          }elseif(!valid_classroom((int)$classroom,$connect)){
              $Err = "Invalid classroom";
          }

           $procedure = "  
                CREATE PROCEDURE insertUser(IN name varchar(100), email varchar(100), role varchar(9), gender varchar(6), birthday varchar(10), phone varchar(12), classroom int(11) )  
                BEGIN 
                    INSERT INTO tbl_users(userName, userEmail, userRole, classID, gender, birthday, userPhone) VALUES (name, email, role, classroom, gender, birthday, phone);
                END;  
           ";  
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS insertUser")) {

               if($Err=="") {
                   if (mysqli_query($connect, $procedure)) {
                       $query = "CALL insertUser('" . $name . "', '" . $email . "', '" . $role . "', '" . $gender . "', '" . $birthday . "', '" . $phone . "', '" . $classroom . "')";
                       mysqli_query($connect, $query);
                       echo 'New user created';
                   }
               }else{
                    echo $Err;
                    $Err= "";
                }
           }  
      }
      if($_POST["action"] == "Edit") {
          $name = test_input($_POST["name"]);
        //$email = test_input($_POST["email"]);
          $role = test_input($_POST["role"]);
          $gender = test_input($_POST["gender"]);
          $birthday = test_input($_POST["birthday"]);
          $phone = test_input($_POST["phone"]);
          $classroom = test_input($_POST["classroom"]);

            //validate
          if(!valid_name($name)){
              $Err = "Invalid name";
          }elseif(!valid_role($role)){
              $Err = "Invalid role";
          }elseif(!valid_gender($gender)){
              $Err = "Invalid gender";
          }elseif(!valid_date($birthday)){
              $Err = "Invalid birthday";
          }elseif(!valid_phone($phone)){
              $Err = "Invalid phone";
          }elseif(!valid_classroom((int)$classroom,$connect)){
              $Err = "Invalid classroom";
          }
           $procedure = "  
                CREATE PROCEDURE updateUser(IN ID int(11), name varchar(100), role varchar(9), gender varchar(6), birthday varchar(10), phone varchar(12), classroom int(11) )  
                BEGIN
                    UPDATE tbl_users SET userName = name, userRole = role, classID = classroom, gender = gender, birthday = birthday, userPhone = phone WHERE userID = ID;        
                END;   
           ";
           if(mysqli_query($connect, "DROP PROCEDURE IF EXISTS updateUser")) {
               if($Err=="") {
                   if (mysqli_query($connect, $procedure)) {
                       $query = "CALL updateUser('" . $_POST["id"] . "', '" . $name . "', '" . $role . "', '" . $gender . "', '" . $birthday . "', '" . $phone . "', '" . $classroom . "')";
                       mysqli_query($connect, $query);
                       echo 'Data Updated';
                   }
               } else {
                   echo $Err;
                   $Err= "";
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