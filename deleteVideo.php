<?php

    require_once 'connect.php';

    $vod_id = $_POST['vod_id'];
    $get_vod_img_path = $_POST['vod_thumbnail_path'];
    $get_vod_path  = $_POST['vod_path'];

    $vod_img_path = "./image/".$get_vod_img_path;
    $vod_path = "./video/".$get_vod_path;

    $sql = "DELETE FROM vod_table WHERE vod_id = '$vod_id'";

    $result = mysqli_query($conn, $sql);

    if ($result)
    {
        $response['success'] = true;
        unlink($vod_img_path);
        unlink($vod_path);
    }
    else
    {
        $response['success'] = false;

    }

    echo json_encode($response);

    mysqli_close($conn);

?>