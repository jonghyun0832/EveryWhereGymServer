<?php

require_once 'connect.php';

$tmp_array = array();

$user_id = $_POST['user_id'];

$sql = "SELECT DATE_FORMAT(li_date, '%Y %c %d') as m FROM live_table
WHERE user_id = '$user_id'
GROUP BY m
ORDER BY m";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $split = explode(" ",$row['m']);
        array_push($tmp_array, array($split[0],$split[1],$split[2]));
    }
}

echo json_encode(array("eventArray"=>$tmp_array),JSON_UNESCAPED_UNICODE);

mysqli_close($conn);

?>
