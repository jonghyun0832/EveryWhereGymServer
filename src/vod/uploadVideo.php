<?php

//$target_dir = "./video".'/ArticleVideo/';
// $target_dir = "./video/";
// $traget_file_name = $target_dir.basename($_FILES["video_file"]["name"]);
$source = $_FILES["video_file"]["tmp_name"];

$file_name = $_FILES['video_file']['name'];

$get_file_name = $_REQUEST['filename'];

if($file_name != ""){
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