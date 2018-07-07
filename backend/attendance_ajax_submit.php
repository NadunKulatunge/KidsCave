<?php  
 $host = "localhost";  
 $username = "root";  
 $password = "";  
 $database = "kidscave";  
 try  
 {    
    $conn = mysqli_connect("localhost", "root", "", "kidscave");
    $date=date("Y-m-d ");
      $connect = new PDO("mysql:host=$host;dbname=$database",$username, $password);  
      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
      $query1 = "SELECT * from student_attendance where (studentID ='$_POST[id]' AND `date`='$date')";
 if ($result1=mysqli_query($conn,$query1))
  {
   if(mysqli_num_rows($result1) > 0)

    {
      ?>
     <script >
       alert('You have changed status');
         
       <?php  $sql = "UPDATE student_attendance SET status='".$_POST['status1']."' WHERE (studentID ='".$_POST['id']."' AND `date`='$date')"; 
        $connect->exec($sql);    ?>
        var txt = "You pressed OK!";
     </script>
<?php    
}
  else{
  $query = "INSERT INTO student_attendance(status, studentID,date,classID) VALUES ('".$_POST['status1']."','".$_POST['id']."','$date','".$_POST['cl']."')";
      $connect->exec($query);
      
  }
  }
else{
    echo "Query Failed.";
 }
}  
 catch(PDOException $error)  
 {  
      echo $error->getMessage();  
 }
  
 ?> 