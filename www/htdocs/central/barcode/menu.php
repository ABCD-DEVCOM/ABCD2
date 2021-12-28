<?php
/*
20211-04 fho4abcd Replace vmx_fullinv.php by fullinv.php.
20211223 fho4abcd Backbutton &helper by included file + improve html
*/
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");

include ("../common/header.php");
include ("../lang/admin.php");
include ("../lang/soporte.php");
include ("../lang/dbadmin.php");
include ("../lang/reports.php");
//include ("configure.php");
?>
<body>
<script>
function EnviarFormaInventario(action,Opcion,base_activa,retorno){
	if (action=='inventory_dbinit.php' || action=='inventory_dbload.php' || action=='../utilities/fullinv.php' || action=='inventory_transload.php' || action=='inventory_itemsload.php'){
		document.FormaInventario.Opcion.value=Opcion
		document.FormaInventario.action=action
		document.FormaInventario.base_activa.value=base_activa
		document.FormaInventario.retorno.value=retorno
		if (action=='../utilities/fullinv.php'){
			document.FormaInventario.base.value=base_activa
			document.FormaInventario.base_activa.value="<?php echo $arrHttp["base"] ?>"
		}
		document.FormaInventario.submit()
	}
}
</script>
<?php
$ayuda="barcode.html";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["barcode_label"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
    <?php include "../common/inc_back.php";?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php"?>
<div class="middle form">
	<div class="formContent">
    <form name=FormaInventario method=post action=''>
<input type=hidden name=base value=<?php echo $arrHttp["base"] ?>>
<input type=hidden name=Opcion>
<input type=hidden name=base_activa>
<input type=hidden name=retorno>
</form>

	<table align=center >
	<tr><td>
<?php
$db=$arrHttp["base"];
if (isset($_SESSION["permiso"]["CENTRAL_ALL"])or isset($_SESSION["permiso"]["CENTRAL_BARCODE"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_BARCODE"])){?>
	<h3><?php echo $msgstr["barcode_label"]?></h3>
	<ul style="font-size:12px;line-height:18px">
	<li><a href='barcode.php?base=<?php echo $arrHttp["base"]."&tipo=barcode"?>'><?php echo $msgstr["barcode"];?></a></li>
	<li><a href='barcode.php?base=<?php echo $arrHttp["base"]."&tipo=lomos"?>'> <?php echo $msgstr["barcode_lomos"]?></a></li>
	<li><a href='barcode.php?base=<?php echo $arrHttp["base"]."&tipo=etiquetas"?>'> <?php echo $msgstr["barcode_etiquetas"]?></a></li>
	</ul>
<?php }
if (isset($_SESSION["permiso"]["CENTRAL_ALL"])or isset($_SESSION["permiso"]["CENTRAL_INVENTORY"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_INVENTORY"])){
?>
	<h3><?php echo $msgstr["inventory"]?></h3>
	<ul style="font-size:12px;line-height:18px">
	<li><a href="javascript:EnviarFormaInventario('inventory_dbinit.php','','','')"><?php echo $msgstr["inventory_dbinit"]?></a></li>
	<li><a href="javascript:EnviarFormaInventario('inventory_dbload.php','inicio','','')"><?php echo $msgstr["inventory_dbload"]?></a></li>
	<li><a href="javascript:EnviarFormaInventario('../utilities/fullinv.php','','abcd_inventory','../barcode/menu.php')"><?php echo $msgstr["inventory_fullinv"]?></a></li>
	<li><a href="javascript:EnviarFormaInventario('inventory_transload.php','inicio','','')"><?php echo $msgstr["inventory_transload"]?></a></li>
	<li><a href="javascript:EnviarFormaInventario('inventory_itemsload.php','subir','','')"><?php echo $msgstr["inventory_itemsload"]?></a></li>
	<!--li><a href=inventory_report.php?base=<?php echo $arrHttp["base"].">".$msgstr["inventory_report"]."</a></li\n";?>-->
	</ul>
<?php } ?>

	</td>
	</table>
	</div>
</div>
<?php
include("../common/footer.php");
?>

