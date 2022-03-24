<?php

require_once 'connect.php';

$live_id = $_POST['live_id'];

$sql_select = "SELECT li_join FROM live_table WHERE li_id = '$live_id'";

$result_select = mysqli_query($conn, $sql_select);
$row = mysqli_fetch_array($result_select);

$live_join = $row['li_join'];
$new_live_join = $live_join - 1;
if($new_live_join < 0){
    $new_live_join = 0;
}

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