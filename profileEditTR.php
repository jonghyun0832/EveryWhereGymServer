<?php

    require_once 'connect.php';

    $user_id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $tr_intro = $_POST['tr_intro'];
    $tr_expert = $_POST['tr_expert'];
    $tr_career = $_POST['tr_career'];
    $tr_certify = $_POST['tr_certify'];


    $sql = "UPDATE user_table U 
    INNER JOIN trainer_table T ON U.user_id = T.user_id
    SET U.user_name = '$user_name', T.tr_intro = '$tr_intro', T.tr_expert = '$tr_expert',
    T.tr_career = '$tr_career', T.tr_certify = '$tr_certify'
    WHERE U.user_id = '$user_id'";

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