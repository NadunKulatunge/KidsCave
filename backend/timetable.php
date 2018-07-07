<?php

session_start();
require_once 'class.user.php';
$user_login = new USER();

if(!$user_login->is_logged_in()){
	$user_login->redirect('../index.php');
}

//Allowed only Admin && Principal userRole
if($_SESSION['userRole']!= "Admin" && $_SESSION['userRole']!= "Principal" ){
	$user_login->redirect('../timetable.php');
}

$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);


?>
<style>
.button2:hover {
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
}
news{display: none;}
.well{display: none;}
.btn-primary{
    
    width: 75%;
}
</style>


<!-- top html header -->
<?php include('../includes/top-header.php'); ?>
<!-- //top html header -->
<!-- header -->
<?php include('../includes/header.php'); ?>
<!-- //header -->
<div style="min-height: calc(100vh - 190px); margin-top: 1em; margin-bottom:3em;">
	<div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Payments</h1></div><br>
		<div class="row"  >
			<!-- left panel -->
			<?php include('../includes/left-panel.php'); ?>
			<!-- //left panel -->
			<!-- right panel -->
			<div class="col-md-9" text-center>
			<button class="btn btn-primary" id='edt' >Edit TimeTable</button></br></br>
			<div class='well' id='edit'>			
										
			</div>
			<button class="btn btn-primary" id='new' onclick="myFunction2()">Add New Subject</button></br></br>
			<div class ="well" name='news' id='news'>
				<label>New Subject Name:</label>
					<input type='text' name="subject"></br>
        
                <?php //load teacher
                $result = mysqli_query(mysqli_connect("localhost", "root", "", "kidscave"),"SELECT userName, userID FROM tbl_users WHERE (userRole='Teacher')   ");
                $counter2=0;
                echo '<label>Select Teacher Name:</label>';
                while($row = mysqli_fetch_array($result)) 
                    { $counter2++?>
    
                    <input type="radio" name='tname' id=<?php echo $row["userID"];?> value=<?php echo $row["userID"] ?>><?php echo $row["userName"] ?>

                    <?php } ?></br>
				<button type="button" class="btn btn-success btn-xs" id='add'>Add</button> </br></br>

			</div>
			<button class="btn btn-primary" id='shows' onclick="myFunction3()">View TimeTable</button></br></br>
			<div class='well' id='a' >
            <?php //load classes
            $result = mysqli_query(mysqli_connect("localhost", "root", "", "kidscave"),"SELECT classID,className FROM class  ");
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
					<br />
					
					<button type="button" class="btn btn-info btn-xs" id='view' >View</button> </br></br>
					
			</div>
			<div class ="b" id=txtHint></div>
			
            </div>
			<!-- right panel -->
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
    $("#edt").click(function(){
        $("#edit").load("timetable_ajax_loadedt.php");
        var x = document.getElementById("edit");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
    });
});
</script>
<script>
function myFunction2() {
    var x = document.getElementById("news");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>
<script>
function myFunction3() {
    var x = document.getElementById("a");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
</script>
<script>
$(document).ready(function(){
$('#view').click(function(){ 
		   var class1=$('input[name=cname]:checked').val();  
           var day =$('input[name=day]:checked').val();
           console.log(class1)
           console.log(day)
           if(class1 != undefined && day != undefined){

                $.ajax({  
                     url : "timetable_ajax_show.php",  
                     method:"POST",  
                     data:{class1:class1,day:day},
					 success:function(data){  
                     $('#txtHint').html(data);
					 }    
                });  
           }  
           else{  
                alert("Both Fields are Required");  
           }  
      });
$('#add').click(function(){ 
		   var id=$('input[name=tname]:checked').val();  
           var sub =$('input[name=subject]').val();   
           if(id != '' && sub != ''){  
                $.ajax({  
                     url : "timetable_ajax_add.php",  
                     method:"POST",  
                     data:{id:id,sub:sub},
					 success:function(data){  
                     $('#txtHint').html(data);
					 }    
                });  
           }  
           else{  
                alert("Both Fields are Required");  
           }  
      });
$(document).on('click','#editb', function(){
			var class2=$('input[name=cname]:checked').val();  
		   var day =$('input[name=day]:checked').val(); 
		   var id=$('input[name=sname]:checked').val();
		   var time1=$('input[name=time]:checked').val(); 
		   console.log(class2,day,id,time1);  
           if(id != undefined &&  class2 != undefined && day != undefined && time1 != undefined){  
                $.ajax({  
                     url : "timetable_ajax_edit.php",  
                     method:"POST",  
                     data:{id:id,class2:class2,day:day,time1:time1},
                     success:function(data){  
                     $('#txtHint').html(data);
					 }
                });  
           }  
           else{  
                alert("All Fields are Required");  
           }
		 
      }); 
});
</script>

<!-- footer -->
<?php include('../includes/footer.php'); ?>
<!-- //footer -->
<?php include('../includes/bottom-footer.php'); ?>