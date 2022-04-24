<?php

require_once '../connect.php';

$rv_id = $_POST['rv_id'];


$sql = "DELETE FROM review_table WHERE rv_id = '$rv_id'";

if (mysqli_query($conn,$sql)){
    $response['success'] = true;

} else {
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);

?>