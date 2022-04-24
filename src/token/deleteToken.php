<?php

require_once '../connect.php';

$user_id = $_POST['user_id'];

$sql = "UPDATE user_table SET user_token = 'none' WHERE user_id = '$user_id'";

$result = mysqli_query($conn, $sql);

if ($result)
{
    $response['success'] = true;
}
else
{
    $response['success'] = false;
}
echo json_encode($response);

mysqli_close($conn);


?>