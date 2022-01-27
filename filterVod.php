<?php

require_once 'connect.php';

$filter_array = $_POST['filter'];

$filter_category = "";
$filter_difficulty = "";
$filter_time = "";

if ($filter_array[0] != null){
    $filter_category = $filter_array[0];
}

if($filter_array[1] != null){
    $filter_difficulty = $filter_array[1];
}

if($filter_array[2] != null){
    $filter_time = $filter_array[2];
}

//일단은 카테고리 필터만 ㄱㄱ 
//sql 문 만들어야함

$tmp_array = array();

$sql2 = "SELECT * FROM vod_table V
INNER JOIN user_table U ON V.user_id = U.user_id
WHERE V.user_id = '$user_id'
ORDER BY vod_id DESC";
$result2 = mysqli_query($conn, $sql2);

if(mysqli_num_rows($result2) > 0){
    while($row2 = mysqli_fetch_assoc($result2)){
        //$tmp_array = array();
        array_push($tmp_array, array(
            'vod_difficulty'=>$row2['vod_difficulty'],
            'vod_thumbnail'=>$row2['vod_img_path'],
            'vod_time'=>$row2['vod_length'],
            'vod_uploader_img'=>$row2['user_img'],
            'vod_title'=>$row2['vod_title'],
            'vod_uploader_name'=>$row2['user_name'],
            'vod_path'=>$row2['vod_path'],
            'vod_uploader_id'=>$row2['user_id'],
            'vod_id'=>$row2['vod_id'],
            'vod_category'=>$row2['vod_category'],
            'vod_explain'=>$row2['vod_explain'],
            'vod_material'=>$row2['vod_material'],
            'vod_view'=>$row2['vod_view'],
            'vod_calorie'=>$row2['vod_calorie']
        ));
    }
}


echo json_encode(array("resultArray"=>$tmp_array),JSON_UNESCAPED_UNICODE);

mysqli_close($conn);

?>
