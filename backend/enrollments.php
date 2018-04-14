<?php
session_start();
require_once '../class.user.php';
$user_login = new USER();

if(!$user_login->is_logged_in()){
	$user_login->redirect('../index.php');
}

//Restrict Access
if($_SESSION['userRole']!= "Principal" && $_SESSION['userRole']!= "Admin"){
    $user_login->redirect('index.php');
}

?>

<!-- top html header -->
<?php include('../includes/top-header.php'); ?>
<!-- //top html header -->
<!-- header -->
<?php include('../includes/header.php'); ?>
<!-- //header -->
<div style="min-height: calc(100vh - 190px); margin-top: 1em; margin-bottom:3em;">
	<div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Enrollments</h1></div><br>
		<div class="row" >
			<!-- left panel -->
			<?php include('../includes/left-panel.php'); ?>
			<!-- //left panel -->
			<!-- right panel -->
			<div class="col-md-9">

					<h3 align="center">Approve Enrollments</h3>
					<br /><br />    
					<label>Name</label>
					    <input type="text" name="name" id="name" class="form-control"/>
                    <br />
					<label>Email</label>
					    <input type="text" name="email" id="email" class="form-control"/>
                    <br />
                    <label>User Role</label>
                        <input type="text" name="role" id="role" class="form-control"/>
                    <br />
                    <label>Gender</label>
                        <input type="text" name="genderEdit" id="genderEdit" class="form-control"/>
                    <br />
                    <label>Birthday</label>
                        <input type="date" name="birthday" id="birthday" class="form-control"/>
					<br /><br />  
					<div align="center">  
						 <input type="hidden" name="id" id="user_id" />
						 <button type="button" name="action" id="action" class="btn btn-primary" style="width:50%;">Add</button>  
					</div>  
					<br />  
					<br />
					<div id="result" class="table-responsive" style="border: none;"></div>

			</div>
			<!-- right panel -->
		</div>
	</div>
</div>
<script>  
	$(document).ready(function(){  
		fetchUsers();
		function fetchUsers(){
           var action = "select";  
           $.ajax({  
                url : "enrollments_ajax_select.php",
                method:"POST",  
                data:{action:action},  
                success:function(data){  
                    $('#name').val('');
                    $('#email').val('');
                    $('#role').val('');
                    $('#genderEdit').val('');
                    $('#birthday').val('');
                    $('#action').text("Add");
                    $('#result').html(data);
                }  
           });  
      }  
      $('#action').click(function(){  
          var name = $('#name').val();
          var email = $('#email').val();
          var role = $('#role').val();
          var gender = $('#genderEdit').val();
          var birthday = $('#birthday').val();
          var id = $('#user_id').val();
          var action = $('#action').text();
          if(name != '' && email != ''&& role != ''&& gender != ''&& birthday != ''){
                $.ajax({
                     url : "enrollments_ajax_action.php",
                     method:"POST",
                     data:{name:name, email:email, role:role, gender:gender, birthday:birthday, id:id, action:action},
                     success:function(data){
                          alert(data);
                          fetchUsers();
                     }
                });
           }  
           else{  
                alert("Both Fields are Required");  
           }  
      });  
      $(document).on('click', '.update', function(){  
           var id = $(this).attr("id");  
           $.ajax({  
                url:"enrollments_ajax_fetch.php",
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                    $('#action').text("Edit");
                    $('#user_id').val(id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#role').val(data.role);
                    $('#genderEdit').val(data.gender);
                    $('#birthday').val(data.birthday);
                }  
           })  
      });  
      $(document).on('click', '.delete', function(){  
           var id = $(this).attr("id");  
           if(confirm("Are you sure you want to remove this data?")){  
                var action = "Delete";  
                $.ajax({  
                     url:"enrollments_ajax_action.php",
                     method:"POST",  
                     data:{id:id, action:action},  
                     success:function(data){  
                          fetchUsers();
                          alert(data);  
                     }  
                })  
           }  
           else{  
                return false;  
           }  
      });
        $(document).on('click', '.approve', function(){
            var id = $(this).attr("id");
            if(confirm("Are you sure you want to approve this user?")){
                var action = "Approve";
                $.ajax({
                    url:"enrollments_ajax_action.php",
                    method:"POST",
                    data:{id:id, action:action},
                    success:function(data){
                        fetchUsers();
                        alert(data);
                    }
                })
            }
            else{
                return false;
            }
        });
 });  
</script>
<!-- footer -->
<?php include('../includes/footer.php'); ?>
<!-- //footer -->
<?php include('../includes/bottom-footer.php'); ?>