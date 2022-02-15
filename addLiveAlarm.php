<?php

require_once 'connect.php';

$user_id = $_POST['user_id'];
$live_id = $_POST['live_id'];
$uploader_id = $_POST['uploader_id'];


$sql= "INSERT INTO alarm_table(user_id, li_id, uploader_id) VALUES('$user_id','$live_id','$uploader_id')";

if(mysqli_query($conn, $sql)){
    $response['success'] = true; 
}else {
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);


?>
