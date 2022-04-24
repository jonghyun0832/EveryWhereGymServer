<?php

    require_once '../connect.php';

    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];

    $sql = "UPDATE user_table SET user_name = '$user_name' WHERE user_id = '$user_id'";
    //$sql = "UPDATE user_table SET user_name = '$user_name', user_img = '$user_img' WHERE user_id = '$user_id'";

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
