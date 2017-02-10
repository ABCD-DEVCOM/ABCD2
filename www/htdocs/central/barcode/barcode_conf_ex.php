<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "<pre>$var=$value</pre>"; die;
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
<?php echo "<a href=\"barcode.php?base=".$arrHttp["base"]."&tipo=".$arrHttp["tipo"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
	</div>

<?php
$ayuda="barcode.html";
?>

</div>

<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/<?php echo $ayuda?> target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/".$ayuda." target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: barcode/barcode_conf_ex.php";
?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
	</div>
<?php

$fp=fopen($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["tipo"].".conf","w");
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