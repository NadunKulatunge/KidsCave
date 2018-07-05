<?php
session_start();
require_once 'dbconfig.php';
require_once 'class.user.php';
$user_login = new User();

if(!$user_login->is_logged_in()){
	$user_login->redirect('../index.php');
}

//Allowed only Admin && Principal userRole
if($_SESSION['userRole']!= "Admin" && $_SESSION['userRole']!= "Principal" && $_SESSION['userRole']!= "Teacher"){
	$user_login->redirect('../payments.php');
}

$stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<!-- top html header -->
<?php include('../includes/top-header.php'); ?>
<!-- //top html header -->
<!-- header -->
<?php include('../includes/header.php'); ?>
<!-- //header -->
<div style="min-height: calc(100vh - 190px); margin-top: 1em; margin-bottom:3em;">
	<div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Payments</h1></div><br>
		<div class="row" >
			<!-- left panel -->
			<?php include('../includes/left-panel.php'); ?>
			<!-- //left panel -->
			<!-- right panel -->
			<div class="col-md-9">

					<h3 align="center">Add Edit Remove Payment Details</h3>  
					<br /><br />    
					<label>Description</label>  
					<input type="text" name="description" id="description" class="form-control"/>  
					<br />  
					<label>Amount</label>  
					<input type="text" name="totalAmount" id="totalAmount" class="form-control"/>  
					<br /><br />  
					<div align="center">  
						 <input type="hidden" name="id" id="payment_id" />  
						 <button type="button" name="action" id="action" class="btn btn-primary" style="width:50%;">Add</button>  
					</div>  
					<br />  
					<br />
					<div id="result"></div>

			</div>
			<!-- right panel -->
		</div>
	</div>
</div>
<script>  
	$(document).ready(function(){  
		fetchPayment();  
		function fetchPayment(){  
           var action = "select";  
           $.ajax({  
                url : "payments_ajax_select.php",  
                method:"POST",  
                data:{action:action},  
                success:function(data){  
                     $('#description').val('');  
                     $('#totalAmount').val('');  
                     $('#action').text("Add");  
                     $('#result').html(data);  
                }  
           });  
      }  
      $('#action').click(function(){  
           var description = $('#description').val();  
           var totalAmount = $('#totalAmount').val();  
           var id = $('#payment_id').val();  
           var action = $('#action').text();  
           if(description != '' && totalAmount != ''){  
                $.ajax({  
                     url : "payments_ajax_action.php",  
                     method:"POST",  
                     data:{description:description, totalAmount:totalAmount, id:id, action:action},  
                     success:function(data){  
                          alert(data);  
                          fetchPayment();  
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
                url:"payments_ajax_fetch.php",  
                method:"POST",  
                data:{id:id},  
                dataType:"json",  
                success:function(data){  
                     $('#action').text("Edit");  
                     $('#payment_id').val(id);  
                     $('#description').val(data.description);  
                     $('#totalAmount').val(data.totalAmount);  
                }  
           })  
      });  
      $(document).on('click', '.delete', function(){  
           var id = $(this).attr("id");  
           if(confirm("Are you sure you want to remove this data?")){  
                var action = "Delete";  
                $.ajax({  
                     url:"payments_ajax_action.php",  
                     method:"POST",  
                     data:{id:id, action:action},  
                     success:function(data){  
                          fetchPayment();  
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