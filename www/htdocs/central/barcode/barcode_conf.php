<?php
/*
20220220 fho4abcd Line-ends, newlook, back button&div-helper
20220310 fho4abcd Translated error+cms->cm+do not show strange comment
20220321 fho4abcd Modified for new configuration, table dimensions
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
include ("../lang/soporte.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/reports.php");
$base=$arrHttp["base"];
?>
<body>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script>
function AbrirVentana(Url){
	msgwin=window.open(Url,"","width=400, height=400, resizable, scrollbars, menu=no, toolbar=no")
	msgwin.focus();
}

function EditarFormato(Pft){
	Pft=Trim(Pft.value)
	if (Pft=="" || Pft.substr(0,1)!='@'){
		alert("<?php echo $msgstr['barcode_set_pft']?>")
		return
	}
	Pft=Pft.substr(1)
	document.editpft.archivo.value=Pft
	msgwin=window.open("","editpft","width=800, height=600, scrollbars, resizable")
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
	document.forma1.submit()
}
</script>
<?php
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["configure"]." ".$msgstr["barcode"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
        <?php
        $backtoscript= "../barcode/bcl_config_labels.php";
        include "../common/inc_back.php";
        $savescript="Javascript:Enviar()";
        include "../common/inc_save.php";
        ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
$ayuda="barcode.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
	<div class="formContent">
<?php
include "inc_barcode_constants.php";

// leer el bases.dat para ver si la base activa está vinculada con copies
$copies="";
$fp=file($db_path."bases.dat");
foreach ($fp as $value){
	if (trim($value)!=""){
		$v=explode("|",$value);
		if ($v[0]==$arrHttp["base"]){
			if (isset($v[2])) $copies=$v[2];
			break;
		}
	}
}
$bar_c=array();
$configfile=$configfileprefix.$arrHttp["tipo"].$configfilesuffix;
$configfilefull=$db_path.$configfile;
if (!file_exists($configfilefull)){
	echo "<div style='color:orange'>".$msgstr["warning"].": ".$msgstr["misfile"]." &rarr; ".$configfile."</div>";
}
else {
    $fp=file($configfilefull);
    foreach ($fp as $conf){
        $conf=trim($conf);
        if ($conf!=""){
            //foreach ($fp as $var=>$value) echo "$var=$value<br>";
            $a=explode('=',$conf,2);
            $bar_c[$a[0]]=$a[1];
        }
    }
}
echo "<h3 style='text-align:center'>".$msgstr['barcode_config'].": ".$arrHttp["tipo"].$configfilesuffix;
echo " (".$arrHttp['desc'].")</h3>";

?>
<form name=forma1 action=barcode_conf_ex.php method=post onsubmit='javascript:return false'>
<input type=hidden name=tag_copies value=<?php echo $copies?>>
<input type=hidden name=base value=<?php echo $base?>>
<input type=hidden name=tipo value=<?php echo $arrHttp["tipo"]?>>
<table bgcolor=#cccccc cellpadding=5>
<?php
if (trim($copies)!="")
	echo "<tr><td bgcolor=white >".$msgstr["copies_link"]."</td><td bgcolor=white>$copies</td>";
?>
<tr><td bgcolor=white ><?php echo $msgstr["classification_number_pref"]?></td>
    <td bgcolor=white><input type=text name=tag_classification_number_pref value='<?php
        if (isset($bar_c["classification_number_pref"])) echo $bar_c["classification_number_pref"];?>' size=5>
    </td>
    <td bgcolor=white ><?php echo $msgstr["classification_number_format"]?></td>
    <td bgcolor=white><textarea name=tag_classification_number_format cols=80 rows=2><?php
        if (isset($bar_c["classification_number_format"])) echo $bar_c["classification_number_format"];?></textarea>
    </td>
</tr>
<tr><td bgcolor=white ><?php echo $msgstr["inventory_number_pref"]?></td>
    <td bgcolor=white><input type=text name=tag_inventory_number_pref value='<?php
        if (isset($bar_c["inventory_number_pref"])) echo $bar_c["inventory_number_pref"];?>' size=5></td>
    <td bgcolor=white><?php echo $msgstr["inventory_number_format"]?></td>
    <td bgcolor=white><textarea name=tag_inventory_number_format cols=80 rows=2><?php
        if (isset($bar_c["inventory_number_format"])) echo $bar_c["inventory_number_format"]?></textarea>
    </td>
</tr>
<tr><td bgcolor=white ><?php echo $msgstr["inventory_number_pref_list"]?><strong><font color=red>*</font></strong></td>
    <td bgcolor=white><input type=text name=tag_inventory_number_pref_list value='<?php
        if (isset($bar_c["inventory_number_pref_list"])) echo $bar_c["inventory_number_pref_list"]?>' size=5>
    </td>
    <td bgcolor=white><?php echo $msgstr["inventory_number_display"]?><strong><font color=red>*</font></strong></td>
    <td bgcolor=white><textarea name=tag_inventory_number_display cols=80 rows=2><?php
        if (isset($bar_c["inventory_number_display"])) echo $bar_c["inventory_number_display"]?></textarea>
    </td>
</tr>

<tr><td bgcolor=white><?php echo $msgstr["pft"]?><strong><font color=red>*</font></strong></td>
    <td bgcolor=white colspan=3><textarea name=tag_label_format cols=80 rows=2><?php
        if (isset($bar_c["label_format"])) echo $bar_c["label_format"]?></textarea>
    <button class="bt-green" type="button"
        title="<?php echo $msgstr["m_editdispform"]?>" onclick='javascript:EditarFormato(document.forma1.tag_label_format)'>
        <i class="fa fa-edit"></i> <?php echo $msgstr["m_editdispform"]?></button> &nbsp;
    </td>
</tr>

<tr><td bgcolor=white><?php echo $msgstr["pft"]."<br>".$msgstr["sendto"]?><strong>TXT</strong></td>
    <td bgcolor=white colspan=3><textarea name=tag_label_format_txt cols=80 rows=2><?php
        if (isset($bar_c["label_format_txt"])) echo $bar_c["label_format_txt"];?></textarea>
    <button class="bt-green" type="button"
        title="<?php echo $msgstr["m_editdispform"]?>" onclick='EditarFormato(document.forma1.tag_label_format_txt)'>
        <i class="fa fa-edit"></i> <?php echo $msgstr["m_editdispform"]?></button> &nbsp;
    </td>
</tr>

<tr><td bgcolor=white nowrap><?php echo $msgstr["label_height"]?> <strong><font color=red>*</font></strong></td>
    <td bgcolor=white colspan=3><input type=text name=tag_height size=10 value="<?php
        if (isset($bar_c["height"])) echo $bar_c["height"];?>"> cm
    </td>
</tr>

<tr><td bgcolor=white nowrap><?php echo $msgstr["label_width"]?> <strong><font color=red>*</font></strong></td>
    <td bgcolor=white colspan=3><input type=text name=tag_width size=10 value="<?php
        if (isset($bar_c["width"])) echo $bar_c["width"];?>"> cm
    </td>
</tr>

<tr><td bgcolor=white nowrap><?php echo $msgstr["labels_row"]?> <strong><font color=red>*</font></strong></td>
    <td bgcolor=white colspan=3><input type=text name=tag_cols size=10 value="<?php
        if (isset($bar_c["cols"])) echo $bar_c["cols"];?>">
    </td>
</tr>

</table>

<p class="color-red"><b>(*) <?php echo $msgstr["labels_mandatory"]?></b></p>

<a class="bt bt-default" href="javascript:AbrirVentana("../dbadmin/fdt_leer.php?base=<?php echo $base; ?>")">FDT</a>
&nbsp; &nbsp;
<a class="bt bt-default" href="javascript:AbrirVentana("../dbadmin/fst_leer.php?base=<?php echo $base; ?>")" >FST</a>
<br><br>

<input class="bt bt-green" type="submit" value="<?php echo $msgstr["update"]?>" onClick=Javascript:Enviar()>

</form>
<form name=editpft method=post action=../dbadmin/leertxt.php target=editpft>
<input type=hidden name=desde value=dataentry>
<input type=hidden name=base value=<?php echo $base?>>
<input type=hidden name=cipar value=<?php echo $base?>.par>
<input type=hidden name=archivo>
<input type=hidden name=descripcion>
</form>
</div>
</div>
<?php
include("../common/footer.php");
?>

