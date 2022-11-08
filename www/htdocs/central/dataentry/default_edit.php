<?php
/*
20220206 fho4abcd removed unused (and wrong) part. Implies no back button necessary,
*/
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");
include("../lang/admin.php");

require_once ('plantilladeingreso.php');

include("../common/header.php");
// This script runs always inside a frame: no institutional info

//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
if (isset($arrHttp["wks"])){
	$wk=explode('|',$arrHttp["wks"])  ;
	$arrHttp["wks"]=$wk[0];
	if (isset($wk[1]))
		$arrHttp["wk_tipom_1"]=$wk[1];
	else
		$arrHttp["wk_tipom_1"]="";
	if (isset($wk[2]))
		$arrHttp["wk_tipom_2"]=$wk[2];
	else
		$arrHttp["wk_tipom_2"]="";

}else{
	$arrHttp["wks"]="";
}
$base=$arrHttp["base"];
$arrHttp["cipar"]="$base.par";
if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt"))
	$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
else
	$archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
$fp=file($archivo);
global $vars;
$ix=-1;
foreach ($fp as $value){

	$ix=$ix+1;
//	$fdt[$t[1]]=$value;
	$vars[$ix]=$value;
}
$default_values="S";
if (isset($_SESSION["valdef"])){
	$default=$_SESSION["valdef"];
	$fp=explode('$$$',$default);
	foreach ($fp as $linea){
		if (trim($linea)!=""){
			$linea=rtrim($linea);
			$tag=trim(substr($linea,0,4))*1;
			if (trim(substr($linea,4))!=""){
				if (!isset($valortag[$tag]))
					$valortag[$tag]=substr($linea,4);
				else
					$valortag[$tag].="\n".substr($linea,4);
			}
		}
	}
}
PlantillaDeIngreso();
include("dibujarhojaentrada.php");
include("ingresoadministrador.php");

//echo "</div></div>\n";
//include("../common/footer.php");
?>