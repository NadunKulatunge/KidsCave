<!--$sql="SELECT * FROM user WHERE id = '".$q."'";-->
<?php

$q = $_REQUEST["q"];
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
        <th>Absent</th>
        <th>Present</th>
        <th>Informed</th>
    </thead>
    </tr>
<?php 
    $result = mysqli_query(mysqli_connect("localhost", "root", "", "kidscave"),"SELECT className,studentID,studentNAME FROM class JOIN student ON class.classID = student.classId WHERE className = '".$q."'");
    $counter=0;
    while($row = mysqli_fetch_array($result)) 
    { $counter++?>
    <tr >
       
        <td id='studentID' ><?php echo $row['studentID']?></td>
        <td> <?php echo $row['studentNAME'] ?></td>
        <td class='a'>  <input type="radio" name='<?php echo $counter; ?>' id=<?php echo $row["studentID"] ?> value="present">Present</td>
        <td class='a'> <input type="radio" name='<?php echo $counter; ?>' id=<?php echo $row["studentID"] ?> value="absent">Absent </td>
        <td class='a'>  <input type="radio" name='<?php echo $counter; ?>' id=<?php echo $row["studentID"] ?> value="informed">Informed</td>
    </tr>
<?php } ?>
</table>





<?php mysqli_close($con); ?>

