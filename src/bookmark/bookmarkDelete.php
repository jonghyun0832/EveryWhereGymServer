<?php

require_once '../connect.php';

$user_id = $_POST['user_id'];
$vod_id = $_POST['vod_id'];

$sql = "DELETE FROM bookmark_table WHERE user_id = '$user_id' AND vod_id = '$vod_id'";

if (mysqli_query($conn,$sql)){
    $response['success'] = true;

} else {
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);



?>