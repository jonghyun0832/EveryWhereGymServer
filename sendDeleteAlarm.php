<?php

require_once 'connect.php';

$user_id = $_POST['user_id'];
$live_id = $_POST['live_id'];
$message = $_POST['message'];


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
        "title"   => "라이브 삭제 알림",
        "body" => "트레이너의 메시지 : ".$message)
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

$sql_delete = "DELETE FROM live_table WHERE li_id = '$live_id'";

if (mysqli_query($conn,$sql_delete)){
    $response['success'] = true;

} else {
    $response['success'] = false;
}

echo json_encode($response);

mysqli_close($conn);


?>