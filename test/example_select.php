<?php

header("Content-type:application/json");

require_once 'connect.php';

$name = $_GET['name'];
$hobby = $_GET['hobby'];

$sql = "SELECT * FROM firsttest WHERE name = '$name'";

$result = mysqli_query($conn, $sql);

$data_num = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

if ($data_num >0){
    $error = "success";
    echo json_encode(array("response"=>$error, "name"=>$row[1],"hobby"=>$row[2]));

} else {
    $error = "failed";
    echo json_encode(array("response"=>$error));
}

mysqli_close($conn);

?>