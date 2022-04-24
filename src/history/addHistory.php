<?php

require_once '../connect.php';

$user_id = $_POST['user_id'];
$vod_id = $_POST['vod_id'];

$sql_check = "SELECT *,date_format(hy_cdate, '%y %m %d') as newdate FROM history_table WHERE user_id = '$user_id' AND vod_id = '$vod_id'
ORDER BY hy_id DESC";

$result_check = mysqli_query($conn, $sql_check);

$today_date = date("y m d");

if (mysqli_num_rows($result_check) != 0){
    $row = mysqli_fetch_assoc($result_check);
    $ddd = $row['newdate'];
    if($today_date == $row['newdate']){
        //오늘 중복있음 -> 오늘의 이전거 삭제하고 다시 앞쪽에 insert해서 추가하기
        $sql_delete = "DELETE FROM history_table WHERE user_id = '$user_id' AND vod_id = '$vod_id'";
        if (mysqli_query($conn,$sql_delete)){
            $response['success'] = true;
        } else {
            $response['success'] = false;
        }
    }
}

$sql_insert = "INSERT INTO history_table(user_id, vod_id) VALUES('$user_id','$vod_id')";

if (mysqli_query($conn,$sql_insert)){
    $response['success'] = true;
} else {
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);


?>