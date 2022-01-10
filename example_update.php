<?php

    header("Content-type:application/json");

    require_once 'connect.php';

    //$id = $_POST['id'];
    $name = $_POST['name'];
    $hobby = $_POST['hobby'];

    //$sql = "UPDATE firsttest SET name = '$name', hobby = '$hobby' WHERE id = '$id'";
    $sql = "UPDATE firsttest SET hobby = '$hobby' WHERE name = '$name'";

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