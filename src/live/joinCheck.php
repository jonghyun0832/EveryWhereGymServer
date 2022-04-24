<?php

require_once '../connect.php';

$live_id = $_POST['live_id'];

$sql = "SELECT li_join, li_limit_join FROM live_table WHERE li_id = '$live_id'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($result)
{
    if ($row['li_join'] < $row['li_limit_join']){
        $response['live_join'] = $row['li_join'];
        $response['success'] = true;
    }else{
        $response['success'] = false;
    }
}

echo json_encode($response);

mysqli_close($conn);


?>