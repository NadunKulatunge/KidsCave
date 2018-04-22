<?php
//close created connections if available
if (isset($connect)) {
    mysqli_close($connect);
}
?>