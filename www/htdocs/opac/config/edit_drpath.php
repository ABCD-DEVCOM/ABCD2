<?php
$url_back="procesos_base.php?base=".$_REQUEST["base"].'&';
$arrHttp=$_REQUEST;
$arrHttp["Opcion"]="dr_path";
include ("tope_config.php");
?>
<div id="page">
	<p>
    <h3><?php echo $msgstr["edit"]?> &nbsp;dr_path.def <a href=http://wiki.abcdonline.info/Dr_path.def target=blank><img src=../images_config/helper_bg.png></a></h3><p>
<?php
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (!isset($_SESSION["db_path"])){
	echo "Session expired";die;
}
$db_path=$_SESSION["db_path"];
$desde="OPAC";
include($CentralPath."/dbadmin/editar_abcd_def_inc.php");
if (!isset($arrHttp["Accion"]) or $arrHttp["Accion"]!=="actualizar"){
	echo "<a href=\"javascript:Enviar()\" class=\"defaultButton saveButton\">";
	echo "
			<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
			<span><strong>". $msgstr["save"]."</strong></span>
			</a>";
}
include("../php/footer.php");
?>