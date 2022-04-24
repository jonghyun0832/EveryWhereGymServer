<?php

require_once '../connect.php';

$live_date = $_POST['date'];
$live_title = $_POST['title'];
$live_start_hour = $_POST['start_hour'];
$live_start_minute = $_POST['start_minute'];
$live_spend_time = $_POST['spend_time'];
$live_calorie = $_POST['calorie'];
$live_limit_join = $_POST['limit_join'];
$live_material = $_POST['material'];
$live_user_id = $_POST['user_id'];


$sql = "INSERT INTO live_table(user_id,li_date,li_title,li_start_hour,li_start_minute,li_spend_time,li_calorie,li_limit_join,li_material)
VALUES('$live_user_id','$live_date','$live_title','$live_start_hour','$live_start_minute','$live_spend_time','$live_calorie','$live_limit_join','$live_material')";

if(mysqli_query($conn, $sql)){
    $response['success'] = true; //프로필 변경사항 저장 완료
}else { //sql 오류
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);

?>
