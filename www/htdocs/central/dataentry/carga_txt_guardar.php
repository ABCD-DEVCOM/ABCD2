<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang= $_SESSION["lang"];


include("../lang/admin.php");
include("../lang/soporte.php");



//foreach ($arrHttp as $var=>$value) 	echo "$var = $value<br>";
echo "<html>
<body>";
$file=$db_path.$arrHttp["base"]."/cnv/".$arrHttp["fn"].".cnv";

$fp = fopen($file,"w");
if (!$fp){
	echo "<center><br><br><h1><b><font color=red>admin/php/$file</font></b> ".$msgstr["revisarpermisos"]."</h1>";
	die;
}
$value=explode('!!',$arrHttp["tablacnv"]);
if (isset($arrHttp["delimited"]) and $arrHttp["delimited"]=="on")
	fwrite($fp,"[TABS]\n");
else
	fwrite($fp,$arrHttp["separador"]."\n");
foreach ($value as $tab){
	$tab=stripslashes($tab);
	$tab=str_replace("'","`",$tab);
	fwrite($fp,$tab."\n");
}
fclose($fp);
echo "<center><br><br><h3>$file ".$msgstr["okactualizado"]."</h3>";
echo "
<p><a href=carga_txt_cnv.php?base=".$arrHttp["base"]."&Opcion=cnv&tipo=txt&accion=".$arrHttp["accion"]." class=boton>&nbsp; &nbsp; ".$msgstr["continuar"]."&nbsp; &nbsp; </a>
</form>
</body>
</Html>"
?>