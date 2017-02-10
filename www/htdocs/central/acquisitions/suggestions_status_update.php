<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../config.php");
include("../common/get_post.php");
$ValorCapturado="";
foreach ($_GET as $var => $value) {
	VariablesDeAmbiente($var,$value);
}
if (count($arrHttp)==0){
	foreach ($_POST as $var => $value) {
		VariablesDeAmbiente($var,$value);
	}
}
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

$arrHttp["Opcion"]="actualizar";
$cipar=$arrHttp["cipar"];
$base=$arrHttp["base"];
$xtl="";
$xnr="";
$arrHttp["wks"]="status.fmt";
include("../dataentry/plantilladeingreso.php");
include("../dataentry/actualizarregistro.php");
foreach ($arrHttp as $var => $value) {
	if (substr($var,0,3)=="tag" ){
		$tag=explode("_",$var);
		if (isset($variables[$tag[0]])){
			$variables[$tag[0]].="\n".$value;
			$valortag[substr($tag[0],3)].="\n".$value;
		}else{
			$variables[$tag[0]]=$value;
			$valortag[substr($tag[0],3)]=$value;
		}
   	}

}
ActualizarRegistro();
$see_all="";
if (isset($arrHttp["see_all"])) $see_all="&see_all=Y";
header("Location: suggestions_status.php?base=".$arrHttp["base"]."&sort=".$arrHttp["sort"].$see_all);
die;
//------------------------------------------------------
function VariablesDeAmbiente($var,$value){
global $arrHttp;

		if (substr($var,0,3)=="tag") {
			$ixpos=strpos($var,"_");
			if ($ixpos!=0) {
				$occ=explode("_",$var);
				if (trim($value)!=""){
					$value="^".trim($occ[2]).$value;
				}
			}else{
				if (is_array($value)) {
			   		$value = implode("\n", $value);
					$var=$occ[0]."_".$occ[1];
					if (is_array($value)) {
						$value = implode("\n", $value);
					}
					if (isset($arrHttp[$var])){
						$arrHttp[$var].=$value;
					}else{
						$arrHttp[$var]=$value;
					}
				}
				if (isset($arrHttp[$var])){
					$arrHttp[$var].="\n".$value;
				}else{
					$arrHttp[$var]=$value;
				}
			}
		}else{
			if (trim($value)!="") $arrHttp[$var]=$value;
		}
}

?>