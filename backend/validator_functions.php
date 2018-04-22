<?php
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function valid_date($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = str_replace("/","-",$data);
    $dateArray = explode("-",$data);
    if( !checkdate($dateArray[1],$dateArray[2],$dateArray[0]) ){
        return false;       //Invalid
    }else{
        return true;        //Valid
    }
}

function valid_name($data) {
    if ( empty($data) || !preg_match("/^[a-zA-Z ]*$/",$data) ) {
        return false;       //Invalid
    }else{
        return true;        //Valid
    }
}

function valid_email($data) {
    if ( empty($data) || !filter_var($data, FILTER_VALIDATE_EMAIL) ) {
        return false;       //Invalid
    }else{
        return true;        //Valid
    }
}
function isAvailable_email($data,$connect){
    $query = "SELECT * FROM tbl_users WHERE userEmail='$data'";
    $result = mysqli_query($connect,$query);
    if (mysqli_num_rows($result) == 0){
        return true;    //valid
    }else{
        return false;   //Invalid
    }

}
function valid_password($data1,$data2) {
    if ( empty($data1) || empty($data2) || ($data1!=$data2) ) {
        return false;       //Invalid
    }else{
        return true;        //Valid
    }
}
function valid_gender($data) {
    if ( !in_array( $data, array('Male','Female') ) ) {
        return false;       //Invalid
    }else{
        return true;        //Valid
    }
}
function valid_phone($data) {
    if ( empty($data) || !preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $data) ) {
        return false;       //Invalid
    }else{
        return true;        //Valid
    }
}
function valid_role($data) {
    if ( !in_array($data, array('Principal','Admin','Parent','Teacher')) ) {
        return false;       //Invalid
    }else{
        return true;        //Valid
    }
}
function valid_classroom($data,$connect) {
    if ( empty($data) || $data=="" || !is_int ( $data )) {
        return false;       //Invalid
    }else{
        $query = "SELECT * FROM class WHERE classID='$data'";
        $result = mysqli_query($connect,$query);
        if (mysqli_num_rows($result) != 0){
            return true;
        }else{
            return false;
        }
    }
}

///Payments Page Validations
function valid_description($data) {
    if ( empty($data) || !preg_match("/^[a-zA-Z0-9 ]*$/",$data) ) {
        return false;       //Invalid
    }else{
        return true;        //Valid
    }
}
function valid_amount($data) {
    if ( empty($data) || !preg_match("/^[0-9]*$/",$data) ) {
        return false;       //Invalid
    }else{
        return true;        //Valid
    }
}


?>
<?php
//close connections
include_once($_SERVER['DOCUMENT_ROOT'].'/KidsCave/backend/close_connections.php');
?>
