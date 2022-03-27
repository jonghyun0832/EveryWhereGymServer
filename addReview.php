<?php

require_once 'connect.php';

$uploader_id = $_POST['uploader_id'];
$user_id = $_POST['user_id'];
$review = $_POST['review'];
$score = $_POST['score'];
$title = $_POST['title'];

$sql = "INSERT INTO review_table(trainer_id, user_id,rv_text,rv_score,rv_title) VALUES('$uploader_id','$user_id','$review','$score','$title')";

if (mysqli_query($conn,$sql)){
    $response['success'] = true;

} else {
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);

?>