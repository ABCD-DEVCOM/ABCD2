<?php
/*
20220221 fho4abcd backbutton,divhelper, lineends, newlook for config links+improved feedback
*/
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");
$cm2em=2.37106301584;


include ("../common/header.php");
include ("../lang/reports.php");
include ("../lang/soporte.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("configure.php");
?>
<body>
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
<div class="sectionInfo">
	<div class="breadcrumb">
        <?php echo $msgstr["barcode"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
        <?php
        if (isset($arrHttp["Mfn"])){
            $backtoscript="javascript:top.Menu('same')";
        }else{
            $backtoscript="../barcode/menu.php";
        }
        include "../common/inc_back.php";
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

$base_inventory=$arrHttp["base"];
$base_classification=$arrHttp["base"];
$bar_c=array();
$shortfile=$arrHttp["base"]."/pfts/".$lang."/".$arrHttp["tipo"].".conf";
if (!file_exists($db_path.$shortfile)){
	echo "<h4>".$msgstr["barcode_conf"]."</h4>";
    if ( $arrHttp["tipo"]=="barcode" ) {
        ?>
        <br> &nbsp; &nbsp; <i class="fa fa-cog"></i>
            <a href=barcode_conf.php?base=".$arrHttp["base"]."&tipo=barcode>
               <strong><?php echo $msgstr["configure"]." ".$msgstr["barcode"];?></strong></a>
               &nbsp; &nbsp; &rarr; <?php echo $shortfile?>
    <?php } elseif ($arrHttp["tipo"]=="lomos" ) {
        ?>
        <br> &nbsp; &nbsp; <i class="fa fa-cog"></i>
            <a href=barcode_conf.php?base=".$arrHttp["base"]."&tipo=lomos>
               <strong><?php echo $msgstr["configure"]." ".$msgstr["barcode_lomos"];?></strong></a>
               &nbsp; &nbsp; &rarr; <?php echo $shortfile?>
    <?php } else {
        ?>
        <br> &nbsp; &nbsp; <i class="fa fa-cog"></i>
            <a href=barcode_conf.php?base=".$arrHttp["base"]."&tipo=etiquetas>
               <strong><?php echo $msgstr["configure"]." ".$msgstr["barcode_etiquetas"];?></strong></a>
               &nbsp; &nbsp; &rarr; <?php echo $shortfile?>
    <?php
    }
	$err="Y";
}else{
	$err="";
}

if ($err!=""){
	echo "</div></div>";
	include("../common/footer.php");
	die;
}

echo "<form name=forma1 action=barcode_ex.php method=post onSubmit='javascript:return false'>";
echo "<font size=3><strong>".$msgstr["barcode_type"].": ";
switch ($arrHttp["tipo"]){
	case "barcode":
		echo $msgstr["barcode"];
		break;
	case "lomos":
		echo $msgstr["barcode_lomos"];
		break;
	case "etiquetas":
		echo $msgstr["barcode_etiquetas"];
		break;
}

echo "</strong></font><p>";
if (!isset($arrHttp["Mfn"])) {
    ?>
    <i class="fa fa-cog"></i>
    <a href=barcode_conf.php?base=<?php echo $arrHttp["base"];?>&tipo=<?php echo $arrHttp["tipo"];?>>
       <strong><?php echo $msgstr["configure"];?></strong></a><br>
    <?php
}
?>
<br>
<strong><?php echo $msgstr["sendto"].": ";?></strong>
&nbsp; &nbsp; <input type=radio name=output value=display checked > <?php echo $msgstr["display"];?>
&nbsp; &nbsp; <input type=radio name=output value=doc> <?php echo $msgstr["doc"];?>
&nbsp; &nbsp; <input type=radio name=output value=txt> <?php echo $msgstr["txt_file"];?>
&nbsp; &nbsp; <input type=radio name=output value=txt_print> <?php echo $msgstr["txt_print"];?>
<br><br>
<?php


echo "<input type=hidden name=Indice>";
echo "<input type=hidden name=base>";
echo "<input type=hidden name=Opcion>";
echo "<input type=hidden name=copies>";
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
	/*
	echo "<tr height=50px><td><strong>".$msgstr["bycontrol_num"]." (".$base_control.")</strong></td>";
	echo "<td>&nbsp; &nbsp; &nbsp;".$msgstr["cg_from"]."</td>";
	echo "<td>";
	echo "<a href='javascript:AbrirIndiceAlfabetico(document.forma1.control_from,\"$pref_control\",\"\",\"\",\"$base_control\",\"$base_control.par\",\"control_from\",\"1\",\"0\",\"".urlencode($fe_control)."\")'><img src=../dataentry/img/defaultButton_list.png border=0 width=16></a>";
	echo "<input type=text name=control_from size=30>";
	echo "</td>";
	echo "<td>&nbsp; &nbsp; &nbsp;".$msgstr["cg_to"]."</td>";
	echo "<td>";
	echo "<a href='javascript:AbrirIndiceAlfabetico(document.forma1.control_to,\"$pref_control\",\"\",\"\",\"$base_control\",\"$base_control.par\",\"control_to\",\"1\",\"0\",\"".urlencode($fe_control)."\")'><img src=../dataentry/img/defaultButton_list.png border=0 width=16></a>";
	echo "<input type=text name=control_to size=30>";
	echo "</td>";
	echo "<td><input type=submit name=control value=".$msgstr["entrar"]." onClick=javascript:PorNumeroControl()></td>";
	echo "</tr>";
	*/
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

