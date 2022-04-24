<?php

require_once '../connect.php';


$user_id = $_POST['user_id'];
$live_id = $_POST['live_id'];
$message = $_POST['message'];
$live_score = $_POST['score'];

$live_title = $_POST['title'];
$live_start_hour = $_POST['start_hour'];
$live_start_minute = $_POST['start_minute'];
$live_spend_time = $_POST['spend_time'];
$live_calorie = $_POST['calorie'];
$live_limit_join = $_POST['limit_join'];
$live_material = $_POST['material'];


$sql = "SELECT * FROM alarm_table A
INNER JOIN user_table U ON A.user_id = U.user_id
WHERE A.uploader_id = '$user_id' AND A.li_id = '$live_id'
ORDER BY A.al_id";

$result = mysqli_query($conn, $sql);
$to_array = array();

while($row = mysqli_fetch_assoc($result)){
    array_push($to_array,$row['user_token']);
}



$header = array("Content-Type:application/json", "Authorization:key=AAAAk2XjGqM:APA91bFcCD0e8kPYdL8NKw7U55gsNNMeg1aG05wO8lFpNySHxB_ateXQ_LoYITRnv5qfr7XTQO9fVpvnJHLUVFxu6FD7hyB9JO5KJOmmDPq98zhnJVNyLxbAdLPg-e4wJyrBKEr-XV81");
$data = json_encode(array(
    "registration_ids"=>$to_array,
    "priority" => "high",
    "notification" => array(
        "click_action" => ".HomeActivity",
        "title"   => "라이브 수정 알림",
        "body" => "트레이너의 메시지 : ".$message),
    "data"=> array("moveto" => 2)
        ));

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch );
curl_close( $ch );

$sql_update = "UPDATE live_table L
    INNER JOIN trainer_table T on L.user_id = T.user_id
    SET li_title = '$live_title', li_start_hour = '$live_start_hour',
    li_start_minute = '$live_start_minute',li_spend_time = '$live_spend_time',
    li_calorie = '$live_calorie', li_limit_join = '$live_limit_join',
    li_material = '$live_material', tr_score = tr_score - $live_score
    WHERE li_id = '$live_id'";

if (mysqli_query($conn,$sql_update)){
    $response['success'] = true;

} else {
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);


?>