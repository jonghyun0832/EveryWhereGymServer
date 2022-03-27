<?php

require_once 'connect.php';

$uploader_id = $_POST['uploader_id'];
$page = $_POST['page'];
$cursor = $_POST['cursor'];
$limit = 4;

if($cursor == 0){
    $cursor = 99999;
}

$end = false;

$last_num = $page * $limit;
$prev_step = ($page-1) * $limit;

$sql_select = "SELECT * FROM review_table R
WHERE R.trainer_id = '$uploader_id'
ORDER BY rv_id DESC";

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

$sql2 = "SELECT *, date_format(rv_date, '%Y.%c.%d') as todaydate FROM review_table R
INNER JOIN user_table U ON R.user_id = U.user_id
WHERE R.trainer_id = '$uploader_id' AND rv_id < '$cursor'
ORDER BY rv_id DESC
LIMIT $limit";

$result2 = mysqli_query($conn, $sql2);
$last_cursor = 0;

if(mysqli_num_rows($result2) > 0){
    while($row2 = mysqli_fetch_assoc($result2)){
        //$tmp_array = array();
        array_push($tmp_array, array(
            'rv_score'=>$row2['rv_score'],
            'user_id'=>$row2['user_id'],
            'rv_id'=>$row2['rv_id'],
            'rv_text'=>$row2['rv_text'],
            'rv_date'=>$row2['todaydate'],
            'user_name'=>$row2['user_name'],
            'img_path'=>$row2['user_img'],
            'rv_title'=>$row2['rv_title']
        ));
        $last_cursor = $row2['rv_id'];
    }
}
$response = array("resultArray"=>$tmp_array,"cursor" => $last_cursor,"end"=>$end);
echo json_encode($response);

//echo json_encode(array("resultArray"=>$tmp_array),JSON_UNESCAPED_UNICODE);

mysqli_close($conn);

?>
