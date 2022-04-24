<?php

require_once '../connect.php';

$user_id = $_POST['user_id'];
$live_id = $_POST['live_id'];
$uploader_id = $_POST['uploader_id'];


$sql = "DELETE FROM alarm_table WHERE user_id = '$user_id' AND li_id = '$live_id'";

if(mysqli_query($conn, $sql)){
    $response['success'] = true; 
}else {
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);


?>