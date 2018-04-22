
<?php

$con = mysqli_connect("localhost", "root", "", "kidscave");
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));

}
mysqli_select_db($con,"kidscave");
?>
    <label>Select Class:</label>  
                    <input type='hidden' value='null'>
					<input type="radio" value =1 name="class1" id=1 />Class A
					<input type="radio"  value =2 name="class1" id=2 />Class B 
					<input type="radio" value =3 name="class1" id=3 />Class C  
					<br /> 
    <label>Select Day:</label>  
					<input type="radio" value='Monday' name="day" />Monday
					<input type="radio" value='Tuesday' name="day"  />Tuesday
					<input type="radio" value='Wednesday' name="day" />Wednesday
					<input type="radio" value='Thursday' name="day" />Thursday
					<input type="radio" value='Friday' name="day" />Friday  
					<br />
    <label>Select Start Time:</label>
    
                    <input type="radio" value=080000 name="time1" />08:00
					<input type="radio" value=090000 name="time1"  />09:00
					<input type="radio" value=110000 name="time1" />11:00</br>

<?php 
    $result = mysqli_query(mysqli_connect("localhost", "root", "", "kidscave"),"SELECT periodName,periodID FROM period_detail  ");
    $counter=0;
    echo '<label>New Subject Name:</label>';
    while($row = mysqli_fetch_array($result)) 
    { $counter++?>
    
    <input type="radio" name='tname' id=<?php echo $counter;?> value=<?php echo $row["periodID"] ?>><?php echo $row["periodName"] ?>

<?php } ?></br>
    <button type="button" class="btn btn-warning btn-xs" id='editb'>Edit</button> </br></br>
<?php mysqli_close($con); ?>

