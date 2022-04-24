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


$filter_category = $_POST['filter_category'];
$filter_difficulty = $_POST['filter_difficulty'];
$filter_time = $_POST['filter_time'];

$filter1 = "없음";
$filter2 = "없음";
$filter3 = "없음";
$filter4 = "없음";
$filter5 = "없음";

$diff_filter1 = "입문";
$diff_filter2 = "초급";
$diff_filter3 = "중급";

$time_filter1 = 0;
$time_filter2 = 100;


$category_array = explode(', ',$filter_category);
$difficulty_array = explode(', ',$filter_difficulty);
$time_array = explode(' ~ ',$filter_time);

if (count($category_array) == 1){
    $filter1 = $category_array[0];
} elseif (count($category_array) == 2){
    $filter1 = $category_array[0];
    $filter2 = $category_array[1];
} elseif (count($category_array) == 3){
    $filter1 = $category_array[0];
    $filter2 = $category_array[1];
    $filter3 = $category_array[2];
} elseif (count($category_array) == 4){
    $filter1 = $category_array[0];
    $filter2 = $category_array[1];
    $filter3 = $category_array[2];
    $filter4 = $category_array[3];
} elseif (count($category_array) == 5){
    $filter1 = $category_array[0];
    $filter2 = $category_array[1];
    $filter3 = $category_array[2];
    $filter4 = $category_array[3];
    $filter5 = $category_array[4];
}

if (count($difficulty_array) == 1){
    $diff_filter1 = $difficulty_array[0];
    $diff_filter2 = "없음";
    $diff_filter3 = "없음";
} elseif (count($difficulty_array) == 2){
    $diff_filter1 = $difficulty_array[0];
    $diff_filter2 = $difficulty_array[1];
    $diff_filter3 = "없음";
} elseif (count($difficulty_array) == 3){
    $diff_filter1 = $difficulty_array[0];
    $diff_filter2 = $difficulty_array[1];
    $diff_filter3 = $difficulty_array[2];
}

if (count($time_array)==2){
    $time_filter1 = (int)$time_array[0];
    $time_filter2 = (int)$time_array[1];
}

$sql_select = "SELECT * FROM vod_table V
INNER JOIN user_table U ON V.user_id = U.user_id
WHERE V.vod_category REGEXP ('$filter1|$filter2|$filter3|$filter4|$filter5') AND V.vod_difficulty REGEXP ('$diff_filter1|$diff_filter2|$diff_filter3') AND V.vod_time >= $time_filter1 AND V.vod_time <= $time_filter2
ORDER BY vod_id DESC";

$result_select = mysqli_query($conn, $sql_select);

if (mysqli_num_rows($result_select) <= $last_num){
    $end = true;
    if(mysqli_num_rows($result_select) - $prev_step > 0){
        $limit = mysqli_num_rows($result_select) - $prev_step;
    } else {
        $limit = 0;
    }
}


$tmp_array = array();

// $sql2 = "SELECT * FROM vod_table V
// INNER JOIN user_table U ON V.user_id = U.user_id
// WHERE V.vod_category REGEXP ('$filter1|$filter2|$filter3|$filter4|$filter5') AND V.vod_difficulty REGEXP ('$diff_filter1|$diff_filter2|$diff_filter3') AND V.vod_time >= $time_filter1 AND V.vod_time <= $time_filter2
// ORDER BY vod_id DESC";

$sql2 = "SELECT * FROM vod_table V
INNER JOIN user_table U ON V.user_id = U.user_id
WHERE V.vod_category REGEXP ('$filter1|$filter2|$filter3|$filter4|$filter5') AND V.vod_difficulty REGEXP ('$diff_filter1|$diff_filter2|$diff_filter3') AND V.vod_time >= $time_filter1 AND V.vod_time <= $time_filter2 AND V.vod_id < $cursor
ORDER BY vod_id DESC
LIMIT $limit";

// $sql2 = "SELECT * FROM vod_table V
// INNER JOIN user_table U ON V.user_id = U.user_id
// WHERE V.vod_category REGEXP ('$filter1|$filter2|$filter3|$filter4|$filter5') AND V.vod_difficulty = '$filter_difficulty'
// ORDER BY vod_id DESC";

// $sql2 = "SELECT * FROM vod_table V
// INNER JOIN user_table U ON V.user_id = U.user_id
// WHERE V.vod_category LIKE '%$filter_category%'
// ORDER BY vod_id DESC";

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

$response = array("resultArray"=>$tmp_array,"cursor" => $tmp_array[$limit-1]['vod_id'],"end"=>$end);

echo json_encode($response);

// echo json_encode(array("resultArray"=>$tmp_array),JSON_UNESCAPED_UNICODE);

mysqli_close($conn);

?>
