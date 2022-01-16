<?php

require_once 'connect.php';

$source = $_FILES['upload']['tmp_name']; 

$file_name = $_FILES['upload']['name'];
$file_path = $file_name.".jpeg";

$prev_url = $_GET['prev_url'];
$user_id = $_GET['user_id'];

$sql = "UPDATE user_table SET user_img = '$file_path' WHERE user_id = '$user_id'";


$prev_path = "./image/".$prev_url;


if($file_name != ""){
    $dest = "./image/".$file_path;
    move_uploaded_file($source,$dest);
    unlink($prev_path);
}

$result = mysqli_query($conn, $sql);

if ($result)
    {
        $response['success'] = true; //프로필 변경사항 저장 완료
    }
    else
    {
        $response['success'] = false; //저장 실패
    }


echo json_encode($response);


?>
