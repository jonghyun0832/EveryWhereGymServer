<?php

require_once 'connect.php';

$user_id = $_POST['user_id'];


$sql = "SELECT user_name FROM user_table WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($result)
{
    $response['success'] = true;
    $response['user_name'] = $row['user_name'];
}
else
{
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);

//
?>

