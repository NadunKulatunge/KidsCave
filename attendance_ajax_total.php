
<?php 
$con = mysqli_connect("localhost", "root", "", "kidscave");
$date=date("Y-m-d ");

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));};
    
$sql="SELECT COUNT(studentAttendanceID)
    FROM student_Attendance
    WHERE state='present' AND `date`='$date' AND classID='".$_POST['cl']."'";
    $result=0;
$result = mysqli_query(mysqli_connect("localhost", "root", "", "kidscave"),"SELECT COUNT(studentAttendanceID) c FROM student_attendance WHERE   ( `status`='present' AND `date`='$date' AND classID='".$_POST['cl']."')");
$row = mysqli_fetch_assoc($result);
echo $row['c'];
 

                                                      
?>
<?php mysqli_close($con); ?>