<?php
/*
20220320 fho4abcd Created
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include ("../lang/reports.php");
$base=$arrHttp["base"];
include("../common/header.php");
$ayuda="barcode.html";
?>
<body>
<script>
function Top_bcl_config_labels(){
    top.location.href = "../barcode/bcl_config_labels.php?base=<?php echo $base?>"
}
</script>
<div class="sectionInfo">
    <div class="breadcrumb"><?php echo $msgstr["bcl_show_print"]?>
    </div>
    <div class="actions">
        <?php
        $backtoscript="bcl_labelshow.php";
        include "../common/inc_back.php";
        ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<?php
include "inc_barcode_constants.php";
include "inc_barcode_configure.php";
if ($msg_err!="" ) {
    echo "<div style='color:red'>".$msg_err."</div>";
    echo "<div>".$msgstr["bcl_continuewith"].": ";
    echo "<a href='javascript:Top_bcl_config_labels()'>".$msgstr["barcode_table"]."</a>";
    echo "</div>";
	echo "</div></div>";
	include("../common/footer.php");
	die;
}
$base_inventory=$arrHttp["base"];
$base_classification=$arrHttp["base"];
$bar_c=array();

echo "<h4>".$msgstr["barcode_type"].": ".$arrHttp["desc"]."</h4>";
?>
<form name=forma1 action=bcl_labelshow_result.php method=post onSubmit='javascript:return false'>
    <input type=hidden name=Indice>
    <input type=hidden name=base>
    <input type=hidden name=Opcion>
    <input type=hidden name=copies>

<table><tr>
    <td>
        <strong><?php echo $msgstr["sendto"].": ";?> &nbsp;</strong>
    </td>
    <td>
        <input type=radio name=output value=display checked > <?php echo $msgstr["display"];?> &nbsp; &nbsp; 
        <input type=radio name=output value=doc> <?php echo $msgstr["doc"];?> &nbsp; &nbsp; 
        <input type=radio name=output value=txt> <?php echo $msgstr["txt_file"];?> &nbsp; &nbsp; 
        <input type=radio name=output value=txt_print> <?php echo $msgstr["txt_print"];?>
    </td>
    </tr><tr>
    <td>
        <strong><?php echo $msgstr["barcode_border"];?></strong> &nbsp;
    </td>
    <td>
        <input type=checkbox name=border title="<?php echo $msgstr['barcode_border_info']?>">
    </td>
    </tr><tr>
    <td>
        <strong><?php echo $msgstr["barcode_wxis_sum"];?></strong> &nbsp;
    </td>
    <td>
        <input type=checkbox name=wxis_sum title="<?php echo $msgstr['barcode_wxis_sum_info']?>">
    </td>
</table>
<br><br>
<?php


if (!isset($arrHttp["Mfn"])){
    echo "<table><td valign=top>";
    echo "<font size=3><strong>".$msgstr["r_recsel"]."&nbsp; &nbsp; </strong></font>";
    echo "</td><td>";
    echo "<table>";
    echo "<tr height=50px><td><strong>".$msgstr["byclass_num"]."</strong></td>";
    echo "<td>&nbsp; &nbsp; &nbsp;".$msgstr["cg_from"]."</td>";
    echo "<td>";
    //(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,Repetible,Formato){
    echo "<a href='javascript:AbrirIndiceAlfabetico(document.forma1.classification_from,\"$classification_number_pref\",\"\",\"\",\"$base_classification\",\"$base_classification.par\",\"classification_from\",\"1\",\"0\",\"".urlencode(str_replace('"','|',$classification_number_format))."\")'><img src=../dataentry/img/defaultButton_list.png border=0 width=16></a>";
    echo "<input type=text name=classification_from size=30>";
    echo "</td>";
    echo "<td>&nbsp; &nbsp; &nbsp;".$msgstr["cg_to"]."</td>";
    echo "<td>";
    echo "<a href='javascript:AbrirIndiceAlfabetico(document.forma1.classification_from,\"$classification_number_pref\",\"\",\"\",\"$base_classification\",\"$base_classification.par\",\"classification_to\",\"1\",\"0\",\"".urlencode(str_replace('"','|',$classification_number_format))."\")'><img src=../dataentry/img/defaultButton_list.png border=0 width=16></a>";
    echo "<input type=text name=classification_to size=30>";
    echo "</td>";
    echo "<td><input type=submit name=classification value=".$msgstr["entrar"]." onClick=javascript:PorNumeroClasificacion()></td>";
    echo "</tr>";
    echo "<tr height=50px><td><strong>".$msgstr["byinventory_num"]."</strong></td>";
    echo "<td>&nbsp; &nbsp; &nbsp;".$msgstr["cg_from"]."</td>";
    echo "<td>";
    echo "<a href='javascript:AbrirIndiceAlfabetico(document.forma1.inventory_from,\"$inventory_number_pref\",\"\",\"\",\"$base_inventory\",\"$base_inventory.par\",\"inventory_from\",\"1\",\"0\",\"".urlencode($inventory_number_format)."\")'><img src=../dataentry/img/defaultButton_list.png border=0 width=16></a>";
    echo "<input type=text name=inventory_from size=30>";
    echo "</td>";
    echo "<td>&nbsp; &nbsp; &nbsp;".$msgstr["cg_to"]."</td>";
    echo "<td>";
    echo "<a href='javascript:AbrirIndiceAlfabetico(document.forma1.inventory_to,\"$inventory_number_pref\",\"\",\"\",\"$base_inventory\",\"$base_inventory.par\",\"inventory_to\",\"1\",\"0\",\"".urlencode($inventory_number_format)."\")'><img src=../dataentry/img/defaultButton_list.png border=0 width=16></a>";
    echo "<input type=text name=inventory_to size=30>";
    echo "</td>";
    echo "<td><input type=submit name=inventory value=".$msgstr["entrar"]." onClick=javascript:PorNumeroInventario()></td>";
    echo "</tr>";

    echo "<tr height=50px><td><strong>".$msgstr["byinventory_list"]."<br>".$msgstr["list_comma"]."</strong></td>";
    echo "<td colspan=4>";
    echo "<textarea name=inventory_list cols=90 rows=1></textarea>";
    echo "</td>";
    echo "<td><input type=submit name=inven_list value=".$msgstr["entrar"]." onClick=javascript:PorListaInventario()></td>";
    echo "</tr>";

    if (isset($input_date_pref)){
    echo "<tr height=50px><td><strong>".$msgstr["byinput_date"]." (".$base_date.")</strong></td>";
    echo "<td>&nbsp; &nbsp; &nbsp;".$msgstr["cg_from"]."</td>";
    echo "<td>";
    echo "<a href='javascript:AbrirIndiceAlfabetico(document.forma1.date_from,\"$pref_date\",\"\",\"\",\"$base_date\",\"$base_date.par\",\"date_from\",\"1\",\"0\",\"".urlencode($fe_date)."\")'><img src=../dataentry/img/defaultButton_list.png border=0 width=16></a>";
    echo "<input type=text name=date_from size=30>";
    echo "</td>";
    echo "<td>&nbsp; &nbsp; &nbsp;".$msgstr["cg_to"]."</td>";
    echo "<td>";
    echo "<a href='javascript:AbrirIndiceAlfabetico(document.forma1.date_to,\"$pref_date\",\"\",\"\",\"$base_date\",\"$base_date.par\",\"date_to\",\"1\",\"0\",\"".urlencode($fe_date)."\")'><img src=../dataentry/img/defaultButton_list.png border=0 width=16></a>";
    echo "<input type=text name=date_to size=30>";
    echo "</td>";
    echo "<td>";
    echo "<input type=submit name=date value=".$msgstr["entrar"]." onClick=Javascript:PorFechaIngreso()></td>";
    echo "</tr>";
    }
    echo "<tr height=50px><td><strong>".$msgstr["bymfn_range"]."</strong></td>";
    echo "<td>&nbsp; &nbsp; &nbsp;".$msgstr["cg_from"]."</td>";
    echo "<td>&nbsp; &nbsp; &nbsp;<input type=text name=mfn_from size=30>";
    echo "</td>";
    echo "<td>&nbsp; &nbsp; &nbsp;".$msgstr["cg_to"]."</td>";
    echo "<td>&nbsp; &nbsp; &nbsp;<input type=text name=mfn_to  size=30>";
    echo "</td>";
    echo "<td><input type=submit name=mfn value=".$msgstr["entrar"]." onClick='javascript:PorRangoMfn()'></td>";
    echo "</tr>";
    echo "</tr>";
}else{
    echo "<input type=hidden name=mfn_from size=30 value=".$arrHttp["Mfn"].">\n";
    echo "<input type=hidden name=mfn_to size=30 value=".$arrHttp["Mfn"].">\n";
    echo "<input type=submit name=mfn value=".$msgstr["entrar"]." onClick='javascript:PorRangoMfn()'>";
}
echo "<input type=hidden name=tipo value=".$arrHttp["tipo"].">\n";
echo "</form>";

echo "</table></td></table>";
?>
</div>
</div>
<?php
include("../common/footer.php");
?>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script>
function Enviar(){
	document.forma1.target=""
	if (document.forma1.output[0].checked || document.forma1.output[3].checked){
		msgwin=window.open("","display","width=800,height=600,scrollbars,menubar,toolbar,resizable");
		document.forma1.target="display"
		msgwin.focus()
	}
	document.forma1.submit()
}
function PorNumeroClasificacion(){
	classification_from=Trim(document.forma1.classification_from.value)
	classification_to=Trim(document.forma1.classification_to.value)
    if (Trim(classification_from)=="" || Trim(classification_to)==""){
    	alert("<?php echo $msgstr["range_classification_invalid"]?>")
    	return
    }
    if (classification_to<classification_from){
    	alert("<?php echo $msgstr["range_classification_invalid"]?>")
    	return
    }
    document.forma1.base.value="<?php echo $arrHttp["base"]?>"
    document.forma1.Opcion.value="clasificacion"
    document.forma1.copies.value="<?php echo $copies?>"
	Enviar()
}

function PorNumeroControl(){
	control_from=Trim(document.forma1.control_from.value)
	control_to=Trim(document.forma1.control_to.value)
    if (Trim(control_from)=="" || Trim(control_to)=="" ||Trim(control_from)==0 || Trim(control_to)==0){
    	alert("<?php echo $msgstr["range_control_invalid"]?>")
    	return
    }
    if (control_to<control_from){
    	alert("<?php echo $msgstr["range_control_invalid"]?>")
    	return
    }
    document.forma1.base.value="<?php echo $arrHttp["base"]?>"
    document.forma1.Opcion.value="control"
    document.forma1.copies.value="<?php echo $copies?>"
	Enviar()
}

function PorNumeroInventario(){
    inventory_from=Trim(document.forma1.inventory_from.value)
	inventory_to=Trim(document.forma1.inventory_to.value)
    if (Trim(inventory_from)=="" || Trim(inventory_to)==""){
    	alert("<?php echo $msgstr["range_inventory_invalid"]?>")
    	return
    }
    if (inventory_to<inventory_from){
    	alert("<?php echo $msgstr["range_inventory_invalid"]?>")
    	return
    }
    document.forma1.base.value="<?php echo $arrHttp["base"]?>"
    document.forma1.Opcion.value="inventario"
    document.forma1.copies.value="<?php echo $copies?>"
	Enviar()
}

function PorListaInventario(){
    inventory_list=Trim(document.forma1.inventory_list.value)
    inventory_list=inventory_list.replace(/(?:\r\n|\r|\n)/g, ",")
    document.forma1.inventory_list.value=inventory_list
    if (Trim(inventory_list)==""){
    	alert("<?php echo $msgstr["list_inventory"]?>")
    	return
    }
    a=inventory_list.split(',')
    if (a.length>100){
    	alert("<?php echo $msgstr["list_inventory_invalid"]?>")
    	return
    }
    document.forma1.base.value="<?php echo $arrHttp["base"]?>"
    document.forma1.Opcion.value="lista_inventario"
    document.forma1.copies.value="<?php echo $copies?>"
	Enviar()
}

function PorFechaIngreso(){
    date_from=Trim(document.forma1.date_from.value)
	date_to=Trim(document.forma1.date_to.value)
    if (Trim(date_from)=="" || Trim(date_to)==""){
    	alert("<?php echo $msgstr["range_date_invalid"]?>")
    	return
    }
    if (date_to<date_from){
    	alert("<?php echo $msgstr["range_date_invalid"]?>")
    	return
    }
    document.forma1.base.value="<?php echo $arrHttp["base"]?>"
    document.forma1.Opcion.value="date"
    document.forma1.copies.value="<?php echo $copies?>"
	Enviar()
}

function PorRangoMfn(){
	mfn_from=Trim(document.forma1.mfn_from.value)
	mfn_to=Trim(document.forma1.mfn_to.value)
    if (Trim(mfn_from)=="" || Trim(mfn_to)=="" || mfn_from==0 || mfn_to==0 ){
    	alert("<?php echo $msgstr["range_mfn_invalid"]?>")
    	return
    }
    if (mfn_to<mfn_from){
    	alert("<?php echo $msgstr["range_mfn_invalid"]?>")
    	return
    }
    document.forma1.base.value="<?php echo $arrHttp["base"]?>"
    document.forma1.Opcion.value="mfn"
    document.forma1.copies.value="<?php echo $copies?>"
	Enviar()
}

Ctrl_activo=""



function AbrirIndiceAlfabetico(xI,Prefijo,Subc,Separa,db,cipar,tag,postings,Repetible,Formato){
	Ctrl_activo=xI
	baseactiva="<?php echo $arrHttp["base"]?>"
	lang="<?php echo $_SESSION["lang"]?>"
    document.forma1.Indice.value=xI
    Separa="&delimitador="+Separa
    Prefijo=Separa+"&tagfst="+tag+"&prefijo="+Prefijo
    myleft=screen.width-600
	url_indice="../dataentry/capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+Prefijo+"&postings="+postings+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato+"&subcampos="+Subc+"&baseactiva="+baseactiva
	msgwin=window.open(url_indice,"Indice","width=650, height=530,  scrollbars, status, resizable location=no, left="+myleft)
	msgwin.focus()
	return
}
</script>
