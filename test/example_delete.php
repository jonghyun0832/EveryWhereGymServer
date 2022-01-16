<?php

    //$id = $_POST['id'];
    $name = $_POST['name'];

    require_once 'connect.php';

    $sql = "DELETE FROM firsttest WHERE name = '$name'";

    $result = mysqli_query($conn, $sql);

    if ($result)
    {
        $response['success'] = true;
        $response['message'] = "추가 완료";
    }
    else
    {
        $response['success'] = false;
        $response['message'] = "추가 실패";
    }

    echo json_encode($response);
?>
