<?php

require_once '../connect.php';

$user_nickname = $_GET['nickname'];

$sql = "SELECT user_id FROM user_table WHERE user_name = '$user_nickname'";
$result = mysqli_query($conn, $sql);
$data_num = mysqli_num_rows($result);

if($data_num == 1){
    echo json_encode(array("response"=>"good","nickname"=>true));
} else{
    echo json_encode(array("response"=>"good","nickname"=>false));
}




?>
