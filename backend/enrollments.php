<?php
session_start();
require_once 'dbconfig.php';
require_once 'class.user.php';

$user_login = new User();
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/class.database.php');

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
					    <input type="email" name="email" id="email" class="form-control"/>
                    <br />
                    <label>User Role</label>
                        <select id="role" name="role" required class="form-control">
                            <option value="" >User Role</option>
                            <option value="Parent">Parent</option>
                            <option value="Teacher">Teacher</option>
                            <option value="Admin">Admin</option>
                            <option value="Principal">Principal</option>
                        </select>
                    <br />
                    <label>Gender</label>
                        <select id="genderEdit" name="genderEdit" required class="form-control">
                            <option value="" >Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    <br />
                    <label>Birthday</label>
                        <input type="date" name="birthday" id="birthday" class="form-control" max="<?php echo date("Y-m-d",strtotime("-4 years")); ?>"/>
                    <br />
                    <label>Phone</label>
                        <input type="tel" pattern='[0-9]{3}-[0-9]{3}-[0-9]{4}' placeholder="07X-XXX-XXXX" name="phone" id="phone" class="form-control"/>
                    <br />
                    <label>Class Room</label>
                <?php
                $query = "SELECT classID, className  FROM class";
                $result = mysqli_query($connect,$query);
                $output = '<select id="classroom" name="classroom" required class="form-control">';
                if(mysqli_num_rows($result) > 0) {
                     while($row = mysqli_fetch_array($result)) {
                          $output .= '
                            <option value="'.$row["classID"].'" >'.$row["className"].'</option>
                          ';
                     }
                }else{
                    $output .= '<option value="" >There are no classes</option>';
                }
                $output .= '</select>';
                echo $output;
                ?>
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
                    $('#phone').val('');
                    $('#classroom').val('');
                    $('#action').text("Add");
                    $('#result').html(data);
                }  
           });  
      }  
      $('#action').click(function(){  
          var name = $('#name').val()
          var email = $('#email').val();
          var role = $('#role').val();
          var gender = $('#genderEdit').val();
          var birthday = $('#birthday').val();
          var phone = $('#phone').val();
          var classroom = $('#classroom').val();
          var id = $('#user_id').val();
          var action = $('#action').text();
          if(name != '' && email != ''&& role != ''&& gender != ''&& birthday != ''&& phone != '' && classroom != ''){
                $.ajax({
                     url : "enrollments_ajax_action.php",
                     method:"POST",
                     data:{name:name, email:email, role:role, gender:gender, birthday:birthday, phone:phone, classroom:classroom, id:id, action:action},
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
                    $('#phone').val(data.phone);
                    $('#classroom').val(data.classroom);
                }  
           })  
      });  
      $(document).on('click', '.disapprove', function(){
           var id = $(this).attr("id");  
           if(confirm("Are you sure you want to disapprove this user?")){
                var action = "Disapprove";
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