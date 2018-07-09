<?php
session_start();
require_once 'backend/class.user.php';
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/dbconfig.php');
$user_login = new USER();

if(!$user_login->is_logged_in())
{
    $user_login->redirect('index.php');
}
if(isset($_POST["query"]))
{
    $output = '';
    $query = "SELECT * FROM student_guardian WHERE studentName LIKE '%".$_POST["query"]."%'";
    $result = mysqli_query($connect, $query);
    $output = '<ul class="list-unstyled">';
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $output .= '<li>'.$row["studentName"].'</li>';
        }
    }
    else
    {
        $output .= '<li>Child Not Found</li>';
    }
    $output .= '</ul>';
    echo $output;
}



?>