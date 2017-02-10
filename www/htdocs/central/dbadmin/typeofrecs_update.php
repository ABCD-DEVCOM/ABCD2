<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

include("../common/header.php");
if (isset($arrHttp["encabezado"])){
    include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{	$encabezado="";}
echo "
	<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".$msgstr["typeofrecords"].": ".$arrHttp["base"]."</div>
	<div class=\"actions\">\n";
echo "<a href=menu_modificardb.php?base=". $arrHttp["base"].$encabezado." class=\"defaultButton backButton\">
	<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
		<span><strong>". $msgstr["back"]."</strong></span>
		</a>
		</div>
			<div class=\"spacer\">&#160;</div>
		</div>";
echo "<div class=\"middle form\">
			<div class=\"formContent\">";
$cell=array();
foreach ($arrHttp as $var=>$value) {
	if (substr($var,0,4)=="cell"){		$c=explode("_",$var);
		if ($value=="_") $value="";
		if (isset($cell[$c[0]]))
			$cell[$c[0]].='|'.$value;
		else
			$cell[$c[0]]=$value;
	}else{	}}

$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab";
$fp=fopen($archivo,"w");
if (!isset($arrHttp["nivelr"])) $arrHttp["nivelr"]="";
$res=fwrite($fp,$arrHttp["tipom"]." ".$arrHttp["nivelr"]."\n");
foreach ($cell as $value){
	$l=explode('|',$value);
	$linea=str_replace('|',"",$value);
	if (trim($linea)!="") $res=fwrite($fp,$value."\n");;
}
fclose($fp);
echo "<center><h4>".$arrHttp["base"]."/def/".$_SESSION["lang"]."/typeofrecord.tab"." ".$msgstr["updated"];
if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=s";
else
	$encabezado="";
if (isset($arrHttp["Opcion"]) and $arrHttp["Opcion"]=="tipom"){	echo "<p><a href=typeofrecs_edit.php?base=".$arrHttp["base"]."$encabezado>".$msgstr["typeofrecords_create"]."</a>";}

echo "</div></div></center>";
include("../common/footer.php");
echo "</body></html>";
?>