
<?php

$con = mysqli_connect("localhost", "root", "", "kidscave");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));

}
mysqli_select_db($con,"kidscave");
?>
<?php //load classes
    $result = mysqli_query($con,"SELECT classID,className FROM class  ");
    $counter1=0;
    echo '<label>Select Class:</label>';
    while($row = mysqli_fetch_array($result)) 
    { $counter1++?>
    
    <input type="radio" name='cname' id=<?php echo $counter1;?> value=<?php echo $row["classID"] ?>><?php echo $row["className"] ?>

<?php } ?></br>

<label>Select Day:</label>  
					<input type="radio" value='Monday' name="day" />Monday
					<input type="radio" value='Tuesday' name="day"  />Tuesday
					<input type="radio" value='Wednesday' name="day" />Wednesday
					<input type="radio" value='Thursday' name="day" />Thursday
					<input type="radio" value='Friday' name="day" />Friday  
    </br>
<label>Select Start Time:</label>  
					<input type="radio" value='08:00:00' name="time" />08:00
					<input type="radio" value='09:00:00' name="time"  />09:00
					<input type="radio" value='11:00:00' name="time" />11:00

<?php //load time
    /*$result = mysqli_query($con,"SELECT fromTime FROM class_period  ");
    $counter3=0;
    echo '<label>Select Start Time :</label>';
    while($row = mysqli_fetch_array($result)) 
    { $counter3++?>
    
    <input type="radio" name='time' id=<?php echo $counter3;?> value=<?php echo $row["fromTime"] ?>><?php echo $row["fromTime"] ?>

    <?php }*/ ?></br>

<?php 
    $result = mysqli_query($con,"SELECT periodName,periodID FROM period_detail  ");
    $counter=0;
    echo '<label>New Subject Name:</label>';
    while($row = mysqli_fetch_array($result)) 
    { $counter++?>
    
    <input type="radio" name='sname' id=<?php echo $counter;?> value=<?php echo $row["periodID"] ?>><?php echo $row["periodName"] ?>

<?php } ?></br>
    <button type="button" class="btn btn-warning btn-xs" id='editb'>Edit</button> </br></br>
<?php mysqli_close($con); ?>

