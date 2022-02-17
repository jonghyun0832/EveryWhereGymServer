<?php

require_once 'connect.php';

$tmp_array = array();

$getted_date = $_POST['select_date'];

date_default_timezone_set('Asia/Seoul');
$timestamp_now = strtotime("Now");
//$timestamp_able = strtotime("-2 minutes");
$today = date("H:i",$timestamp);
$today2 = date("H:i",$timestamp2);


$sql = "SELECT *,date_format(li_date, '%Y.%c.%d') as todaydate, date_format(li_date, '%Y-%c-%d') as stamp FROM live_table L
INNER JOIN user_table U ON L.user_id = U.user_id
HAVING todaydate = '$getted_date'
ORDER BY li_id DESC";

$result = mysqli_query($conn, $sql);

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
            'live_date'=>$row['li_date'],
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
            'open'=>$row['li_open'],
            'enable'=>$enable
        ));
    }
}

$sql_count = "SELECT li_id,count(*) as cnt FROM alarm_table group by li_id";

$result_count = mysqli_query($conn, $sql_count);

if(mysqli_num_rows($result_count) > 0){
    while($row = mysqli_fetch_assoc($result_count)){
        for($i=0; $i<count($tmp_array); $i=$i+1){
            if($tmp_array[$i]['live_id'] == $row['li_id']){
                $tmp_array[$i]['alarm_num'] = $row['cnt'];
            }
        }
    }
}

echo json_encode(array("resultArray"=>$tmp_array),JSON_UNESCAPED_UNICODE);

mysqli_close($conn);

?>
