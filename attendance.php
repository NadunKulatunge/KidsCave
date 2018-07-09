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
					<select name="class" onchange="showClass(this.value)">
						<option value="">Select the Class:</option>
						<option value="classA">ClassA</option>
						<option value="classB ">ClassB</option>
						<option value="classC">ClassC</option>
					</select>
				</form>
				<span id="txtHint"></span>
				<div id="result"></div>
			</div>
			<!-- right panel -->
		</div>
	</div>
</div>
<script>
function showClass(str) {
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
		//console.log(xmlhttp)
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "attendance_ajax_show.php?q=" + str, true);
        xmlhttp.send();
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
			console.log(this.checked) 
           var status1 = $(this).val();
			var id = $(this).attr("id"); 
		   console.log(id) 
           $.ajax({  
                url:"attendance_ajax_submit.php",  
                method:"POST",  
                data:{status1:status1,id:id}, 
 
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
});
</script>

<!-- footer -->
<?php include('includes/footer.php'); ?>
<!-- //footer -->
<?php include('includes/bottom-footer.php'); ?>
