<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/acquisitions.php");
include("../lang/admin.php");

include("../common/get_post.php");
$arrHttp["base"]="suggestions";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
//die;
include ('../dataentry/leerregistroisis.php');

include("../common/header.php");
?>
<style>
#headerDiv, #contentDiv {
float: left;
width: 510px;
}
#titleText {
float: left;
font-size: 1.2em;
font-weight: bold;
margin: 5px 10px;
}
headerDiv {
background-color: #ffffff;
color: #000000;
}
contentDiv {
background-color: #FFE694;
}
myContent {
margin: 5px 10px;
}
headerDiv a {
float: left;
margin: 10px 10px 5px 5px;
}
headerDiv a:hover {
color: #;
}
</style>
<script src=../dataentry/js/lr_trim.js></script>
<script language=javascript src=../dataentry/js/popcalendar.js></script>
<script>
function toggle(showHideDiv, switchTextDiv) {
	var ele = document.getElementById(showHideDiv);
	var text = document.getElementById(switchTextDiv);
	if(ele.style.display == "block") {
    	ele.style.display = "none";
		text.innerHTML = "<?php echo $msgstr["createorder"]?>";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "<?php echo $msgstr["hide"]?>";
	}
}

function EnviarForma(Forma,Elem){
	activeForm=eval("document."+Forma)
    submitCtrl=eval("document."+Forma+".submit_"+Elem)

	Ctrl_order=eval("document."+Forma+".order_no")
	if (Trim(Ctrl_order.value)==""){		alert("<?php echo $msgstr["missorder"]?>")
		return	}
	Ctrl_date=eval("document."+Forma+".order_date")
	if (Trim(Ctrl_date.value)==""){
		alert("<?php echo $msgstr["missdate"]?>")
		return
	}
	msgwin=window.open("",Elem,"width=600, height=600,scrollbars, status, resizable")
	activeForm.target=Elem

	submitCtrl.value="S"
	activeForm.submit()
	msgwin.focus()
}
</script>
<?php
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["suggestions"].": ".$msgstr["order"]?>
	</div>
	<div class="actions">
	<?php include("order_menu.php")?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/order_ex.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/order_ex.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: order_ex.php</font>\n";
?>
	</div>




<div class="middle form">
			<div class="formContent">
<?php
// se lee el formato de la fecha utilizando la configuración de préstamos
$locales=explode('/',$config_date_format);
switch ($locales[0]){	case "DD":
		$date1="d";
		break;
	case "MM":
		$date1="m";
		break;
}switch ($locales[1]){
	case "DD":
		$date2="d";
		break;
	case "MM":
		$date2="m";
		break;
}
date_default_timezone_set('UTC');
$formato_fecha="$date1-$date2-Y";
$fecha=date($formato_fecha);
//
$exp=explode("\n",$arrHttp["Mfn_sel"]);
$Expresion="";
foreach ($exp as $value){	$value=trim($value);	if ($value!=""){
		$e=explode('_',$value);
		$Mfn[$value]=$value;  // se hace un arreglo que tiene el MFN y el número de la ocurrencia		$value="MFN_".$e[0];  // se construye la expresión de búsqueda
		if ($Expresion==""){			$Expresion=$value;		}else{			$Expresion.=" or $value";		}
	}}
$Expresion=urlencode($Expresion);
$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/pv_order.pft" ;
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/pv_order.pft" ;
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&Expresion=$Expresion&Formato=@$Formato&Opcion=buscar";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
$order=array();
foreach ($contenido as $value){
	if (trim($value)!=""){
// se averigua si la ocurrencia que se presenta ha sido seleccionada		$v=explode('|',$value);
		if (isset($Mfn[$v[1]]))
			$order[$v[0]][]=$value;	}}
ksort($order);
$tit=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/pv_order_tit.tab";
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/pv_order_tit.tab" ;
$fp=file($tit);
$tit_tab=implode("",$fp);
$cols=explode('|',$tit_tab);
echo "<table class=listTable cellspacing=3>" ;
echo "<tr>";
foreach ($cols as $value){	echo "<th>".$value."</th>";}
$form=0;
foreach ($order as $prov=>$linea){	echo "<tr><td colspan=3><strong>$prov</strong></td></tr>";
	$form=$form+1;
	echo "<form name=form_$form action=order_update.php onsubmit='return false'>
	<input type=hidden name=forma value='form_$form'>
	<input type=hidden name=provider value='$prov'>
	<input type=hidden name=acqtype value=>
	";
	$or="";
	$typeacq="";
	foreach ($linea as $l){
		$cell=explode('|',$l);		if ($or=="")
			$or=$cell[1];
		else
			$or.="|".$cell[1];
		if ($typeacq=="") $typeacq=$cell[15];
	    echo "\n<tr>";
	    $ix1=0;
	    foreach ($cell as $c){
	    	$ix1=$ix+1;
	    	if ($ix1>2) {	    		if ($ix1!==16) {	    			echo  "<td>".$c."</td>";	    		}else{	    			$acq=strpos($cell[15],'^',2);
	    			echo "<td>".substr($cell[15],$acq+2)."(".substr($cell[15],2,$acq-2).")</td>";	    		}
	   		}
		}
		echo "<input type=hidden name=object_".$cell[1]." value=\"".$cell[5]."\">

		<input type=hidden name=cant_".$cell[1]." value=\"".$cell[7]."\">
		<input type=hidden name=precio_".$cell[1]." value=\"".$cell[8]."\">
		<input type=hidden name=suggestionno_".$cell[1]." value=\"".$cell[2]."\">
		<input type=hidden name=biddingno_".$cell[1]." value=\"".$cell[4]."\">

		<input type=hidden name=objtype_".$cell[1]." value=\"".$cell[10]."\">
		<input type=hidden name=dbn_".$cell[1]." value=\"".$cell[11]."\">
		<input type=hidden name=submit_".$cell[1]." value=\"\">
		<input type=hidden name=controln_".$cell[1]." value=\"".$cell[12]."\">
		<input type=hidden name=volume_".$cell[1]." value=\"".$cell[13]."\">
		<input type=hidden name=tome_".$cell[1]." value=\"".$cell[14]."\">
		<input type=hidden name=acqtype_".$cell[1]." value=\"".$cell[15]."\">
		";
		$cc=explode("_",$cell[1]);  // para obtener el Mfn del registro de la sugerencia
		echo "<input type=hidden name=Mfnsuggestion_".$cell[1]." value=".$cc[0].">\n";	}
	echo "<tr><td colspan=3>
		<div id=headerDiv_".$cell[1]. "style=\"headerDiv\">
	    	<div id=titleText_".$cell[1]." class=titleText><a id=myHeader_".$cell[1]." style=\"myHeader\" href=\"javascript:toggle('contentDiv_".$cell[1]."','myHeader_".$cell[1]."');\" >".$msgstr["createorder"]."</a>
		</div>
		<div id=contentDiv_".$cell[1]." style=\"display:none; hide:block\">
     		".$msgstr["order_no"]."<input type=text name=order_no> &nbsp; &nbsp; ".$msgstr["date"]."<input type=text name=order_date value=$fecha size=10>
     		&nbsp &nbsp <input type=submit value=".$msgstr["submit"]." onclick=EnviarForma('form_$form','".$cell[1]."')>
		</div>
		<br>
	</td></tr>\n";
	echo "</form>";
}

echo "</table>";

?>
<form method=post name=forma1 action=order_update.php onSubmit="javascript:return false">
<input type=hidden name=Mfn value="<?php echo $arrHttp["Mfn_sel"]?>">
<input type=hidden name=order value="<?php echo $purchase?>">
</form>
</div></div>
<?php
include("../common/footer.php");
?>
