<?php

    require_once 'connect.php';

    //$result_array = array();
    $tmp_array = array();

    $sql = "SELECT * FROM vod_table V
    INNER JOIN user_table U ON V.user_id = U.user_id
    ORDER BY vod_id DESC";
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
                'vod_material'=>$row['vod_material']
            ));
            //array_push($result_array,$tmp_array);
        }
    }


    echo json_encode(array("resultArray"=>$tmp_array),JSON_UNESCAPED_UNICODE);

    mysqli_close($conn);



?>
