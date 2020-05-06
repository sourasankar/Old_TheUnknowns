<?php

require 'phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = 'smtp.hostinger.in';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'support@kootty420.live';
$mail->Password = 'KSS103003#';
$mail->setFrom('support@kootty420.live', 'The Unknowns');
$mail->addReplyTo('support@kootty420.live', 'The Unknowns');
$mail->addAddress('soura.kootty4@gmail.com', 'SOURA SANKAR MONDAL');
$mail->Subject = 'Testing PHPMailer';
            $htmlStr = "";
            $htmlStr .= "Hi $uname,<br /><br />"; 
            $htmlStr .= "Please click the button below to verify your Account.<br /><br /><br />";
            $htmlStr .= "<a href='http://kootty420.live/verify.php?verify=$link' target='_blank' style='padding:1em; font-weight:bold; background:#8e44ad; color:#fff;text-decoration: none;'>VERIFY ACCOUNT</a><br /><br /><br />"; 
            $htmlStr .= "Kind regards,<br />";
            $htmlStr .= "<a href='http://kootty420.live' target='_blank'> Th€ Unknow$</a><br />";
$mail->msgHTML($htmlStr);
$mail->send();
//$mail->Body = 'This is a plain text message body';
//$mail->addAttachment('test.txt');
/*if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'The email message was sent.';
}*/
?>