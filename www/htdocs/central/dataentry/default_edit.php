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

require_once ('plantilladeingreso.php');

include("../common/header.php");

if (isset($arrHttp["encabezado"])){
	echo "<body>";
	include("../common/institutional_info.php");
	if ($arrHttp["base"]=="users") $retorno="loans";
	if ($arrHttp["base"]=="acces") $retorno="usersadm";
	echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">
				";
			if ($arrHttp["Mfn"]=="New") echo "<h3>". $msgstr["newoper"]."</h3>\n";
			echo "</div>
			<div class=\"actions\">
				<a href=\"../$retorno/browse.php?encabezado=s\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>".$msgstr["back"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
	</div>
 	<div class=\"middle form\">
		<div class=\"formContent\">
		";
}else{
	echo "
		<div class=\"middle form\">
			<div class=\"formContent\">

		";
	}

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

}else{	$arrHttp["wks"]="";}
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
	foreach ($fp as $linea){		if (trim($linea)!=""){
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

echo "</div></div>\n";
		include("../common/footer.php");
		die;


?>