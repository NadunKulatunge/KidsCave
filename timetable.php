<?php
session_start();
require_once 'class.user.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
$user_login = new USER();


if(!$user_login->is_logged_in())
{
	$user_login->redirect('index.php');
}
if($_SESSION['userRole']== "Admin" && $_SESSION['userRole']== "Principal" ){
	$user_login->redirect('../backend/payments.php');
}


?>

<!-- top html header -->
<?php include('includes/top-header.php'); ?>
<!-- //top html header -->
<!-- header -->
<?php include('includes/header.php'); ?>
<!-- //header -->
<div style="min-height: calc(100vh - 190px); margin-top: 1em; margin-bottom:3em;">
	<div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Timetable</h1></div><br>
		<div class="row" >
			<!-- left panel -->
			<?php include('includes/left-panel.php'); ?>
			<!-- //left panel -->
			<!-- right panel -->
			
			<div class="col-md-9">
			
				<label>Select Class:</label>  
					<input type="radio" value =1 name="class1" id=1 />Class A
					<input type="radio"  value =2 name="class1" id=2 />Class B 
					<input type="radio" value =3 name="class1" id=3 />Class C  
					<br />  
				<label>Select Day:</label>  
					<input type="radio" value='Monday' name="day" />Monday
					<input type="radio" value='Monday' name="day"  />Tuesday
					<input type="radio" value='Monday' name="day" />Wednesday
					<input type="radio" value='Monday' name="day" />Thursday
					<input type="radio" value='Monday' name="day" />Friday  
					<br /><br />
					<button type="button" name="action" id="action" class="btn btn-primary" style="width:25%;">Get Time Table</button>
			<span id="txtHint"></span>
			</div>
			<!-- right panel -->
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
$('#action').click(function(){ 
		   var class1=$('input[name=class1]:checked').val(); 
           //var class1 = $('class1').attr('id');  
           var day =$('input[name=day]:checked').val();
		   console.log(class1) 
		   console.log(day)   
           if(class1 != '' && day != ''){  
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
});
</script>
<!-- footer -->
<?php include('includes/footer.php'); ?>
<!-- //footer -->
<?php include('includes/bottom-footer.php'); ?>