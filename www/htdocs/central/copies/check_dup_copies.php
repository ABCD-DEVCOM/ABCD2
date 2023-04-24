<?php
/**
 * 20230424 rogercgui This script was remade to use WXIS and not MX. For some reason not yet understood, MX does not run on SSL-enabled servers.
 * 
 * 
 * 
 * 
 */

session_start();
ini_set('error_reporting', E_ALL);
include("../config.php");
$response="";

$in=$_REQUEST["invnum"];

$bd_ref="copies";

$Expresion="IN_".$in;
$IsisScript=$xWxis."buscar.xis";
$arrHttp["base"]=$bd_ref;
$arrHttp["cipar"]=$bd_ref.".par";
$arrHttp["Opcion"]="buscar";
$Formato="ALL";
$query = "&cipar=$db_path"."par/".$arrHttp["cipar"]. "&Expresion=$Expresion&Opcion=".$arrHttp["Opcion"]."&base=" .$arrHttp["base"]."&Formato=$Formato&prologo=NNN";

include("../common/wxis_llamar.php");

$i = 0;
foreach ($contenido as $value){
	//echo $value."<br>";
	$splitbymfn=explode("mfn=",$value);
	$outmx=$value;
	$conta=(count($splitbymfn)-1)."<br>";
	if ($conta>="1"){ 
			echo "1";
	} else {
			echo "~";
	}
}

?>