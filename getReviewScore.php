<?php

require_once 'connect.php';

$uploader_id = $_POST['uploader_id'];

$total_score = 0.0;

$sql2 = "SELECT rv_score FROM review_table
WHERE trainer_id = '$uploader_id'";

$result2 = mysqli_query($conn, $sql2);
$result_num = mysqli_num_rows($result2);

if($result_num > 0){
    $total_sum = 0;
    while($row2 = mysqli_fetch_assoc($result2)){
        $total_sum += $row2['rv_score'];
    }
    $total_score = round(($total_sum / $result_num),1);
}

$response['rv_total_score'] = $total_score;

echo json_encode($response);

mysqli_close($conn);

?>