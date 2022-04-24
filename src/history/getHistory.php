<?php

require_once '../connect.php';

$user_id = $_POST['user_id'];

$tmp_array = array();
$tmp_split_array = array();
$tmp_date_array = array();
$new_array = array();

$sql2 = "SELECT *,date_format(hy_cdate, '%y %m %d') as cdate FROM history_table H
INNER JOIN user_table U ON H.user_id = U.user_id
INNER JOIN vod_table V ON H.vod_id = V.vod_id
WHERE H.user_id = '$user_id'
ORDER BY hy_id DESC";

$result2 = mysqli_query($conn, $sql2);

if(mysqli_num_rows($result2) > 0){
    while($row2 = mysqli_fetch_assoc($result2)){
        //$tmp_array = array();
        array_push($tmp_date_array, $row2['cdate']);
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

$distinct_array = array();
$distinct_value = "";

for($i=0; $i<count($tmp_date_array); $i=$i+1)
	{
        if($tmp_date_array[$i] != $distinct_value){

            if($tmp_date_array[$i] == date("y m d")){

                array_push($distinct_array,array("오늘",$i));
                $distinct_value = $tmp_date_array[$i];

            }elseif($tmp_date_array[$i] == date("y m d",strtotime("-1 days"))){

                array_push($distinct_array,array("어제",$i));
                $distinct_value = $tmp_date_array[$i];

            }else {
                $split = explode(' ',$tmp_date_array[$i]);
                
                $split[1] = intval($split[1]);
                $split[2] = intval($split[2]);
                
                $str_date = $split[0]."년 ".$split[1]."월 ".$split[2]."일";
                array_push($distinct_array,array($str_date,$i));
                $distinct_value = $tmp_date_array[$i];

            }
        }
	}

$slice_array = array();
    
for($i=0; $i<count($distinct_array); $i=$i+1)
	{
        if($i != count($distinct_array)-1){
            array_push($slice_array,array_slice($tmp_array,$distinct_array[$i][1],$distinct_array[$i+1][1] - $distinct_array[$i][1]));
        }
        else {
            array_push($slice_array,array_slice($tmp_array,$distinct_array[$i][1], count($tmp_date_array) - $distinct_array[$i][1]));
        }
	}
    
for($i=0; $i<count($distinct_array); $i=$i+1){
    array_push($new_array,array('history_date'=>$distinct_array[$i][0], "resultArray"=>$slice_array[$i]));
}



$response = array("resultHisArray"=>$new_array);


echo json_encode($response);

mysqli_close($conn);


?>
