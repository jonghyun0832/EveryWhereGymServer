<?php

require_once '../connect.php';

$rv_id = $_POST['rv_id'];
$rv_text = $_POST['rv_text'];
$rv_score = $_POST['rv_score'];


$sql = "UPDATE review_table SET rv_text = '$rv_text', rv_score = '$rv_score' WHERE rv_id = '$rv_id'";

if (mysqli_query($conn,$sql)){
    $response['success'] = true;
} else {
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);

?>