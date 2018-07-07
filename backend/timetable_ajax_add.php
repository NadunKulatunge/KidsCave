 <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kidscave";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO period_detail (periodName,teacherID) VALUES ('".$_POST['sub']."','".$_POST['id']."')";
    // use exec() because no results are returned
    $conn->exec($sql);
    if ($sql){?>
        <script>
        alert("Successful!!")
        </script>
   
   <?php } else{?>
       <script>
       alert("You have to try again")
       </script>
   
   <?php }
   
                                                         
   
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>
