<?php

require_once '../connect.php';

$source = $_FILES["video_file"]["tmp_name"];
$file_origin = $_FILES['video_file']['name'];

$img_source = $_FILES['thumbnail']['tmp_name'];
$img_name = $_FILES['thumbnail']['name'];

$file_name = $_POST['name'];
$file_length = $_POST['length'];
$file_time = $_POST['time'];
$file_user = $_POST['userId'];
$file_title = $_POST['title'];
$file_category = $_POST['category'];
$file_difficulty = $_POST['difficulty'];
$file_explain = $_POST['explain'];
$file_material = $_POST['material'];
$file_calorie = $_POST['calorie'];

$timestamp = time();

//이미지 경로 생성
$img_file_path = $file_user."_".$img_name."_".$timestamp.".jpeg";


if($file_origin != ""){
    $dest = "./video/".$file_name;
    //$dest = "./video/".$file_name.".mp4";
}

if($img_name != ""){
    $img_dest = "./image/".$img_file_path;
}

$sql = "INSERT INTO vod_table(user_id,vod_title,vod_category,vod_difficulty,vod_length,vod_path,vod_img_path,vod_explain,vod_material,vod_calorie,vod_time)
VALUES('$file_user','$file_title','$file_category','$file_difficulty','$file_length','$file_name','$img_file_path','$file_explain','$file_material','$file_calorie','$file_time')";


if(move_uploaded_file($source,$dest) && move_uploaded_file($img_source,$img_dest)){
    if(mysqli_query($conn, $sql)){
        $response['success'] = true; //프로필 변경사항 저장 완료
    }else { //sql 오류
        $response['success'] = false;
    }
} else { //파일 저장 경로 오류
    $response['success'] = false; //프로필 변경사항 저장 완료
}
echo json_encode($response);

?>