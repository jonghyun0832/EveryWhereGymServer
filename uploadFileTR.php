<?php

require_once 'connect.php';

$source = $_FILES['img_upload']['tmp_name']; 
$source_back = $_FILES['img_upload2']['tmp_name'];

$prev_url = $_GET['prev_img_url'];
$prev_back_url = $_GET['prev_back_url'];

$user_id = $_GET['user_id'];

$timestamp = time();

$file_name = $_FILES['img_upload']['name'];
$file_path = $user_id."_".$file_name."_".$timestamp.".jpeg";

$file_name_back = $_FILES['img_upload2']['name'];
$file_path_back = $user_id."_".$file_name_back."_".$timestamp.".jpeg";

$prev_path = "./image/".$prev_url;
$prev_back_path = "./image/".$prev_back_url;


if ($file_name != "" && $file_name_back != ""){

    $sql = "UPDATE user_table U 
    INNER JOIN trainer_table T ON U.user_id = T.user_id
    SET U.user_img = '$file_path', T.tr_img = '$file_path_back'
    WHERE U.user_id = '$user_id'";

} elseif ($file_name != ""){

    $sql = "UPDATE user_table SET user_img = '$file_path' WHERE user_id = '$user_id'";

} elseif ($file_name_back != ""){

    $sql = "UPDATE trainer_table SET tr_img = '$file_path_back' WHERE user_id = '$user_id'";

} else {

    //둘다 없는경우는 아예 안들어옴..    

}


if($file_name != ""){
    $dest = "./image/".$file_path;
    move_uploaded_file($source,$dest);
    unlink($prev_path);
}

if($file_name_back != ""){
    $dest_back = "./image/".$file_path_back;
    move_uploaded_file($source_back,$dest_back);
    unlink($prev_back_path);
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