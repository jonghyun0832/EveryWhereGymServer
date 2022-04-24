<?php

require_once '../connect.php';

$user_id = $_POST['user_id'];

$sql = "DELETE FROM search_table WHERE user_id = '$user_id'";

if (mysqli_query($conn,$sql)){

    $tmp_array = array();

    $sql2 = "SELECT *, date_format(sh_cdate, '%m.%d') as cdate FROM search_table
    WHERE user_id = '$user_id'
    ORDER BY sh_id DESC";

    $result2 = mysqli_query($conn, $sql2);

    if(mysqli_num_rows($result2) > 0){
        while($row2 = mysqli_fetch_assoc($result2)){
            //$tmp_array = array();
            array_push($tmp_array, array(
                'search_text'=>$row2['sh_text'],
                'search_date'=>$row2['cdate'],
                'search_id'=>$row2['sh_id']
            ));
        }

        $response = array("resultArray"=>$tmp_array, "isSuccess"=>true);
        echo json_encode($response);

    } else {
        $response = array("resultArray"=>$tmp_array, "isSuccess"=>false);
        echo json_encode($response);
    }
    
}

mysqli_close($conn);

?>