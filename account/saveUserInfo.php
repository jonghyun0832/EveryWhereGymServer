<?php

require_once '../connect.php';


$user_email = $_POST['email'];
$user_password = $_POST['password'];
$user_nickname = $_POST['nickname'];


$sql = "INSERT INTO user_table(user_email,user_password,user_name) VALUES('$user_email','$user_password','$user_nickname')";

if (mysqli_query($conn,$sql)){
    $response['success'] = true;

} else {
    $response['success'] = false;
}

echo json_encode($response);

?>
