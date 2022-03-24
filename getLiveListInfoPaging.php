<?php

require_once 'connect.php';

$tmp_array = array();

$getted_date = $_POST['select_date'];
$page = $_POST['page'];
$limit = $_POST['limit'];
$cursor = $_POST['cursor'];

$end = false;

$last_num = $page * $limit;
$prev_step = ($page-1) * $limit;

// if($cursor == 0){
//     $cursor = 99999;
// }

$sql_select = "SELECT *,date_format(li_date, '%Y.%c.%d') as todaydate, date_format(li_date, '%Y-%c-%d') as stamp FROM live_table L
INNER JOIN user_table U ON L.user_id = U.user_id
HAVING todaydate = '$getted_date'
ORDER BY li_id DESC";

$result_select = mysqli_query($conn, $sql_select);

if (mysqli_num_rows($result_select) <= $last_num){
    $end = true;
    if(mysqli_num_rows($result_select) - $prev_step > 0){
        $limit = mysqli_num_rows($result_select) - $prev_step;
    } else {
        $limit = 0;
    }
}




date_default_timezone_set('Asia/Seoul');
$timestamp_now = strtotime("Now");
//$timestamp_able = strtotime("-2 minutes");
$today = date("H:i",$timestamp);
$today2 = date("H:i",$timestamp2);


// $sql = "SELECT *,date_format(li_date, '%Y.%c.%d') as todaydate, date_format(li_date, '%Y-%c-%d') as stamp FROM live_table L
// INNER JOIN user_table U ON L.user_id = U.user_id
// HAVING todaydate = '$getted_date'
// ORDER BY li_id DESC";
//

$sql = "SELECT *,date_format(li_date, '%Y.%c.%d') as todaydate, (li_start_hour*6000 + li_start_minute*100 - li_id) as cnt, date_format(li_date, '%Y-%c-%d') as stamp FROM live_table L
INNER JOIN user_table U ON L.user_id = U.user_id
INNER JOIN trainer_table T ON L.user_id = T.user_id
HAVING todaydate = '$getted_date' AND cnt > $cursor AND li_done = '0'
ORDER BY cnt
LIMIT $limit";

$result = mysqli_query($conn, $sql);
$last_cnt = 0;

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $enable = "0";
        $strtime = $row['stamp']." ".$row['li_start_hour'].":".$row['li_start_minute'].":00";
        //$timestamp_start_time = strtotime($strtime);
        $timestamp_start = strtotime($strtime." -2 minutes");
        if($timestamp_now >= $timestamp_start){
            $enable = "1";
        }
        array_push($tmp_array, array(
            'live_id'=>$row['li_id'],
            'live_date'=>$row['todaydate'],
            'live_title'=>$row['li_title'],
            'live_start_hour'=>$row['li_start_hour'],
            'live_start_minute'=>$row['li_start_minute'],
            'live_spend_time'=>$row['li_spend_time'],
            'live_calorie'=>$row['li_calorie'],
            'live_join'=>$row['li_join'],
            'live_limit_join'=>$row['li_limit_join'],
            'live_material'=>$row['li_material'],
            'uploader_id'=>$row['user_id'],
            'uploader_name'=>$row['user_name'],
            'uploader_img'=>$row['user_img'],
            'trainer_score'=>$row['tr_score'],
            'open'=>$row['li_open'],
            'enable'=>$enable
        ));
        $last_cnt = $row['cnt'];
    }
}

//echo json_encode(array("resultArray"=>$tmp_array),JSON_UNESCAPED_UNICODE);

$response = array("resultArray"=>$tmp_array,"cursor" => $last_cnt,"end"=>$end);

echo json_encode($response);

mysqli_close($conn);

?>
