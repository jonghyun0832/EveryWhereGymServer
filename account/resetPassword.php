<?php

    $user_mail = $_POST['email'];
    $reset_password = $_POST['password'];

    require_once '../connect.php';

    $sql = "UPDATE user_table SET user_password = '$reset_password' WHERE user_email = '$user_mail'";

    $result = mysqli_query($conn, $sql);

    if ($result)
    {
        $response['success'] = true; //비밀번호 변경 완료
    }
    else
    {
        $response['success'] = false; //비밀번호 변경 실패 (이메일이 일치하지 않는 경우)
    }

    echo json_encode($response);

?>