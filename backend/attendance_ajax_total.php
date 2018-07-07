
<?php 
$con = mysqli_connect("localhost", "root", "", "kidscave");
$date=date("Y-m-d ");

if (!$con) {
    die('Could not connect: ' . mysqli_error($con));};?>
 <?php   
$sql="SELECT COUNT(studentAttendanceID)
    FROM student_Attendance
    WHERE state='present' AND `date`='$date' AND classID='".$_POST['cl']."'";
    $result=0;
//count students in class
$result0 = mysqli_query($con,"SELECT COUNT(studentID) idcount FROM student WHERE   (  classID='".$_POST['cl']."')");
$row0 = mysqli_fetch_assoc($result0);
$classCount=$row0['idcount'];
//count the marked attendance 
$result2 = mysqli_query($con,"SELECT COUNT(studentAttendanceID) marked FROM student_attendance WHERE   (  `date`='$date' AND classID='".$_POST['cl']."')");
$row2 = mysqli_fetch_assoc($result2);
$markedno=$row2['marked'];
if ($classCount==$markedno){//check all studence attendance have marked
//count attendance
    $result = mysqli_query($con,"SELECT COUNT(studentAttendanceID) c FROM student_attendance WHERE   ( `status`='present' AND `date`='$date' AND classID='".$_POST['cl']."')");
    $row = mysqli_fetch_assoc($result);
    echo $row['c']; 
}
 else{ ?>
    <script>
        alert("Mark the all students attendance")

    </script>
<?php  }  

mysqli_close($con); ?>