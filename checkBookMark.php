<?php

require_once 'connect.php';

$user_id = $_POST['user_id'];
$vod_id = $_POST['vod_id'];

$sql = "SELECT * FROM bookmark_table WHERE user_id = '$user_id' AND vod_id = '$vod_id'
ORDER BY bk_id";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0){
    $response['success'] = true;
} else {
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);

?>
