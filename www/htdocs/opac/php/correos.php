<?php include ("config_opac.php");
header('Content-Type: text/html; charset=".$charset."');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset?>" />
	<title><?php echo $TituloPagina?></title>
</head>
<body>
<div id="header-wrapper">
	<div id="header">
		<div id="logo">
			<h1><a href="<?php echo $link_logo?>"><img src=<?php echo $logo?>></a></h1>
		</div>
	</div>
</div>
<div id="wrapper">

	<div id="page" style='float:left;width:90%'>
		<div id="content" style='float:left;width:90%'>
		<br>
<?php



//foreach ($_REQUEST as $var=>$value)  echo "$var=$value<br>";

function wxisLlamar($base,$query,$IsisScript){
global $db_path,$Wxis,$xWxis;
	include("wxis_llamar.php");
	return $contenido;
}

function SendPhpMail($to,$name,$body,$ini){global $enviados,$msgstr;
	$subject = $ini["SUBJECT"];
// NOT SUGGESTED TO CHANGE THESE VALUES
	$headers = 'From: ' . $ini[ "FROM" ] . PHP_EOL ;
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$resultado=mail ( $to, $subject,$body, $headers ) ;
	echo "<p><font face=arial> ".$msgstr["from"].": ".$ini["FROM"];//."  ".$_REQUEST["nombre"];

}

function SendMail($mail,$to,$name,$body,$ini){
global $enviados,$msgstr;
	//CUERPO DEL MENSAJE
    $mail= new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth   = true;                  	// enable SMTP authentication
	$mail->SMTPSecure = "ssl";                 	// sets the prefix to the servier
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
    $mail->SMTPDebug  = 1;
	$mail->IsHTML(true); // send as HTML
    //echo "<META HTTP-EQUIV=Content-Type; CONTENT=text/html; charset=ISO-8859-1>";
  	echo "<p><font face=arial>".$msgstr["from"].": ".$ini["FROM"].". ".$ini["FROMNAME"];
	echo "<br>".$msgstr["to"];//.": ".$to."  ".$_REQUEST["nombre"];

	if(!$mail->Send()) {
  		echo "<BR> ".$msgstr["mail_error"].": " . $mail->ErrorInfo;
	} else {

		echo "<br><STRONG> ".$msgstr["mail_sent"]."</strong>";
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

$msgstr["from"]="de";
$msgstr["to"]="a";
$msgstr["mail_error"]="Error al enviar el correo";
$msgstr["mail_sent"]="Su solicitud ha sido enviada";

$fp=file("correo.ini");

foreach ($fp as $key=>$value){	$value=trim($value);
	if ($value!=""){		$x=explode('=',$value);
		$ini[$x[0]]=$x[1];	}}
$Expresion="";
$icuenta=0;
$desde=0;
//$acc=explode("|",$_REQUEST["seleccion"]);
//$accion=$acc[0];
$enviados=0;
$list=explode('|',$_REQUEST["cookie"]);
$contador=0;
$ix=0;
$Total_No=0;
$items_por_reservar="";
foreach ($list as $value){
	$value=trim($value);
	if ($value!="")	{
		$x=explode('_',$value);
		$seleccion[$x[1]][]=$x[2];
	}
}
$mensaje="";
echo "<hr style=\"border: 5px solid #cccccc;border-radius: 5px;\">";
foreach ($seleccion as $base=>$value){	$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/".$base."_formatos.dat";
    $fp=file($archivo);
    $primeravez="S";
    foreach ($fp as $ff){
    	$ff=trim($ff);
    	if ($ff!=""){
    		$ff_arr=explode('|',$ff);
    		if (isset($ff_arr[2]) and $ff_arr[2]=="Y"){
    			$fconsolidado=$ff_arr[0];
    			break;
    		}else{
    			if ($primeravez=="S"){
    				$primeravez="N";
    				$fconsolidado=$ff_arr[0];
    			}
    		}
    	}
    }
	$fconsolidado=str_replace(".pft","",$fconsolidado);
	$Pft="@".$fconsolidado.".pft";
    foreach ($value as $mfn_X){
		$Mfn="'$mfn_X'";
		$contador=$contador+1;
		$query = "&base=$base&cipar=$db_path"."par/$base.par&Mfn=$Mfn&Formato=$Pft&Opcion=buscar&lang=".$_REQUEST["lang"];
	//echo "$query<br>";
		$resultado=wxisLlamar($base,$query,$xWxis."opac/imprime_sel.xis");
		foreach($resultado as $contenido) $mensaje.="$contenido";
	}
}
echo "<h3>Correo enviado ".date("d-m-y h:m")."</h3><p>";
include("class.phpmailer.php");
$mail= new PHPMailer();
//foreach ($_REQUEST as $key=>$value)  echo "$key=$value<br>";//die;

if (!isset($ini["FROM"]) or trim($ini["FROM"])=="")
   $ini["FROM"]=trim($_REQUEST["email"]);

if (isset($ini["TEST"])){
	$to=$ini["TEST"];
}else{	$to=$_REQUEST["email"];}
$name="Usuario Web";
$body="Solicitud enviada por: <br>";
$body.=$_REQUEST["email"]."<br>";
if (isset($_REQUEST["comentario"])) $body.=nl2br(urldecode($_REQUEST["comentario"]));
$body.="<p>"."Seleccionados:<br>".$mensaje;
echo $body;
if (isset($ini["PHPMAILER"]) and $ini["PHPMAILER"]=="phpmailer"){
	SendMail($mail,$to,$name,$body,$ini);
}else{	SendPhpMail($to,$name,$body,$ini);}
flush();

echo "<form name=regresar action=buscar_integrada.php method=post>";
foreach ($_REQUEST as $key=>$value){
	echo "<input type=hidden name=$key value=\"$value\">\n";
}
echo "<input type=submit name=regresar_btn value=\" ".$msgstr["back"]." \">";
echo "</form>";
?>

</body>
</html>

