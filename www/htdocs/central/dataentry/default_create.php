<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");
echo "<html><title>Test FDT</title>
<script language=javascript src=js/popcalendar.js></script>\n";

//foreach($arrHttp["ValorCapturado"] as $var=>$value) echo "$var=$value<br>";

$base=$arrHttp["base"];
$arrHttp["cipar"]="$base.par";
$fp=file($db_path.$arrHttp["base"]."/".$arrHttp["base"].".fdt");
global $vars;
$ix=-1;
foreach ($fp as $value){

	$ix=$ix+1;
//	$fdt[$t[1]]=$value;
	$vars[$ix]=$value;
}
$default_values="S";
if (isset($_SESSION["valdef"])){	$default=$_SESSION["valdef"];
	$fp=explode("\n",$default);
	foreach ($fp as $linea){
		$linea=rtrim($linea);
		$tag=trim(substr($linea,0,3))*1;
		$valortag[$tag]=substr($linea,3);
	}
}
include("dibujarhojaentrada.php");
include("ingresoadministrador.php");




?>