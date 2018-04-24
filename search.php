<?php
$connect = mysqli_connect("localhost", "root", "", "kidscave");
if(isset($_POST["query"]))
{
    $output = '';
    $query = "SELECT * FROM student_guardian WHERE firstName LIKE '%".$_POST["query"]."%'";
    $result = mysqli_query($connect, $query);
    $output = '<ul class="list-unstyled">';
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $output .= '<li>'.$row["firstName"].'</li>';
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