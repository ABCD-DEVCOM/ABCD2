<?php
/*
20220924 fho4abcd Improve html, new style buttons, helper, translations
20220925 fho4abcd moved from dbadmin to documentacion
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/lang.php");

include("../common/header.php");
include("../dbadmin/fdt_include.php");

?>
<body>
<script language="JavaScript" type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script language=javascript>
function EditarAyuda(){
	ix=document.edithlp.FDT.selectedIndex
	if (ix==0) return
	ix1=document.edithlp.FDT.options[ix].value
	a=fdt[ix1]
	campo=a.split('|')
	tag=Trim(campo[1])
	lenguaje="<?php echo $_SESSION["lang"]?>"
	subcampo=""
	if (Trim(document.edithlp.subc.value)!="")
		subcampo="_"+document.edithlp.subc.value
	msgwin=window.open("../documentacion/edit_help_db.php?base=<?php echo $arrHttp["base"]?>&help="+tag+subcampo)
	msgwin.focus()

}

function VerAyuda(){
	ix=document.edithlp.FDT.selectedIndex
	if (ix==0) return
	ix1=document.edithlp.FDT.options[ix].value
	a=fdt[ix1]
	campo=a.split('|')
	subcampo=""
	if (Trim(document.edithlp.subc.value)!="")
		subcampo="_"+document.edithlp.subc.value
	tag="tag_"+campo[1]+subcampo+".html"
	lenguaje="<?php echo $_SESSION["lang"]?>"
	msgwin=window.open("../documentacion/ayuda_db.php?base=<?php echo $arrHttp["base"]?>&campo="+tag)
	msgwin.focus()

}
function ProducirSalida(a,tipo){
	tab=a.split('|')
	out=""
	if (tipo!="sc"){
		if (tab[1]!="") out="<?php echo $msgstr["tag"]?>: "+tab[1]+"\r"
		out+="<?php echo $msgstr["title"]?>: "+tab[2]+"\r"
		if (tab[3]==1) out+="<?php echo $msgstr["mainentry"]?>: <?php echo $msgstr["set_yes"]?>\r"
		if (tab[4]==1) out+="<?php echo $msgstr["repeat"]?>: yes\r"
	}
    if (tab[5]!="")  out+="<?php echo $msgstr["subfields"]?>: "+tab[5]+"\r"
    if (tipo=="sc")  out+="<?php echo $msgstr["title"]?>: "+tab[2]+"\r"
    if (tab[6]!="")  out+="<?php echo $msgstr["subfields"].' '.$msgstr["preliteral"]?>: "+tab[6]+"\r"
    if (tab[7]!="")  out+="<?php echo $msgstr["inputtype"]?>: "+input_type[tab[7]]+"\r"
    if (tab[8]!="")  out+="<?php echo $msgstr["row"]?>: "+tab[8]+"\r"
    if (tab[9]!="")  out+="<?php echo $msgstr["cols"]?>: "+tab[9]+"\r"
    if (tab[10]!="") out+="<?php echo $msgstr["picklist"].' '.$msgstr["type"]?>: "+pick_type[tab[10]]+"\r"
    if (tab[11]!="") out+="<?php echo $msgstr["picklist"].' '.$msgstr["name"]?>: "+tab[11]+"\r"
    if (tab[12]!="") out+="<?php echo $msgstr["picklist"].' '.$msgstr["prefix"]?>: "+tab[12]+"\r"
    if (tab[13]!="") out+="<?php echo $msgstr["picklist"].' '.$msgstr["listas"]?>: "+tab[13]+"\r"
    if (tab[14]!="") out+="<?php echo $msgstr["picklist"].' '.$msgstr["extractas"]?>: "+tab[14]+"\r"
    if (tab[15]!="") out+="<?php echo $msgstr["valdef"]?>: "+tab[15]+"\r"
    if (tab[16]==1)  out+="<?php echo $msgstr["help"]?>: <?php echo $msgstr["set_yes"]?>"+"\r"
    return out
}

function Showfdt(){
	input_type=Array()
	pick_type=Array()
<?php
	foreach ($input_type as $key=>$type){
		echo  "input_type[\"$key\"]=\"$type\"\n";
	}
	foreach ($pick_type as $key=>$type){
		echo  "pick_type[\"$key\"]=\"$type\"\n";
	}
?>
	ix=document.edithlp.FDT.selectedIndex
	if (ix==0) return
	ix1=document.edithlp.FDT.options[ix].value
	a=fdt[ix1]
	variable=ProducirSalida(a,"campo")
    ix1++
    for (i=ix1;i<999;i++){
    	a=fdt[i]
		tab=a.split('|')
		if (tab[0]!="S") {
			i=1000
		}else{
			linea=ProducirSalida(a,"sc")
			variable+="\r"+linea
		}

    }
	document.edithlp.campo.value=variable
}
</script>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["helpdatabasefields"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
    <?php
    $backtoscript="../dbadmin/menu_modificardb.php?base=".$arrHttp["base"].$encabezado;
    include "../common/inc_back.php";
    include("../common/inc_home.php");
    ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php $ayuda="helpfilesdb.html";include "../common/inc_div-helper.php"; ?>
<div class="middle form">
<div class="formContent">
<?php
// Check the existence of the language help folder and create it if it does not exist
$archivofolder=$db_path.$arrHttp["base"]."/ayudas/".$_SESSION["lang"];
if (!file_exists($archivofolder)){
    if ( mkdir($archivofolder,0770,TRUE)== TRUE ) {
        echo $msgstr["created"].': '.$archivofolder."<br>";
    } else {
        echo "<div style='color:red'>".$msgstr["fatal"].'. '.$msgstr["foldernotc"].': '.$archivofolder."</div>";
        die;
    }
}
// Read the content of the FDT
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
if (file_exists($archivo)) {
    echo $msgstr["leyendo"]." FDT<br>";
	$fp=file($archivo);
} else {
    echo "<div style='color:red'>".$msgstr["fatal"].": ".$msgstr["misfile"]." &rarr; ".$archivo."</div>";
    die;
}
?>
<form name=edithlp method=post action="javascript:void(0);">
<table border=0>
<tr>
<td>
<?php
$ixFdt=0;
echo "<script>\n";
echo "fdt=new Array()\n";
echo "fdt[0]=\"\"\n";
foreach ($fp as $value){
	$value=trim($value);
	$t=explode('|',$value);
	if ($t[1]!=""){
		$fdt[$t[1]]=$value;
		$ixFdt=$ixFdt+1;
		$value=str_replace('"','\"',$value);
		echo "fdt[$ixFdt]=\"$value\"\n";
	}
}
echo "</script>\n";
echo $msgstr["fn"].": ";
echo "<select name=FDT onchange=Showfdt()>
	<option></option>\n";
$ixFdt=0;
foreach ($fdt as $key=>$value){
	$t=explode('|',$value);
	$ixFdt=$ixFdt+1;
	echo "<option value=$ixFdt>".$t[1]." ".$t[2]."</option>\n";

}
?>
</select></td>
    <td><?php echo $msgstr["subfield"].": "?><input type=text name=subc size=1 maxlength=1></td>
</tr>
<tr>
    <td colspan=2><textarea name=campo rows=15 cols=60 readonly></textarea></td>
</tr>
</tr>
<tr>
    <td><a class="bt bt-blue" href=javascript:VerAyuda()><i class="fas fa-tv"></i> &nbsp; <?php echo $msgstr["show"].' '.$msgstr["help"]?></a>
    <td><a class="bt bt-blue" href=javascript:EditarAyuda()><?php echo $msgstr["edithelpfile"]?></a></td>
</tr>
</table>
</form>
</div>
</div>
<?php
include("../common/footer.php");
?>