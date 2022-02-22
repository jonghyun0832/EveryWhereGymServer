<?php

require_once 'connect.php';

$user_id = $_POST['user_id'];

//나중에 리사이클러뷰에 표시할 내 라이브 데이터도 가져와야되서 getinfo말고 새로만든거임
//inner join사용해서 user_table이랑 trainer_table합쳐서 사용 ㄱㄱ
$sql = "SELECT user_name, user_img, tr_img, tr_intro, tr_expert, tr_career, tr_certify, tr_score FROM user_table U
INNER JOIN trainer_table T ON U.user_id = T.user_id WHERE U.user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

if ($result)
{
    $response['success'] = true;
    $response['user_name'] = $row[0];
    $response['user_img'] = $row[1];
    $response['tr_img'] = $row[2];
    $response['tr_intro'] = $row[3];
    $response['tr_expert'] = $row[4];
    $response['tr_career'] = $row[5];
    $response['tr_certify'] = $row[6];
    $response['tr_score'] = $row[7];
}
else
{
    $response['success'] = false;
}

echo json_encode($response);

//
?>
