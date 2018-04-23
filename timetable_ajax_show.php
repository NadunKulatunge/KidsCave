<!--$sql="SELECT * FROM user WHERE id = '".$q."'";-->


<?php
$con = mysqli_connect("localhost", "root", "", "kidscave");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"kidscave");
?>
<div>
<table class="table table-hover" >
<thead >
<th>Period Name</th>
<th>Start Time</th>
<th>End Time</th>
</thead>
<?php 
    $result = mysqli_query(mysqli_connect("localhost", "root", "", "kidscave"),"SELECT periodName,fromTime,toTime,classID,dayName FROM class_period JOIN period_detail ON class_period.periodID = period_detail.periodId WHERE (classID = '".$_POST['class1']."' AND dayName='".$_POST['day']."') ORDER BY fromTime ");
    $count=0;
    while($row = mysqli_fetch_array($result)) 
    { ?>
    <tr>
       <td><?php echo $row["periodName"] ?></td>
       <td><?php echo $row["fromTime"] ?></td>
       <td><?php echo $row["toTime"] ?></td>
    <tr>
    <?php } ?>
</table>
</div>
    
       
<?php mysqli_close($con); ?>