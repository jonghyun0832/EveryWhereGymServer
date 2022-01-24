<?php

require_once 'connect.php';

$img_source = $_FILES['thumbnail']['tmp_name'];
$img_name = $_FILES['thumbnail']['name'];

$file_length = $_POST['length'];
$file_user = $_POST['userId'];
$file_title = $_POST['title'];
$file_category = $_POST['category'];
$file_difficulty = $_POST['difficulty'];

$timestamp = time();

$img_file_path = $file_user."_".$img_name."_".$timestamp.".jpeg";

if($img_name != ""){
    $img_dest = "./image/".$img_file_path;
}

// $sql =

if(move_uploaded_file($img_source,$img_dest)){
    if(mysqli_query($conn, $sql)){
        unlink();
        $response['success'] = true; //프로필 변경사항 저장 완료
    }else { //sql 오류
        $response['success'] = false;
    }
} else { //파일 저장 경로 오류
    $response['success'] = false; //프로필 변경사항 저장 완료
}

echo json_encode($response);


?>
