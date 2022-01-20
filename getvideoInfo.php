<?php

    require_once 'connect.php';

    $user_id = $_POST['user_id'];

    $sql = "SELECT * FROM vod_table WHERE user_id = '$user_id' 
    ORDER BY vod_id DESC";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if ($result)
    {
        $response['success'] = true;
        $response['title'] = $row['vod_title'];
        $response['category'] = $row['vod_category'];
        $response['difficulty'] = $row['vod_difficulty'];
        $response['video_url'] = $row['vod_path'];

    }
    else
    {
        $response['success'] = false;
    }
    
    echo json_encode($response);

?>
