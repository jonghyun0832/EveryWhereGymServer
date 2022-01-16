<?php

$user_mail = $_GET['email'];

require_once '../connect.php';

$sql = "SELECT user_id FROM user_table WHERE user_email = '$user_mail'";
$result = mysqli_query($conn, $sql);
$data_num = mysqli_num_rows($result);

if ($data_num == 0){ //회원가입된 이메일이 없을때
    echo json_encode(array("response"=>"bad"));
} else { //회원가입 되어있을때

    $cnum = sprintf("%04u",rand(0000,9999));

    include "PHPMailer.php";
    include "SMTP.php";

    $mail = new PHPMailer();

    $mail->isSMTP();

    $mail->SMTPDebug = SMTP::DEBUG_OFF;

    $mail->Host = 'smtp.naver.com';

    $mail->Port = 465;

    $mail->SMTPSecure = 'ssl';

    $mail->SMTPAuth = true;

    $mail->Username = 'sjh_0832';

    $mail->Password = 'CGS66MKRSWE5';

    $mail->CharSet = 'UTF-8';

    $mail->setFrom('sjh_0832@naver.com', '어디든짐');

    $mail->addReplyTo('sjh_0832@naver.com', '어디든짐');

    $mail->addAddress($user_mail, '이건뭐임');

    $mail->Subject = '어디든짐(GYM) 비밀번호 재설정 인증 메세지입니다';

    $mail->msgHTML("어디든짐 비밀번호 재설정 인증 번호입니다. <br> 인증번호는 <b>".$cnum."</b> 입니다.");

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo json_encode(array("response"=>"good","email"=>$user_mail, "cnum"=>$cnum));
    }
}

?>
