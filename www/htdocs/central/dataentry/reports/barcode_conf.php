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
include ("../lang/admin.php");
include ("../lang/reports.php");
include ("configure.php");
?>
<body>
<script language=Javascript src=../dataentry/js/lr_trim.js></script>
<script>
function AbrirVentana(Url){	msgwin=window.open(Url,"","width=400, height=400, resizable, scrollbars, menu=no, toolbar=no")
	msgwin.focus();}

function Enviar(){	if (Trim(document.forma1.tag_pref_classification_number.value)==""){
		alert("<?php echo $msgstr["err_prefix"]?>")
		return
	}
	if (Trim(document.forma1.tag_format_classification_number.value)==""){
		alert("<?php echo $msgstr["err_pft_class"]?>")
		return
	}
	document.forma1.submit()}
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
// leer el bases.dat para ver si la base activa está vinculada con copies
$copies="";
$fp=file($db_path."bases.dat");
foreach ($fp as $value){	if (trim($value)!=""){		$v=explode("|",$value);
		if ($v[0]==$arrHttp["base"]){			if (isset($v[2])) $copies=$v[2];
			break;		}	}}
$bar_c=array();
if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/barcode.conf")){
	$fp=file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/barcode.conf");
	if ($fp){		foreach ($fp as $conf){			$a=explode("=",$conf);
			$bar_c[$a[0]]=$a[1];		}	}
}
echo "<form name=forma1 action=barcode_conf_ex.php method=post onsubmit='javascript:return false'>";
echo "<dd><dd><table bgcolor=#cccccc cellpadding=10>";
echo "<tr><td bgcolor=white width=300>".$msgstr["copies_link"]."</td><td bgcolor=white>$copies</td>";
echo "<input type=hidden name=tag_copies value=$copies>";
echo "<input type=hidden name=base value=".$arrHttp["base"].">";
echo "<tr><td bgcolor=white>".$msgstr["classification_number_pref"]."</td>";
echo "<td bgcolor=white><input type=text name=tag_pref_classification_number value='";
if (isset($bar_c["pref_classification_number"])) echo $bar_c["pref_classification_number"];
echo "' size=5></td>";
echo "<tr><td bgcolor=white>".$msgstr["classification_number_format"]."</td>";
echo "<td bgcolor=white><input type=text name=tag_format_classification_number value='";
if (isset($bar_c["format_classification_number"])) echo $bar_c["format_classification_number"];
echo "' size=20></td>";
echo "<tr><td bgcolor=white>".$msgstr["inventory_barcode_format"]."</td>";
echo "<td bgcolor=white><input type=hidden name=tag_format_inventory_barcode value=barcode.pft>";
echo "barcode.pft</td>";
echo "</table>";
echo "<a href=javascript:AbrirVentana(\"../dbadmin/fdt_leer.php?base=".$arrHttp["base"]."\")>FDT</a>";
echo "&nbsp; &nbsp; <a href=javascript:AbrirVentana(\"../dbadmin/fst_leer.php?base=".$arrHttp["base"]."\")>FST</a>";
echo "<p><input type=submit value=".$msgstr["update"]." onClick=Javascript:Enviar()>"
?>
</form>
</div>
</div>
<?php
Include("../Common/Footer.Php");
?>
</Body>
</Html>