<?php

require_once 'connect.php';

$live_id = $_POST['live_id'];

$sql = "SELECT * FROM live_table WHERE li_id = '$live_id'";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);

if ($result)
{
    $response['success'] = true;
    $response['live_title'] = $row['li_title'];
    $response['uploader_id'] = $row['user_id'];
}
else
{
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);

?>