<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      mail.php
 * @desc:      Envía correos del sistema de reservas
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

$debug="";
if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=>$value<br>";  //die;
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");

$msgstr["from"]="de";
$msgstr["to"]="a";
$msgstr["mail_error"]="Error al enviar el correo";
$msgstr["mail_sent"]="Su solicitud ha sido enviada";

$fp=file("correo.ini");
foreach ($fp as $key=>$value){
	$value=trim($value);
	if ($value!=""){
		$x=explode('=',$value);
		$ini[$x[0]]=$x[1];
	}
}
include("../circulation/calendario_read.php");
include("../circulation/fecha_de_devolucion.php");
include("../circulation/locales_read.php");

function LlamarWxis($IsisScript,$query){global $db_path,$Wxis,$wxisUrl,$xWxis;
	include("../common/wxis_llamar.php");
	return $contenido;}

function MostrarRegistroCatalografico($dbname,$CN){
global $msgstr,$arrHttp,$db_path,$xWxis,$tagisis,$Wxis,$wxisUrl,$lang_db;
	$pref_cn="";
	$archivo=$db_path.$dbname."/loans/".$_SESSION["lang"]."/loans_conf.tab";
	if (!file_exists($archivo)) $archivo=$db_path.$dbname."/loans/".$lang_db."/loans_conf.tab";
	$fp=file_exists($archivo);
	if ($fp){
		$fp=file($archivo);
		foreach ($fp as $value){
			$t=explode(" ",trim($value));
			if ($t[0]=="NC")
				$pref_cn=$t[1];
		}
	}
	if ($pref_cn=="") $pref_cn="CN_";
	$Expresion=$pref_cn.$CN;
	$formato_obj=$db_path.$dbname."/loans/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path.$dbname."/loans/".$lang_db."/loans_display.pft";
	$arrHttp["count"]="";
	$Formato=$formato_obj;
	$IsisScript=$xWxis."buscar_ingreso.xis";
	$query = "&base=$dbname&cipar=$db_path"."par/".$dbname.".par&Expresion=".$Expresion."&Formato=$formato_obj";
	include("../common/wxis_llamar.php");
	$salida="";
	foreach ($contenido as $value){
		if (substr($value,0,8)!="[TOTAL:]" and substr($value,0,6)!="[MFN:]" and trim($value)!="")
			$salida.=$value;
	}

	return $salida;
}

function SendPhpMail($to,$name,$body,$ini){
global $enviados,$msgstr;
	$subject = $ini["SUBJECT"];
// NOT SUGGESTED TO CHANGE THESE VALUES
	$headers = 'From: ' . $ini[ "FROM" ] . PHP_EOL ;
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$resultado=mail ( $to, $subject,$body, $headers ) ;
	echo "<p><font face=arial> ".$msgstr["from"].": ".$ini["FROM"]."  ".$_REQUEST["nombre"];
	if ($resultado)
		return "Y";
	else
		return "N";

}

function SendMail($mail,$to,$name,$body,$ini){
global $enviados,$msgstr;
	//CUERPO DEL MENSAJE
  //  $mail= new PHPMailer();
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

    if (isset($ini["CC"]))
    	$mail->addCC($ini["CC"]);
	$mail->AddAddress($to,$name);
    $mail->SMTPDebug  = 1;
	$mail->IsHTML(true); // send as HTML
    //echo "<META HTTP-EQUIV=Content-Type; CONTENT=text/html; charset=ISO-8859-1>";
  	echo "<p><font face=arial>".$msgstr["from"].": ".$ini["FROM"].". ".$ini["FROMNAME"];
	echo "<br>".$msgstr["to"].": ".$to."  ".$_REQUEST["nombre"];
	if (isset($ini["CC"]))
		echo "<br>CC: ".$ini["CC"];

	if(!$mail->Send()) {
  		echo "<BR> ".$msgstr["mail_error"].": " . $mail->ErrorInfo;
  		$res="N";
	} else {

		echo "<br><STRONG> ".$msgstr["mail_sent"]."</strong>";
		$res="Y";
	}
	//echo $res;
}



switch ($arrHttp["code"]){
	case "assigned":		$Disp_format="reserve_assigned.pft";
		$Pft=$db_path."reserve/pfts/".$_SESSION["lang"]."/".$Disp_format;
		if (!file_exists($Pft)){
			$Pft=$db_path."reserve/pfts/".$lang_db."/".$Disp_format;
		}
		$fecha_inicio=date("Ymd");

		$config_date_format="DD/MM/YY";
        $fdev=FechaDevolucion(2,"D",$fecha_inicio);
        break;

}


if (!file_exists($Pft)){
	echo $Disp_format. " ** ".$msgstr["falta"];
	die;
}
$Pft="v15`$$$`V20`$$$`V10, `$$$`V30,`$$$`V40,`$$$`V1".'`$$$`f(mfn,1,0)`$$$`,@'.$Pft;
//v15: Base de datos
//v20: Número de control
//v30: Fecha de reserva
//v40: Esperar hasta
//v1:  Situacion
//Se calcula la fecha de vigencia de la reserva (2 días)
$ValorCapturado ="d1d60d40<1 0>3</1>";
$ValorCapturado.="<60 0>$fecha_inicio</60><40 0>$fdev</40>";
$ValorCapturado=urlencode($ValorCapturado);
$query="&base=reserve&cipar=$db_path"."par/reserve.par&ValorCapturado=$ValorCapturado&Opcion=actualizar&Mfn=".$arrHttp["Mfn"]."&login=".$_SESSION["login"];
$IsisScript=$xWxis."actualizar.xis";
$contenido=LlamarWxis($IsisScript,$query);
//foreach($contenido as $value) echo "$value<br>";

$query = "&base=reserve&cipar=$db_path"."par/reserve.par&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"]."&Pft=".$Pft;
$IsisScript=$xWxis."leer_mfnrange.xis";
$contenido=LlamarWxis($IsisScript,$query);
//foreach($contenido as $value) echo "$value<br>";
$key_comp="";
$value=implode("\n",$contenido);
$v=explode('$$$',$value);
//SE LEEN LA BASE DE DATOS Y EL NÚMERO DE CONTROL PARA UBICAR EL TÍTULO Y DETERMINAR LOS EJEMPLARES DISPONIBLES
$bd=$v[0];
$Control_no=$v[1];
$Mfn=$v[6];
$body=$v[7];

$ix=strpos($body,"#TO:");
if ($ix===false){	echo $msgstr["mail_to"].": **".$msgstr["missing_dp"];
	die;}
$b1=substr($body,0,$ix);
$ix1=strpos($body,'#',$ix+1);
$mailto=substr($body,$ix,$ix1-$ix);
$body=$b1.substr($body,$ix1+1);
$ix1=strpos($mailto,":");
$mailto=substr($mailto,$ix1+1);

$ix=strpos($body,"#FROM:");
if ($ix===false){
	echo $msgstr["mail_from"].": ".$msgstr["missing_dp"];
	die;
}
$b1=substr($body,0,$ix);
$ix1=strpos($body,'#',$ix+1);
$mail_from=substr($body,$ix,$ix1-$ix);
$body=$b1.substr($body,$ix1+1);
$ix1=strpos($mail_from,":");
$mail_from=substr($mail_from,$ix1+1);

$ix=strpos($body,"#SUBJECT:");
if ($ix===false){
	echo $msgstr["mail_subject"].": ".$msgstr["missing_dp"];
	die;
}
$b1=substr($body,0,$ix);
$ix1=strpos($body,'#',$ix+1);
$emailSubject=substr($body,$ix,$ix1-$ix);
$body=$b1.substr($body,$ix1+1);
$ix1=strpos($emailSubject,":");
$emailSubject=substr($emailSubject,$ix1+1);
$Referencia=MostrarRegistroCatalografico($v[0],$v[1]);
$body=str_replace("#REFER#",$Referencia,$body);


include("class.phpmailer.php");
$mail= new PHPMailer();
//foreach ($_REQUEST as $key=>$value)  echo "$key=$value<br>";//die;

//if (!isset($ini["FROM"]) or trim($ini["FROM"])=="")
//   $ini["FROM"]=trim($_REQUEST["email"]);

if (isset($ini["TEST"])){
	$to=$ini["TEST"];
}else{
	$to=$mailto;
}

echo "Para: ".$to."<br>";
if (isset($ini["CC"]))
	echo "cc:".$ini["CC"]."<p>";
echo "<br>".$body."<p>";

$_REQUEST["nombre"]="";
$name="Usuario Web";
if (isset($ini["PHPMAILER"]) and $ini["PHPMAILER"]=="phpmailer"){
	$mail_sent=SendMail($mail,$to,$name,$body,$ini);
}else{
	$mail_sent=SendPhpMail($to,$name,$body,$ini);
}
flush();
ob_flush();

?>

