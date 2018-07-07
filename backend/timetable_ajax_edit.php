



<?php 

$con = mysqli_connect("localhost", "root", "", "kidscave");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));

};
$sql=
 mysqli_query(mysqli_connect("localhost", "root", "", "kidscave"),"UPDATE class_period SET periodID='".$_POST['id']."' WHERE (classID='".$_POST['class2']."' AND dayName ='".$_POST['day']."' AND fromTime='".$_POST['time1']."')");
 if ($sql){?>
     <script>
     alert("Successful!!")
     </script>

<?php } else{?>
    <script>
    alert("You have to try again")
    </script>

<?php }

                                                      
?>
<?php mysqli_close($con); ?>