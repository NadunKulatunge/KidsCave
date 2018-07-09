<?php
session_start();
;require_once 'dbconfig.php';
require_once 'class.user.php';

$user_login = new USER();
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');

if(!$user_login->is_logged_in()){
    $user_login->redirect('../index.php');
}

//Restrict Access
if($_SESSION['userRole']!= "Principal"){
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
        <div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Leave</h1></div><br>
            <div class="row" >
                <!-- left panel -->
                <?php include('../includes/left-panel.php'); ?>
                <!-- //left panel -->
                <!-- right panel -->
                <div class="col-md-9">

                    <h3 align="center">Approve Leave</h3>
                    <br></br>
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
                    url : "leave_approve_ajax_select.php",
                    method:"POST",
                    data:{action:action},
                    success:function(data){
                        $('#result').html(data);

                    }
                });
            }


            $(document).on('click', '.disapprove', function(){
                var id = $(this).attr("id");
                if(confirm("Are you sure you want to disapprove this user?")){
                    var action = "Disapprove";
                    $.ajax({
                        url:"leave_approve_ajax_action.php",
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
                        url:"leave_approve_ajax_action.php",
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