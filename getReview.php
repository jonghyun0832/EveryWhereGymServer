<?php

require_once 'connect.php';

$uploader_id = $_POST['uploader_id'];

$tmp_array = array();

$sql2 = "SELECT *, date_format(rv_date, '%Y.%c.%d') as todaydate FROM review_table R
INNER JOIN user_table U ON R.user_id = U.user_id
WHERE R.trainer_id = '$uploader_id'
ORDER BY rv_id DESC";
$result2 = mysqli_query($conn, $sql2);

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
    }
}


echo json_encode(array("resultArray"=>$tmp_array),JSON_UNESCAPED_UNICODE);

mysqli_close($conn);

?>
