<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";  die;
if (isset($arrHttp["ValorCapturado"]))  {	$pft=explode("\n",$arrHttp["ValorCapturado"]);}else{	$pft=array();}

if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";
$lang=$_SESSION["lang"];
$fp=fopen($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["fn"],"w");
if (!$fp){
	echo $arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["fn"].": ";	echo $msgstr["nopudoseractualizado"];
	die;}
foreach ($pft as $value){	$tag=substr($value,0,4);
	$value=trim(substr($value,4));
	fwrite($fp,ltrim($tag, "0").":".urldecode($value)."\n###\n");
}
fclose($fp);
include("../common/header.php");
echo "<body>";
if (isset($arrHttp["encabezado"])){
    	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
echo "
	<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".$msgstr["recval"].": ".$arrHttp["base"]."</div>
	<div class=\"actions\">\n";
echo "<a href=typeofrecs.php?base=". $arrHttp["base"].$encabezado." class=\"defaultButton backButton\">
	<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
		<span><strong>". $msgstr["back"]."</strong></span>
		</a>
		</div>
			<div class=\"spacer\">&#160;</div>
		</div>";
echo "<div class=\"middle form\">
			<div class=\"formContent\">";
echo "<font size=1 face=arial> &nbsp; &nbsp; Script: dbadmin/recval_save.php</font>";
echo "<center><h4>".$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["fn"].": ".$msgstr["updated"];
echo "</h4></center></div></div>";
include("../common/footer.php");
echo "</body>
</html>";
?>