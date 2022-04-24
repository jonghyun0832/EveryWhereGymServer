<?php

    require_once '../connect.php';

    $vod_id = $_POST['vod_id'];
    $prev_vod_view = $_POST['prev_vod_view'];

    $vod_view = $prev_vod_view + 1;

    $sql = "UPDATE vod_table
    SET vod_view = '$vod_view'
    WHERE vod_id = '$vod_id'";

    if(mysqli_query($conn, $sql)){
        $response['success'] = true; 
    }else {
        $response['success'] = false;
    }

    echo json_encode($response);

    mysqli_close($conn);

?>
