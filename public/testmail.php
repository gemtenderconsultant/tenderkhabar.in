<?php
//echo date("Y-m-d H:i:s");die();
require_once "php_mailer/vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function email_phpmailer2($emailid = array(), $subject, $body,$username,$password,$from,$fromname,$host){
    $mail = new PHPMailer;
    //Enable SMTP debugging.
    $mail->SMTPDebug = 0;                           
    //Set PHPMailer to use SMTP.
    $mail->isSMTP();        
    //Set SMTP host name                      
    $mail->Host = $host;
    //Set this to true if SMTP host requires authentication to send email
    $mail->SMTPAuth = true;                      
    //Provide username and password
    $mail->Username = $username;             
    $mail->Password = $password;            

    //If SMTP requires TLS encryption then set it
    //$mail->SMTPSecure = "tls";    //for gmail

    //Set TCP port to connect to
    $mail->Port = 587;                    
    $mail->From = $from;
    $mail->FromName = $fromname;
    $mail->addReplyTo('noreply@tenderkhabar.com', 'TenderKhabar');
    $mail->addAddress($emailid[0], "");
    foreach($emailid as $ek => $email)
    {
        if($ek != 0)
        {
          $mail->AddCC($email);
        }
    }
    $mail->AddCC('tenderkhabar2@gmail.com'); // change
    //$mail->addCustomHeader('X-Custom-ID', uniqid());
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    //$mail->AltBody = "This is the plain text version of the email content";
    if(!$mail->send())
    {
    $result = "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
    $result = "Message has been sent successfully";
    }
   return $result; 

}
function email_phpmailer($emailid = array(), $subject, $body,$username,$password,$from,$fromname,$host){
	$mail = new PHPMailer;
	//Enable SMTP debugging.
	$mail->SMTPDebug = 0;                           
	//Set PHPMailer to use SMTP.
	$mail->isSMTP();        
	//Set SMTP host name                      
	$mail->Host = $host;
	//Set this to true if SMTP host requires authentication to send email
	$mail->SMTPAuth = true;                      
	//Provide username and password
	$mail->Username = $username;             
	$mail->Password = $password;            

	//If SMTP requires TLS encryption then set it
	//$mail->SMTPSecure = "tls";    //for gmail

	//Set TCP port to connect to
	$mail->Port = 587;                    
	$mail->From = $from;
	$mail->FromName = $fromname;
	$mail->addReplyTo('noreply@tenderkhabar.com', 'TenderKhabar');
	$mail->addAddress($emailid[0], "");
	foreach($emailid as $ek => $email)
    {
        if($ek != 0)
        {
          $mail->AddCC($email);
        }
    }
    //$mail->AddCC('patel.gautish2008@gmail.com'); // change

	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $body;
	//$mail->AltBody = "This is the plain text version of the email content";
	if(!$mail->send())
	{
	$issent =  "Mailer Error: " . $mail->ErrorInfo;
	}
	else
	{
	$issent = "Message has been sent successfully";
	}

	return $issent;
}




$emailUser = "emailapikey";
$emailPassword = "PHtE6r0KQe/jjjIsoBZSsfXrQJShZ957/u9ueQRFs4ZLA/MHHE1TqIp+l2DlohsjXfMWR/aTwI9t4ruU5+qBJWe+Mz1MWWqyqK3sx/VYSPOZsbq6x00ft18bfkLUVYbmdNBi1y3Rs9jfNA==";
$host = "smtp.zeptomail.in";
$from = 'noreply@tenderkhabar.com';
$fromname = 'TenderKhabar'; 


$email_recipients = array('nishap@gemtenderconsultant.com');
$subject = "test mail";
$body = "<h1>gautish111</h2>";
echo $mailsent = email_phpmailer2($email_recipients, $subject, $body,$emailUser,$emailPassword,$from,$fromname,$host);

die();
$to = "farhankhoja007@outlook.com";
$subject = "HTML email";

$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body> 
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers 
$headers .= 'From: <noreply@tenderkhabar.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

echo $ismail = mail($to,$subject,$message,$headers);
if (!$ismail) {
    echo "sfdsf";
    echo $errorMessage = error_get_last()['message'];
}
$posts = array();
$datetime = date('Y-m-d H:i:s');
$posts[] = array('id'=> "1", 'name'=> $ismail, 'time'=> $datetime); 
$fp = fopen('test.txt', 'w');
fwrite($fp, json_encode($posts));
fclose($fp);

?>