<?php

    require_once '../connect.php';

    $li_id = $_POST['li_id'];


    $sql = "DELETE FROM live_table WHERE li_id = '$li_id'";

    if (mysqli_query($conn,$sql)){
        $response['success'] = true;

    } else {
        $response['success'] = false;
    }

    echo json_encode($response);

    mysqli_close($conn);


    //이거안씀 통합됬음 sendDeleteAlarm에
?>