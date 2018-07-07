<!--$sql="SELECT * FROM user WHERE id = '".$q."'";-->
<?php


$con = mysqli_connect("localhost", "root", "", "kidscave");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));

}
mysqli_select_db($con,"kidscave");
?>
<table class="table table-hover">
    <tr>
    <thead class="thead-dark">
        <th>studentID</th>
        <th>StudentName</th>
        <th>Present</th>
        <th>Absent</th>
        <th>Informed</th>
    </thead>
    </tr>
<?php 
    $result = mysqli_query(mysqli_connect("localhost", "root", "", "kidscave"),"SELECT classID,studentID,studentNAME FROM student  WHERE classID='".$_POST['int']."' ");
    $counter=0;
    $query2="SELECT studentName FROM student WHERE (classID='".$_POST['int']."' AND MONTH(birthday) = MONTH(NOW()) AND DAY(birthday) = DAY(NOW()) )";
      $result2=mysqli_query($con,$query2);
      $row = mysqli_fetch_array($result2);
      ?>
      <?php if(mysqli_num_rows($result2) > 0){?>
      <script>
            alert("Today is  <?php echo $row["studentName"]?>'s Birthday!!!")
      </script>
    
      <?php }
    while($row = mysqli_fetch_array($result)) 
    { $counter++?>
    <div class='div1'>
    <tr >
    
        <td id='studentID' ><?php echo $row['studentID']?></td>
        <td> <?php echo $row['studentNAME'] ?></td>
        <td >  <input type="radio" name='<?php echo $counter; ?>' id=<?php echo $row["studentID"] ?> value="present">Present</td>
        <td > <input type="radio" name='<?php echo $counter; ?>' id=<?php echo $row["studentID"] ?> value="absent">Absent </td>
        <td >  <input type="radio" name='<?php echo $counter; ?>' id=<?php echo $row["studentID"] ?> value="informed">Informed</td>
    </tr>
    </div>
<?php } 
    ?>
    
</table>





<?php mysqli_close($con); ?>

