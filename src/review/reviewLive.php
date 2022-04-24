<?php

require_once '../connect.php';

$live_id = $_POST['live_id'];
$user_id = $_POST['user_id'];

if($user_id != 0){
    $sql = "SELECT * FROM log_table L
    INNER JOIN user_table U ON L.user_id = U.user_id
    WHERE li_id = '$live_id' AND L.user_id = '$user_id' AND log_done = '0'";
} else {
    //여기서 done인 애들한테는 보내면 안됨 이미 보낸애들임
    $sql = "SELECT * FROM log_table L
    INNER JOIN user_table U ON L.user_id = U.user_id
    WHERE li_id = '$live_id' AND log_done = '0'";
}

// $sql = "SELECT * FROM log_table L
// INNER JOIN user_table U ON L.user_id = U.user_id
// WHERE li_id = '$live_id'";

$result = mysqli_query($conn, $sql);
$to_array = array();
$log_id_array = array();

while($row = mysqli_fetch_assoc($result)){
    $tmp_start_time = $row['log_stime'];
    $tmp_end_time = $row['log_etime'];

    //가져온 접속한 시간
    date_default_timezone_set('Asia/Seoul');
    $timestamp_start = strtotime($tmp_start_time);
    $timestamp_end = strtotime($tmp_end_time);
    //$timestamp_start_1 = strtotime($tmp_start_time." -1 minutes");
    //현재 시간
    //$timestamp_now = strtotime("Now");

    //머무르는 시간 설정 (현재시간 - 라이브 참여한 시간)
    if($timestamp_end - $timestamp_start >= 30){
        //30초이상 라이브에 머무른 사람
        array_push($to_array,$row['user_token']);
        array_push($log_id_array,$row['log_id']);
    }
}

$header = array("Content-Type:application/json", "Authorization:key=AAAAk2XjGqM:APA91bFcCD0e8kPYdL8NKw7U55gsNNMeg1aG05wO8lFpNySHxB_ateXQ_LoYITRnv5qfr7XTQO9fVpvnJHLUVFxu6FD7hyB9JO5KJOmmDPq98zhnJVNyLxbAdLPg-e4wJyrBKEr-XV81");
$data = json_encode(array(
    "registration_ids"=>$to_array,
    "priority" => "high",
    "notification" => array(
        "click_action" => ".HomeActivity",
        "title"   => "라이브는 어떠셨나요?",
        "body" => "라이브 평가를 남겨주세요/".$live_id),
    "data"=> array("live_id" => $live_id)
    ));

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$curl_result = curl_exec($ch );
curl_close( $ch );

if ($curl_result){
    for ($i=0; $i < count($log_id_array); $i++) { 
        $tmp_id = $log_id_array[$i];
        $sql_update = "UPDATE log_table SET log_done = '1' WHERE log_id = '$tmp_id'";
        mysqli_query($conn,$sql_update);
    }
}



$response['success'] = true;

echo json_encode($response);

mysqli_close($conn);

?>