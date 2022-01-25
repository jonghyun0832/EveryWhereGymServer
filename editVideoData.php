<?php

require_once 'connect.php';

//빈파일 보낼떄 어떻게 받는지 확인해보고 하자
$img_source = $_FILES['thumbnail']['tmp_name'];
$img_name = $_FILES['thumbnail']['name'];

$file_user = $_POST['userId'];
$file_title = $_POST['title'];
$file_category = $_POST['category'];
$file_difficulty = $_POST['difficulty'];
$file_vod_id = $_POST['vod_id'];
$file_previous_thumbnail = $_POST['previous'];
$file_vod_explain = $_POST['explain'];
$file_vod_material = $_POST['material'];

$prev_path = "./image/".$file_previous_thumbnail;

$timestamp = time();

$img_file_path = $file_user."_".$img_name."_".$timestamp.".jpeg";

if($img_name != "EMPTY_IMAGE"){
    //이미지가 포함된 경우
    $img_dest = "./image/".$img_file_path;

    $sql = "UPDATE vod_table
    SET vod_title = '$file_title', vod_category = '$file_category',
    vod_difficulty = '$file_difficulty',vod_img_path = '$img_file_path',
    vod_explain = '$file_vod_explain', vod_material = '$file_vod_material'
    WHERE vod_id = '$file_vod_id'";

    if(move_uploaded_file($img_source,$img_dest)){
        if(mysqli_query($conn, $sql)){
            unlink($prev_path);
            $response['success'] = true; //프로필 변경사항 저장 완료
        }else { //sql 오류
            $response['success'] = false;
        }
    } else { //파일 저장 경로 오류
        $response['success'] = false; //프로필 변경사항 저장 완료
    }

//
} else {
    //이미지가 없는경우
    $sql = "UPDATE vod_table
    SET vod_title = '$file_title', vod_category = '$file_category',
    vod_difficulty = '$file_difficulty'
    WHERE vod_id = '$file_vod_id'";

    if(mysqli_query($conn, $sql)){
        $response['success'] = true; //프로필 변경사항 저장 완료
    }else { //sql 오류
        $response['success'] = false;
    }
}   

echo json_encode($response);

mysqli_close($conn);

//sd

?>
