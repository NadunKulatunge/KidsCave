<!--$sql="SELECT * FROM user WHERE id = '".$q."'";-->
<?php
$con = mysqli_connect("localhost", "root", "", "kidscave");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"kidscave");
?>

<?php 
    $result = mysqli_query(mysqli_connect("localhost", "root", "", "kidscave"),"SELECT periodName,fromTime,toTime,classID,dayName FROM class_period JOIN period_detail ON class_period.periodID = period_detail.periodId WHERE (classID = '".$_POST['class1']."' AND dayName='".$_POST['day']."') ORDER BY fromTime ");
    $count=0;
     echo 'ffffffffff' ;
    while($row = mysqli_fetch_array($result)) 
    { ?>
       <?php echo $row["periodName"] ?>
       <?php echo $row["fromTime"] ?>
       <?php echo $row["toTime"] ?>
    <?php } ?>
       
<?php mysqli_close($con); ?>

