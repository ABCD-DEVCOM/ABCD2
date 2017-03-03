<?php
session_start();
if (!isset($_SESSION["permiso"])) die;
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
// ARCHIVOD DE MENSAJES
include("../lang/dbadmin.php");
include("../lang/statistics.php");

// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILOinclude("../common/header.php");

// VERIFICA SI VIENE DEL TOOLBAR O NO PARA COLOCAR EL ENCABEZAMIENTO
if (isset($arrHttp["encabezado"])){	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
echo "<form name=stats method=post>";
echo "<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".$msgstr["stats_conf"].": ".$arrHttp["base"]."</div>
	<div class=\"actions\">";
if (isset($arrHttp["from"]) and $arrHttp["from"]=="statistics"){	$script="tables_generate.php";}else{	$script="../dbadmin/menu_modificardb.php";}
echo "<a href=\"$script?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" />
	<span><strong>".$msgstr["back"]."</strong></span></a>
	";
?>
</div><div class="spacer">&#160;</div></div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/stats_index.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/stats_index.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: config_vars_update.php";
?>
</font>
	</div>
<div class="middle form">
	<div class="formContent">
<?php
$file=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/stat.cfg";
$fp=fopen($file,"w");
$arrHttp["ValorCapturado"]=stripslashes($arrHttp["ValorCapturado"]);
$vc=explode("\n",$arrHttp["ValorCapturado"]);
foreach ($vc as $value){	$r=fwrite($fp,$value."\n");}
$r=fclose($fp);
echo "<h4>". $arrHttp["base"]."/".$_SESSION["lang"]."/def/stat.cfg"." ".$msgstr["updated"]."</h4>" ;

?>
	</div>
</div>
</form>
<?php
include("../common/footer.php");
?>
</body>
</html>
