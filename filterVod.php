<?php

require_once 'connect.php';

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


$category_array = explode(', ',$filter_category);
$difficulty_array = explode(', ',$filter_difficulty);

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

//일단은 카테고리 필터만 ㄱㄱ 
//sql 문 만들어야함

$tmp_array = array();
//if ($filter_difficulty == null || $filter_time == null){

$sql2 = "SELECT * FROM vod_table V
INNER JOIN user_table U ON V.user_id = U.user_id
WHERE V.vod_category REGEXP ('$filter1|$filter2|$filter3|$filter4|$filter5') AND V.vod_difficulty REGEXP ('$diff_filter1|$diff_filter2|$diff_filter3')
ORDER BY vod_id DESC";




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


echo json_encode(array("resultArray"=>$tmp_array),JSON_UNESCAPED_UNICODE);

mysqli_close($conn);

?>
