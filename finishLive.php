<?php

require_once 'connect.php';

$live_id = $_POST['live_id'];

$sql = "DELETE FROM live_table WHERE li_id = '$live_id'";

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