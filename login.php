<?php

require_once 'connect.php';

$user_email = $_POST['email'];
$user_password = $_POST['password'];


$sql = "SELECT user_password FROM user_table WHERE user_email = '$user_email'";

$result = mysqli_query($conn, $sql);
$data_num = mysqli_num_rows($result);

if($data_num == 1){
    $row = mysqli_fetch_array($result);
    $password = $row[0]; //이메일 있으면 패스워드있음
     //여기에 복호화 작업해서 비교해줘야함
    if ($password == $user_password){
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }
}else {
    $response['success'] = false;
}

echo json_encode($response);


?>
