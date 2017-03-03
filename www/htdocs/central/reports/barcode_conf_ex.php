<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");
include ("../common/header.php");
include ("../lang/soporte.php");
include ("../lang/admin.php");
include ("../lang/reports.php");
include ("configure.php");
?>
<body>
<script language=Javascript src=../dataentry/js/lr_trim.js></script>
<script>
function AbrirVentana(Url){	msgwin=window.open(Url,"","width=400, height=400, resizable, scrollbars, menu=no, toolbar=no")
	msgwin.focus();}
</script>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["configure"]." " .$msgstr["barcode"].": ".$arrHttp["base"]?>
	</div>

	<div class="actions">
<?php echo "<a href=\"../dbadmin/pft.php?base=".$arrHttp["base"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
	</div>

<?php
$ayuda="barcode_conf.html";
if (isset($arrHttp["encabezado"])){
	if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_MODIFYDB"])){
		$retorno="../dbadmin/pft.php";
		echo "<a href=\"$retorno"."?base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton cancelButton\">
		<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>".$msgstr["cancel"]."</strong></span></a>
		";
	}else{
		echo "<a href=\"../common/inicio.php?reinicio=s&base=".$arrHttp["base"]."$encabezado\" class=\"defaultButton cancelButton\">
		<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>".$msgstr["cancel"]."</strong></span></a>
		";
	}
}
?>

</div>

<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/<?php echo $ayuda?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/".$ayuda." target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: barcode_conf.php";
?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
	</div>
<?php
$fp=fopen($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/barcode.conf","w");
foreach ($arrHttp as $key=>$conf){	if (substr($key,0,4)=="tag_"){		$key=substr($key,4);		echo "$key=$conf<br>";		fwrite($fp,"$key=$conf"."\n");	}
}
fclose($fp);
?>
</div>
</div>
<?php
Include("../common/footer.php");
?>
</Body>
</Html>