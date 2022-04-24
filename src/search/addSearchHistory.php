<?php

require_once '../connect.php';

$user_id = $_POST['user_id'];
$search_text = $_POST['search_text'];

$sql_check = "SELECT * FROM search_table WHERE user_id = '$user_id' AND sh_text = '$search_text'";

$result_check = mysqli_query($conn, $sql_check);

if (mysqli_num_rows($result_check) != 0){

    $sql_delete = "DELETE FROM search_table WHERE user_id = '$user_id' AND sh_text = '$search_text'";
    if (mysqli_query($conn,$sql_delete)){
        $response['isSuccess'] = true;
    } else {
        $response['isSuccess'] = false;
        echo json_encode($response);
    }
    
}

$sql_insert = "INSERT INTO search_table(user_id, sh_text) VALUES('$user_id','$search_text')";

if (mysqli_query($conn,$sql_insert)){
    $response['isSuccess'] = true;
} else {
    $response['isSuccess'] = false;
}

echo json_encode($response);

mysqli_close($conn);

?>