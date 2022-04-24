<?php

    require_once '../connect.php';

    $page = $_POST['page'];
    $limit = $_POST['limit'];
    $cursor = $_POST['cursor'];

    $end = false;

    $last_num = $page * $limit;
    $prev_step = ($page-1) * $limit;

    if($cursor == 0){
        $cursor = 99999;
    }

    $sql_select = "SELECT * FROM vod_table V
    INNER JOIN user_table U ON V.user_id = U.user_id
    ORDER BY vod_id DESC";

    
    $tmp_array = array();

    // $sql = "SELECT * FROM vod_table V
    // INNER JOIN user_table U ON V.user_id = U.user_id
    // ORDER BY vod_id DESC";
    $result_select = mysqli_query($conn, $sql_select);

    if (mysqli_num_rows($result_select) <= $last_num){
        $end = true;
        if(mysqli_num_rows($result_select) - $prev_step > 0){
            $limit = mysqli_num_rows($result_select) - $prev_step;
        } else {
            $limit = 0;
        }
    }

    $sql = "SELECT * FROM vod_table V
    INNER JOIN user_table U ON V.user_id = U.user_id
    WHERE vod_id < $cursor
    ORDER BY vod_id DESC
    LIMIT $limit";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            //$tmp_array = array();
            array_push($tmp_array, array(
                'vod_difficulty'=>$row['vod_difficulty'],
                'vod_thumbnail'=>$row['vod_img_path'],
                'vod_time'=>$row['vod_length'],
                'vod_uploader_img'=>$row['user_img'],
                'vod_title'=>$row['vod_title'],
                'vod_uploader_name'=>$row['user_name'],
                'vod_path'=>$row['vod_path'],
                'vod_uploader_id'=>$row['user_id'],
                'vod_id'=>$row['vod_id'],
                'vod_category'=>$row['vod_category'],
                'vod_explain'=>$row['vod_explain'],
                'vod_material'=>$row['vod_material'],
                'vod_view'=>$row['vod_view'],
                'vod_calorie'=>$row['vod_calorie']
            ));
            //array_push($result_array,$tmp_array);
        }
    }


    //echo json_encode(array("resultArray"=>$tmp_array),JSON_UNESCAPED_UNICODE);

    //$response['cursor'] = $tmp_array[3]['vod_id'];

    $response = array("resultArray"=>$tmp_array,"cursor" => $tmp_array[$limit-1]['vod_id'],"end"=>$end);

    echo json_encode($response);

    mysqli_close($conn);



?>
