<?php

require_once 'connect.php';

$user_id = $_POST['user_id'];
$live_id = $_POST['live_id'];
$uploader_id = $_POST['uploader_id'];

$sql = "SELECT * FROM alarm_table WHERE user_id = '$user_id' AND li_id = '$live_id'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0){
    $response['success'] = false;
} else {
    $response['success'] = true;
}

echo json_encode($response);

mysqli_close($conn);


?>
