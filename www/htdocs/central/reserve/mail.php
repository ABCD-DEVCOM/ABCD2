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



switch ($arrHttp["code"]){
	case "assigned":		$Disp_format="reserve_assigned.pft";
		$Pft=$db_path."reserve/pfts/".$_SESSION["lang"]."/".$Disp_format;
		if (!file_exists($Pft)){
			$Pft=$db_path."reserve/pfts/".$lang_db."/".$Disp_format;
		}        break;
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
$query = "&base=reserve&cipar=$db_path"."par/reserve.par&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"]."&Pft=".$Pft;
$IsisScript=$xWxis."leer_mfnrange.xis";
$contenido=LlamarWxis($IsisScript,$query);

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

//Se arma el correo

$body = <<<EOD
<br><hr><br>
$body
EOD;

$headers = "From: $mail_from\r\n"; // This takes the email and displays it as who this email is from.
$headers .= "Content-type: text/html\r\n"; // This tells the server to turn the coding into the text.
$success = mail($mailto, $emailSubject, $body, $headers); // This tells the server what to send.
echo "<p>";
echo $msgstr["mail_from"].": ".$mail_from."<br>";
echo $msgstr["mail_to"].": ".$mailto."<br>";
echo $msgstr["mail_subject"].": ".$emailSubject."<br>";
echo $body;
echo "<p><font color=red face=tahoma><b>";
if ($success){	echo $msgstr["mail_sent"];}else{	echo $msgstr["mail_fail"];}
echo "</b>";
?>

