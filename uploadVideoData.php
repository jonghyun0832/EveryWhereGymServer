<?php

$source = $_FILES["video_file"]["tmp_name"];
$file_origin = $_FILES['video_file']['name'];

$file_name = $_POST['name'];
$file_length = $_POST['length'];
$file_user = $_POST['userId'];
$file_title = $_POST['title'];
$file_category = $_POST['category'];
$file_difficulty = $_POST['difficulty'];

if($file_origin != ""){
    $dest = "./video/".$file_name;
}

$response['success'] = true;
// if(move_uploaded_file($source,$dest)){
//     $response['success'] = true; //프로필 변경사항 저장 완료
// } else {
//     $response['success'] = false; //프로필 변경사항 저장 완료
// }

echo json_encode($response);

?>