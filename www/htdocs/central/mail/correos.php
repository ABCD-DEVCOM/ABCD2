<?php
set_time_limit(0);
session_start();
?>
<html>
    <title>Envío de Correos</title>
	<style>
		body{
			font-family:arial;
			font-size:12px;
		}
	</style>
    <head>

    </head>
<body>
<?php
echo "<h3>Reporte de correos enviados el ".date("d-m-y h:m")."</h3><p>";
//error_reporting(0);

include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("class.phpmailer.php");
$mail= new PHPMailer();
//foreach ($_REQUEST as $key=>$value)  echo "$key=$value<br>"; die;

function LlamarWxis($query,$IsisScript){
global $xWxis,$Wxis,$db_path,$wxisUrl;
	include("../common/wxis_llamar.php");
	return($contenido);
}

//Se lee el cuerpo del mensaje
$IsisScript=$xWxis."leer_mfnrange.xis";
$ex=explode('|',$arrHttp["actividad"]);
$Formato=$ex[1];
$Mfn_doc=$ex[0];
$IsisScript=$xWxis."buscar.xis";

function getScriptOutput($path, $print = FALSE){
    ob_start();
    if( is_readable($path) && $path ){
        include $path;
    }else{
        return FALSE;
    }

    if( $print == FALSE )
        return ob_get_clean();
    else
        echo ob_get_clean();
}

function SendPhpMail($to,$name,$invitacion,$ini,$cuenta,$desde){
global $enviados;
	$subject = $ini["SUBJECT"];
// NOT SUGGESTED TO CHANGE THESE VALUES
	$headers = 'From: ' . $ini[ "FROM" ] . PHP_EOL ;
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	//$invitacion=$name."<p>".$invitacion;
	$resultado=mail ( $to, $subject,$invitacion, $headers ) ;
	echo "<p><font face=arial size=1>($cuenta) Remitente: ".$ini["FROM"].". ".$ini["FROMNAME"];
	echo "<br>Destinatario: ".$to. " ".$name;
	if ($resultado)
		$enviados=$enviados+1;
}

function SendMail($mail,$to,$name,$invitacion,$ini,$cuenta,$desde){
global $enviados;
	//CUERPO DEL MENSAJE
	//$invitacion=$name."<p>".$invitacion;
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
	$mail->MsgHTML($invitacion);

	$mail->AddAddress($to,$name);
    $mail->SMTPDebug  = 1;
	$mail->IsHTML(true); // send as HTML
    //echo "<META HTTP-EQUIV=Content-Type; CONTENT=text/html; charset=ISO-8859-1>";
  	echo "<p><font face=arial size=1>Remitente: ".$ini["FROM"].". ".$ini["FROMNAME"];
	echo "<br>Destinatario: ".$to. " ".$name;
	$secuencia=$cuenta+$desde;
	if(!$mail->Send()) {
  		echo "<BR>($secuencia) Error al enviar el correo: " . $mail->ErrorInfo;
	} else {

		echo "<br><STRONG>($secuencia) Correo enviado!!!</strong>";
		$enviados=$enviados+1;
	}
}

//////////////////////////////////////////////////////////////////////////////////////////

$fp=file($db_path."distribucion/correo.ini");
if (!$fp){
	echo "Falta el archivo distribucion/"."correo.ini". " en la carpeta de las bases de datos";
	die;
}
foreach ($fp as $key=>$value){
	$value=trim($value);
	if ($value!=""){
		$x=explode('=',$value);
		$ini[$x[0]]=$x[1];
	}
}
$ex=explode('|',$_REQUEST["contactos"]);
$IsisScript=$xWxis."cipres_usuario.xis";
$Expresion="";
$icuenta=0;
$desde=0;
$enviados=0;
if (!isset($_REQUEST["desde"]))  $_REQUEST["desde"]=1;
if (!isset($_REQUEST["count"]))  $_REQUEST["count"]=count($ex)-1;
if (trim($_REQUEST["desde"])=="") $_REQUEST["desde"]=1;
if (trim($_REQUEST["count"])=="")  $_REQUEST["count"]=count($ex)-1;
//$mensaje=getScriptOutput("proteccion.php");
foreach ($ex as $value){
	$value=trim($value);
	if ($value!=""){
		if (isset($_REQUEST["desde"])){
			$desde=$desde+1;
			if ($desde<$_REQUEST["desde"]) continue;
		}
		$icuenta=$icuenta+1;
		if ($icuenta>$_REQUEST["count"]) break;
		$v=explode('$$$',$value);
//		$Expresion="NC_".trim($v[1]);
//		$ControlNumber=$v[1];
//		$Mfn=$v[2];
		$Expresion="NC_".trim($v[2]);
		$ControlNumber=$v[2];
		$Mfn=$v[1];
        $query = "&base=caras&cipar=$db_path"."par/caras.par&Expresion=".$Expresion."&Pft=v21'$$$'v1'$$$'v34^*\", \"v34^b'$$$',@".$db_path."caras/pfts/es/extrae_info.pft,' $$$',ref(['distribucion']$Mfn_doc,@".$db_path."distribucion/pfts/es/$Formato,)";
		$correo=LlamarWxis($query,$IsisScript);
		$correo=implode("\n",$correo);

		if (trim($correo)!=""){			$c=explode('$$$',$correo);
			if (isset($c[0]) and trim($c[0])!=""){
				if (isset($ini["TEST"])){
					$to=$ini["TEST"];
				}else{
					$to=$c[0];
				}
				$id=$c[1];
				$name=$c[2];
				$body=$c[4];
				if (isset($ini["PHPMAILER"]) and $ini["PHPMAILER"]=="phpmailer"){
					SendMail($mail,$to,$name,$body,$ini,$icuenta,$_REQUEST["desde"]-1);
				}else{
					SendPhpMail($to,$name,$body,$ini,$icuenta,$_REQUEST["desde"]-1);
				}
				flush();
    			ob_flush();
			}
		}

	}
} echo "<P>";
$aenviar=count($ex)-1;
$correos_enviados=$icuenta;
echo "Total correos a enviar: ".$aenviar."<br>";
echo "Total correos a enviados: ".$enviados."<p>";
$enviados=$_REQUEST["desde"]+$enviados-1;


if ($enviados<$aenviar){
	echo "<form name=continuar method=post action=correos.php>\n";
	echo "Continuar desde: <input type=text name=desde value=$enviados size=4>\n";
	echo " y enviar <input type=text name=count value=".$_REQUEST["count"]." size=5> correos más\n";
	echo "<input type=hidden name=contactos value=".$_REQUEST["contactos"].">\n";
	echo "<input type=hidden name=Opcion value=".$_REQUEST["Opcion"].">\n";
	echo "&nbsp;<input type=submit value='continuar'>";
	echo "</form>";
}
?>

</body>
</html>
<script>
alert("<?php echo $enviados?> correos enviados")
</script>
