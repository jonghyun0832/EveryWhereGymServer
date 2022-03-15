<?php

require_once 'connect.php';

$live_id = $_POST['live_id'];
$live_join = $_POST['live_join'];

$new_live_join = $live_join + 1;

$sql = "UPDATE live_table SET li_join = '$new_live_join' WHERE li_id = '$live_id'";

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