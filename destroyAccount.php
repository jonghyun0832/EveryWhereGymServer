<?php

    require_once 'connect.php';

    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM user_table WHERE user_id = '$user_id'";

    $result = mysqli_query($conn, $sql);

    if ($result)
    {
        $response['success'] = true;
    }
    else
    {
        $response['success'] = false;
    }

    echo json_encode($response);


?>