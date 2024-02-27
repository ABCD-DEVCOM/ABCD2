<?php
/**
 * 20230517 rogercgui Script created to send e-mails.
 */

function SendPhpMail($to,$name,$body,$ini){
global $enviados,$msgstr,$Web_Dir;
	$subject = $ini["SUBJECT"];
// NOT SUGGESTED TO CHANGE THESE VALUES
	$headers = 'From: ' . $ini[ "FROM" ] . PHP_EOL ;
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	$resultado=mail ( $to, $subject,$body, $headers ) ;
	echo "<p><font face=arial> ".$msgstr["front_from"].": ".$ini["FROM"];//."  ".$_REQUEST["nombre"];
}



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


function SendMail($mail,$to,$name,$body,$ini){
global $enviados,$msgstr,$Web_Dir;

require $Web_Dir.'classes/PHPMailer/Exception.php';
require $Web_Dir.'classes/PHPMailer/PHPMailer.php';
require $Web_Dir.'classes/PHPMailer/SMTP.php';

	//CUERPO DEL MENSAJE
    $mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth   = true;                  	// enable SMTP authentication
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
	$mail->Host       = $ini["HOST"];      		// sets the SMTP server
	$mail->Port       = $ini["PORT"];           // set the SMTP port

	if (isset($ini["USERNAME"])) $mail->Username   = $ini["USERNAME"];  // GMAIL username
	if (isset($ini["PASSWORD"]))  $mail->Password   = $ini["PASSWORD"];       // GMAIL password

	$mail->From       = $ini["FROM"];
	$mail->FromName   = $ini["FROMNAME"];
	$mail->Subject    = $ini["SUBJECT"];
	$mail->ContentType= "text/html";
	$mail->AltBody    = "Debe habilitar el modo HTML para visualizar el resultado de la consulta"; //Text Body
	$mail->WordWrap   = 200; // set word wrap
	$mail->MsgHTML($body);


	$mail->AddAddress($to,$name);
    $mail->SMTPDebug  = 0;
	$mail->IsHTML(true); // send as HTML
	$mail->CharSet = 'utf-8';
  	echo "<p><font face=arial>".$msgstr["front_from"].": ".$ini["FROM"].". ".$ini["FROMNAME"];
	echo "<br>".$msgstr["front_to"].": ".$to."  ".$_REQUEST["nombre"];

	if(!$mail->Send()) {
  		echo "<br> ".$msgstr["front_mail_error"].": " . $mail->ErrorInfo;
	} else {

		echo "<br><strong> ".$msgstr["front_mail_sent"]."</strong>";
	}
	
}
?>