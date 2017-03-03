<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");



include ("../common/header.php");
include ("../lang/soporte.php");
include ("../lang/dbadmin.php");
include ("../lang/reports.php");
//include ("configure.php");
?>
<body>

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
	</div>
	<div class="spacer">&#160;</div>
	</div>

<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/<?php echo $ayuda?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/".$ayuda." target=_blank>".$msgstr["edhlp"]."</a>";
	echo "&nbsp; &nbsp;<a href=\"http://abcdwiki.net/wiki/es/index.php?title=Etiquetas\" target=_blank>abcdwiki.net</a>";
echo "<font color=white>&nbsp; &nbsp; Script: barcode/menu.php";
?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
	<table align=center >
	<tr><td>
<?php
$db=$arrHttp["base"];
if (isset($_SESSION["permiso"]["CENTRAL_ALL"])or isset($_SESSION["permiso"]["CENTRAL_BARCODE"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_BARCODE"])){?>
	<strong><font style="font-size:14px;line-height:14px"><?php echo $msgstr["barcode_label"]?></font></strong>
	<ul style="font-size:12px;line-height:18px">
	<li><a href=barcode.php?base=<?php echo $arrHttp["base"]."&tipo=barcode>".$msgstr["barcode"]."</a></li>\n";?>
	<li><a href=barcode.php?base=<?php echo $arrHttp["base"]."&tipo=lomos>".$msgstr["barcode_lomos"]."</a></li>\n";?>
	<li><a href=barcode.php?base=<?php echo $arrHttp["base"]."&tipo=etiquetas>".$msgstr["barcode_etiquetas"]."</a></li>\n";?>
	</ul>
<?php }
if (isset($_SESSION["permiso"]["CENTRAL_ALL"])or isset($_SESSION["permiso"]["CENTRAL_INVENTORY"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_INVENTORY"])){
?>
	<strong><font style="font-size:14px;line-height:14px"><?php echo $msgstr["inventory"]?></font></strong>
	<ul style="font-size:12px;line-height:18px">
	<li><a href=inventory_dbinit.php?base=<?php echo $arrHttp["base"].">".$msgstr["inventory_dbinit"]."</a></li>\n";?>
	<li><a href=inventory_dbload.php?base=<?php echo $arrHttp["base"]."&Opcion=inicio>".$msgstr["inventory_dbload"]."</a></li>\n";?>
	<li><a href=inventory_itemsload.php?base=<?php echo $arrHttp["base"].">".$msgstr["inventory_itemsload"]."</a></li>\n";?>
	<li><a href=inventory_match.php?base=<?php echo $arrHttp["base"].">".$msgstr["inventory_match"]."</a></li>\n";?>
	<li><a href=inventory_report.php?base=<?php echo $arrHttp["base"].">".$msgstr["inventory_report"]."</a></li>\n";?>
	</ul>
<?php } ?>

	</td>
	</table>
	</div>
</div>
<?php
Include("../common/footer.php");
?>
</Body>
</Html>
