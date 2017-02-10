<?php

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
include("../lang/dbadmin.php");
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
//die;
if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";
$lang=$_SESSION["lang"];

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
	<div class=\"breadcrumb\">".$msgstr["z3950"].": ".$msgstr["z3950_cnv"]." (".$arrHttp["base"].")</div>
	<div class=\"actions\">\n";
echo "<a href=z3950_conf.php?base=^a". $arrHttp["base"].$encabezado." class=\"defaultButton backButton\">
	<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
		<span><strong>". $msgstr["back"]."</strong></span>
		</a>
		</div>
			<div class=\"spacer\">&#160;</div>
		</div>";
echo "<div class=\"middle form\">
			<div class=\"formContent\">";
echo "<font size=1 face=arial> &nbsp; &nbsp; Script: z3950_conversion_delete.php</font>";
$file=$db_path.$arrHttp["base"]."/def/".$arrHttp["Table"];
if (file_exists($file)){
	$res=unlink($file);
	if (!$res){
		echo $msgstr["nodeleted"];
	}
}
$fp=file($db_path.$arrHttp["base"]."/def/z3950.cnv");
foreach ($fp as $value) $sal[]=$value;
$out=fopen($db_path.$arrHttp["base"]."/def/z3950.cnv","w");
foreach ($sal as $value){
	$t=explode('|',$value);
	if (trim($t[0])!=trim($arrHttp["Table"]))
		$res=fwrite($out,$value);
}
fclose($out);
echo "<center><h4>z3950.cnv: ".$msgstr["updated"];
echo "</h4></center></div></div>";
include("../common/footer.php");
echo "</body>
</html>";
?>