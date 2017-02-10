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
include ("../lang/dbadmin.php");
include ("../lang/reports.php");
//include ("configure.php");
?>
<body>
<script language=Javascript src=../dataentry/js/lr_trim.js></script>
<script>
function AbrirVentana(Url){	msgwin=window.open(Url,"","width=400, height=400, resizable, scrollbars, menu=no, toolbar=no")
	msgwin.focus();}

function EditarFormato(Pft){	Pft=Trim(Pft.value)
	if (Pft=="" || Pft.substr(0,1)!='@'){		alert("debe especificar el nombre del formato a utilizar, comenzando por @ y con la extensión .pft")
		return	}
	Pft=Pft.substr(1)
	document.editpft.archivo.value=Pft
	msgwin=window.open("","editpft","width=800, height=400, scrollbars, resizable")
	document.editpft.submit()
	msgwin.focus()
}

function Enviar(){
	if (Trim(document.forma1.tag_cols.value)==""){
		alert("<?php echo $msgstr["missing"]." ".$msgstr["labels_row"]?>")
		return
	}
	if (Trim(document.forma1.tag_width.value)==""){
		alert("<?php echo $msgstr["missing"]." ".$msgstr["label_width"]?>")
		return
	}
	if (Trim(document.forma1.tag_height.value)==""){
		alert("<?php echo $msgstr["missing"]." ".$msgstr["label_height"]?>")
		return
	}
	if (Trim(document.forma1.tag_inventory_number_pref_list.value)==""){
		alert("<?php echo $msgstr["missing"]." ".$msgstr["inventory_number_pref_list"]?>")
		return
	}
	if (Trim(document.forma1.tag_inventory_number_display.value)==""){
		alert("<?php echo $msgstr["missing"]." ".$msgstr["inventory_number_display"]?>")
		return
	}
	if (Trim(document.forma1.tag_label_format.value)==""){
		alert("<?php echo $msgstr["missing"]." ".$msgstr["pft"]?>")
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
<?php echo "<a href=\"barcode.php?base=".$arrHttp["base"]."&tipo=".$arrHttp["tipo"]."\"  class=\"defaultButton backButton\">";
?>
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["regresar"]?></strong></span></a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/barcode.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"])or isset($_SESSION["permiso"]["CENTRAL_ALL"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/barcode.html"." target=_blank>".$msgstr["edhlp"]."</a>";
    echo "&nbsp; &nbsp;<a href=\"http://abcdwiki.net/wiki/es/index.php?title=Etiquetas\" target=_blank>abcdwiki.net</a>";
    echo "<font color=white>&nbsp; &nbsp; Script: barcode/barcode_conf.php";
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
if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["tipo"].".conf")){
	$fp=file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["tipo"].".conf");
	if ($fp){		foreach ($fp as $conf){			$conf=trim($conf);
			if ($conf!=""){				$a=explode('=',$conf,2);
				$bar_c[$a[0]]=$a[1];
			}		}	}
}
echo "<form name=forma1 action=barcode_conf_ex.php method=post onsubmit='javascript:return false'>";
echo "<dd><dd><table bgcolor=#cccccc cellpadding=10>";
if (trim($copies)!="")
	echo "<tr><td bgcolor=white width=100>".$msgstr["copies_link"]."</td><td bgcolor=white>$copies</td>";

echo "<input type=hidden name=tag_copies value=$copies>";
echo "<input type=hidden name=base value=".$arrHttp["base"].">";

echo "<tr><td bgcolor=white width=100>".$msgstr["classification_number_pref"]."</td>";
echo "<td bgcolor=white><input type=text name=tag_classification_number_pref value='";
if (isset($bar_c["classification_number_pref"])) echo $bar_c["classification_number_pref"];
echo "' size=5></td>";
echo "<td bgcolor=white width=100>".$msgstr["classification_number_format"]."</td>";
echo "<td bgcolor=white><textarea name=tag_classification_number_format cols=100 rows=2>";
if (isset($bar_c["classification_number_format"])) echo $bar_c["classification_number_format"];
echo "</textarea></td></tr>\n";

echo "<tr><td bgcolor=white width=100>".$msgstr["inventory_number_pref"]."</td>";
echo "<td bgcolor=white><input type=text name=tag_inventory_number_pref value='";
if (isset($bar_c["inventory_number_pref"])) echo $bar_c["inventory_number_pref"];
echo "' size=5></td>";
echo "<td bgcolor=white>".$msgstr["inventory_number_format"]."</td>";
echo "<td bgcolor=white><textarea name=tag_inventory_number_format cols=100 rows=2>";
if (isset($bar_c["inventory_number_format"])) echo $bar_c["inventory_number_format"];
echo "</textarea></td></tr>\n";

echo "<tr><td bgcolor=white width=100>".$msgstr["inventory_number_pref_list"]." <strong><font color=red>*</font></strong></td>";
echo "<td bgcolor=white><input type=text name=tag_inventory_number_pref_list value='";
if (isset($bar_c["inventory_number_pref_list"])) echo $bar_c["inventory_number_pref_list"];
echo "' size=5></td>";
echo "<td bgcolor=white>".$msgstr["inventory_number_display"]." <strong><font color=red>*</font></strong></td>";
echo "<td bgcolor=white><textarea name=tag_inventory_number_display cols=100 rows=2>";
if (isset($bar_c["inventory_number_display"])) echo $bar_c["inventory_number_display"];
echo "</textarea></td></tr>\n";

echo "<tr><td bgcolor=white>".$msgstr["pft"]." <strong><font color=red>*</font></strong></td>";
echo "<td bgcolor=white colspan=3><textarea name=tag_label_format cols=100 rows=3>";
if (isset($bar_c["label_format"])) echo $bar_c["label_format"];
echo "</textarea>";
echo "<a href=javascript:EditarFormato(document.forma1.tag_label_format)><img src=../dataentry/img/barEdit.png alt=\"edit display format\" title=\"edit display format\" border=0></a>";
if ($arrHttp["tipo"]=="barcode") echo "<br>".$msgstr["inventory_barcode_format"];
echo "</td></tr>\n";

echo "<tr><td bgcolor=white>".$msgstr["pft"]."<br>".$msgstr["sendto"]." <strong>TXT</strong>";"</td>";
echo "<td bgcolor=white colspan=3><textarea name=tag_label_format_txt cols=100 rows=2>";
if (isset($bar_c["label_format_txt"])) echo $bar_c["label_format_txt"];
echo "</textarea>";
echo "<a href=javascript:EditarFormato(document.forma1.tag_label_format_txt)><img src=../dataentry/img/barEdit.png alt=\"edit display format\" title=\"edit display format\" border=0></a>";
echo "</td></tr>\n";

echo "<tr><td bgcolor=white nowrap>".$msgstr["label_height"]." <strong><font color=red>*</font></strong></td>";
echo "<td bgcolor=white colspan=3><input type=text name=tag_height size=10 value=";
if (isset($bar_c["height"])) echo $bar_c["height"];
echo ">cms</td></tr>\n";

echo "<tr><td bgcolor=white nowrap>".$msgstr["label_width"]." <strong><font color=red>*</font></strong></td>";
echo "<td bgcolor=white colspan=3><input type=text name=tag_width size=10 value=";
if (isset($bar_c["width"])) echo $bar_c["width"];
echo "> cms</td></tr>\n";
echo "<tr><td bgcolor=white nowrap>".$msgstr["labels_row"]." <strong><font color=red>*</font></strong></td>";
echo "<td bgcolor=white colspan=3><input type=text name=tag_cols size=10 value=";
if (isset($bar_c["cols"])) echo $bar_c["cols"];
echo "></td></tr>\n";

echo "</table>";
echo  "<strong><font color=red>(*) ".$msgstr["labels_mandatory"]."</font></strong><br>";
echo "<a href=javascript:AbrirVentana(\"../dbadmin/fdt_leer.php?base=".$arrHttp["base"]."\")>FDT</a>\n";
echo "&nbsp; &nbsp; <a href=javascript:AbrirVentana(\"../dbadmin/fst_leer.php?base=".$arrHttp["base"]."\")>FST</a>\n";
echo "<p><input type=submit value=".$msgstr["update"]." onClick=Javascript:Enviar()>\n";
echo "<input type=hidden name=tipo value=".$arrHttp["tipo"].">\n";
?>
</form>
</div>
</div>
<?php
Include("../Common/Footer.Php");
?>
</Body>
</Html>
<form name=editpft method=post action=../dbadmin/leertxt.php target=editpft>
<input type=hidden name=desde value=dataentry>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=archivo>
<input type=hidden name=descripcion>
</form>