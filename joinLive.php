<?php

require_once 'connect.php';

$live_id = $_POST['live_id'];
$live_join = $_POST['live_join'];
$user_id = $_POST['user_id'];

//여긴 라이브 참여 로그 기록

$sql_select = "SELECT * FROM log_table WHERE li_id = '$live_id' and user_id = '$user_id'";
$result_select = mysqli_query($conn, $sql_select);
$data_num = mysqli_num_rows($result_select);

if($data_num > 0){
    date_default_timezone_set('Asia/Seoul');
    $time = date("Y-m-d H:i:s");
    $sql_insert = "UPDATE log_table SET log_stime = '$time' WHERE li_id = '$live_id' and user_id = '$user_id'";
} else {
    $sql_insert = "INSERT INTO log_table(li_id, user_id) VALUES('$live_id','$user_id')";
}

mysqli_query($conn,$sql_insert);

//여기부턴 참여인원수 변경
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