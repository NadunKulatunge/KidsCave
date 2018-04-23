<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if(!$user_login->is_logged_in())
{
	$user_login->redirect('index.php');
}

$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!-- top html header -->
<?php include('includes/top-header.php'); ?>
<!-- //top html header -->
<!-- header -->
<?php include('includes/header.php'); ?>
<!-- //header -->
<div style="min-height: calc(100vh - 190px); margin-top: 1em; margin-bottom:3em;">
	<div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Attendance</h1></div><br>
		<div class="row" >
			<!-- left panel -->
			<?php include('includes/left-panel.php'); ?>
			<!-- //left panel -->
			<!-- right panel -->
			<div class="col-md-9" >
				<form action="">
					<select name="class1" onchange="showClass(this.value)">
						<option value=0>Select the Class:</option>
						<option  name='cl' value=1>ClassA</option>
						<option name='cl' value=2>ClassB</option>
						<option  name='cl' value=3>ClassC</option>
					</select>
				</form>
				<span id="txtHint"></span>
				<div id="result2"></div>
				<div id="result"></div>
				<div class="well">
				<button type="button" class="btn btn-primary" id='total'>Total Students</button>
				<label id="st"></label>
				</div>

			</div>
			<!-- right panel -->
		</div>
	</div>
</div>
<script>
function showClass(int) {
    if (int!=0) {
			
			console.log(int) ;
          
           $.ajax({  
                url:"attendance_ajax_show.php",  
                method:"POST",  
                data:{int:int}, 
 
                success:function(data){  
                     $('#result2').html(data);  
                }  
           });
		}  
}
</script>
<script>

$(document).ready(function(){
	//if (document.getElementsByClassName("a").checked){
		//console.log(document.getElementsByClassName("a").checked)
	$(document).on('click','input[type="radio"]', function(){
	//$('input[type="radio"]').click(function(){ 
		if (this.checked) {
			var cl= $('select[name=class1]').val();
			console.log(cl) ;
           var status1 = $(this).val();
			var id = $(this).attr("id"); 
		   console.log(id) 
           $.ajax({  
                url:"attendance_ajax_submit.php",  
                method:"POST",  
                data:{status1:status1,id:id,cl:cl}, 
 
                success:function(data){  
                     $('#result').html(data);  
                }  
           });
		}  
      });
	 
});
</script>
<script>

$(document).ready(function(){
	$(document).on('click','.update', function(){
		if (document.getElementsByClassName("a").checked){
			var id = $(this).attr("id"); 
		   console.log(id) 
           $.ajax({  
                url:"attendance_ajax_submit.php",  
                method:"POST",  
                data:{id:id}, 
 
                success:function(data){  
                     $('#result').html(data);  
                }  
           }); 
		} 
      });  
	  $('#total').click(function(){ 
		  var cl=  $('select[name=class1]').val();
		$.ajax({
            method: "POST",
            url: "attendance_ajax_total.php",
			data:{cl:cl}, 
            success:function(data){
				$('#st').html(data);
            }
        }); 
      });
});
</script>

<!-- footer -->
<?php include('includes/footer.php'); ?>
<!-- //footer -->
<?php include('includes/bottom-footer.php'); ?>
