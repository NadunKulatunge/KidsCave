<?php
session_start();
require_once 'class.user.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
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
        <div class="container" ><div style =" border-bottom:2px solid #14a1ff;"><h1>Child Details</h1></div><br>
            <div class="row" >
                <!-- left panel -->
                <?php include('includes/left-panel.php'); ?>
                <!-- //left panel -->
                <!-- right panel -->
                <div class="col-md-9"><!--.col-md-6-->
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
                    </head>
                    <body>
                    <br /><br />
                    <br />
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
                        <button type='submit' name="submit" class='btn btn-primary' style="width:50%; display:block ; margin:auto" onclick="sentAlert('classid','announcement');"> Search </button>
                        <label>Enter Child Name</label>
                        <input autocomplete="off" type="text" name="child" id="child" class="form-control" placeholder="Enter Child Name" />
                    </form>
                    <div id="childList">
                    </div>
                    <?php
                    if(isset($_POST ["submit"])){
                        $child = $_POST ["child"];

                        $output = '';
                        $query = "SELECT tbl_users.userID,student_details.ChildName,student_details.Gender, student_details.DateofBirth,tbl_users.userName, tbl_users.userEmail ,student_details.MobileNo, student_details.LandNo,student_details.Address FROM tbl_users,student_details WHERE tbl_users.userID=student_details.userID AND tbl_users.userRole=\"Parent\" AND tbl_users.adminApprove =\"1\" AND tbl_users.principalApprove=\"1\" AND '$child'=ChildName;";
                        $result = mysqli_query($connect, $query);

                        if(mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $output .='
                        <table class="table table-bordered">  
                          <tr> 
                               <br>
                               <th width="50%" class="text-center">User ID</th>  
                               <th width="50%" class="text-center">'.$row["userID"].'</th></tr><tr>
                               <th width="50%" class="text-center">Child Name</th>  
                               <th width="50%" class="text-center">'.$row["ChildName"].'</th></tr><tr>
                               <th width="50%" class="text-center">Gender</th>  
                               <th width="50%" class="text-center">'.$row["Gender"].'</th></tr><tr>
                               <th width="50%" class="text-center">Date of Birth</th>  
                               <th width="50%" class="text-center">'.$row["DateofBirth"].'</th></tr><tr>
                               <th width="50%" class="text-center">Parent Name</th>  
                               <th width="50%" class="text-center">'.$row["userName"].'</th></tr><tr>
                               <th width="50%" class="text-center">Parent Email</th>  
                               <th width="50%" class="text-center">'.$row["userEmail"].'</th></tr><tr>
                               <th width="50%" class="text-center">Mobile</th>  
                               <th width="50%" class="text-center">'.$row["MobileNo"].'</th></tr><tr>
                               <th width="50%" class="text-center">Phone</th>  
                               <th width="50%" class="text-center">'.$row["LandNo"].'</th></tr><tr>
                               <th width="50%" class="text-center">Address</th>  
                               <th width="50%" class="text-center">'.$row["Address"].'</th></tr><tr>
                               
                          </tr> </table>
                           ';
                            echo $output ;
                        }
                        else
                        {
                            $output .= '<li>Child Not Found</li>';
                        }
                    }
                    ?>
                    </body>
                    </html>
                    <script>
                        $(document).ready(function(){
                            $('#child').keyup(function(){
                                var query = $(this).val();
                                if(query != '')
                                {
                                    $.ajax({
                                        url:"search.php",
                                        method:"POST",
                                        data:{query:query},
                                        success:function(data)
                                        {
                                            $('#childList').fadeIn();
                                            $('#childList').html(data);
                                        }
                                    });
                                }
                            });
                            $(document).on('click', 'li', function(){
                                $('#child').val($(this).text());
                                $('#childList').fadeOut();
                            });
                        });
                    </script>
                </div>
                </body>
                </html>
            </div>
            <!-- right panel -->
        </div>
    </div>
    </div>
    <!-- footer -->
<?php include('includes/footer.php'); ?>
    <!-- //footer -->
<?php include('includes/bottom-footer.php'); ?>