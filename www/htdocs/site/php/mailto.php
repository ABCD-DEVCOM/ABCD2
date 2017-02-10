<?php
    require_once("../php/include.php");
    require_once("../php/class.phpmailer.php");

    // use internal php mail function
    function sendByMail($to, $subject, $fromName, $from, $message)
    {
        $ip = getenv("REMOTE_ADDR");
        $text = "";

        $text .= "<p>".$message."</p>";
        $text .= "<p>".$fromName." &lt;<a href=\"mailto:".$from."\">".$from."</a>&gt;<br>".$ip."</p>";

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

        $headers .= "From: ".$from."\r\n";

        return mail($to,$subject,$text,$headers);
    }

    // use phpmailer class to send by SMTP
    function sendBySMTP($to, $subject, $fromName, $from, $message)
    {
        global $def;

        $mail = new PHPMailer();

        $mail->IsSMTP();  // set mailer to use SMTP
        $mail->Host = $def["SMTP_HOST"];  // specify main and backup server
        $mail->SMTPAuth = true;  // turn on SMTP authentication
        $mail->Username = $def["SMTP_USERNAME"];  // SMTP username
        $mail->Password = $def["SMTP_PASSWORD"]; // SMTP password

        $ip = getenv("REMOTE_ADDR");

        $text = "";

        $text .= "<p>".$message."</p>";
        $text .= "<p>".$fromName." &lt;<a href=\"mailto:".$from."\">".$from."</a>&gt;<br>".$ip."</p>";

        $mail->FromName = $fromName;
        $mail->From     = $from;
        $mail->AddAddress($to);

        $mail->IsHTML(true);  // set email format to HTML

        $mail->Subject = $subject;
        $mail->Body    = $text;

        if( !$mail->Send() ){
            echo $mail->ErrorInfo;
            return false;
        }

        $mail->ClearAddresses();
        $mail->ClearAttachments();

        return true;
    }

//------------------------------------------------------------------------------

$mode = 'response';

$subject = sprintf("%d", $_POST["subject"]);

foreach ( array('from', 'fromName', 'message') as $post){
    if (isset($_POST[$post])){
        $$post = $_POST[$post];
    } else {
        $mode = 'error_'.$post;
        $subject = -1;
    }
}

$xml = simplexml_load_file($localPath['xml'].'bvs.xml');
$contact = $xml->xpath("contact//item[@id = '$subject']");

if ( count($contact) == 1 ){
    $contact = $contact[0];
    
    $to = (String) $contact['href'];
    $subject = utf8_decode((String) $contact);

    $message = htmlentities($message);
    $message = preg_replace('/(\r\n|\r|\n)/', '<br/>', $message);

    if ($def['SMTP_HOST'] != ''){
        sendBySMTP($to, $subject, $fromName, $from, $message);
    }else{
        sendByMail($to, $subject, $fromName, $from, $message);
    }
}

header("Location: ". DIRECTORY . 'php/contact.php?lang='.$lang.'&mode='.$mode);

?>
