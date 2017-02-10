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
$arrHttp["base"]="purchaseorder";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
//die;
include ('../dataentry/leerregistroisis.php');

include("../common/header.php");

?>
</style>
<script src=../dataentry/js/lr_trim.js></script>
<script>
//Actualiza las copias de la base de datos
function Update(elem){
	activeForm=eval("document.frm"+elem)
	if (activeForm.received.value==""){		alert("<?php echo $msgstr["misscr"]?>")
		return	}
	if (activeForm.received.value*1.0>activeForm.copies_req.value*1.0){		alert("<?php echo $msgstr["invcr"]?>")
		return	}
	activeForm.submit()}
</script>
<?php
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["purchase"].": ".$msgstr["receiving"]?>
	</div>
	<div class="actions">
	<?php include("order_menu.php")?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/acquisitions/receive_order_ex.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/acquisitions/receive_order_ex.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: receive_order_ex.php</font>\n";
?>
	</div>

<div class="middle form">
			<div class="formContent">
<?php
// Se localiza la Órden de compra
$Formato=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/receiving.pft" ;
if (!file_exists($Formato)) $Formato=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/receiving.pft" ;
$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&Expresion=ON_".$arrHttp["searchExpr"]."&Formato=@$Formato&Opcion=buscar";
$IsisScript=$xWxis."imprime.xis";
include("../common/wxis_llamar.php");
//foreach ($contenido as $value)  echo "$value<br>";
$salida=implode("\n",$contenido);
$linea=explode('$$$$',$salida);
$Mfn_order=$linea[2];
$provider=$linea[3];
$closed=trim($linea[4]);
$l=explode('^^',$linea[1]);
// se obtiene la información correspondiente a los objetos ya actualizados para evitar la duplicación  (campo 500 de purchaseorder)
print $linea[0];
if ($closed!=""){	print "<font color=darkred size=+2><strong>".$msgstr["orderclosed"]."</strong></font>";}else{
	echo "<br><font class=\"textEntry\"><b>".$msgstr["date_receival"].": </b>".$arrHttp["date"]."</font>"  ;
}
echo "<table cellspacing=4  border=0 class=statTable>";

echo "<tr><th width=610>".$msgstr["item"]."</th><th width=90 align=center nowrap>".$msgstr["approved"]."</th><th>".$msgstr["copiesrec"]."</th><th width=90 align=center>".$msgstr["price"]."</th><th width=100 align=center>".$msgstr["copies_no"]."</th><th width=100 align=center>".$msgstr["suggestions"]."</th><th width=100 align=center>".$msgstr["bidding"]."</th><th width=100 align=center>".$msgstr["database"]."</th><th width=100 align=center>".$msgstr["typeofacq"]."</th><th width=100 align=center>".$msgstr["objectid"]."</th>";
$ix=0;
foreach ($l as $val) {
	$val=trim($val);
	if (trim($val)!=""){		$ix=$ix+1;
		$cell=explode('|',$val);
		if (isset($cell[5]) and trim($cell[5])!="") {			LeerFst($cell[5]);		}
		echo "\n<form name=frm$ix method=post action=receive_order_update.php>\n";
		echo "<input type=hidden name=Mfn_order value=$Mfn_order>\n";
		echo "<input type=hidden name=date value=".$arrHttp["date"].">\n";
		echo "<input type=hidden name=isodate value=".$arrHttp["isodate"].">\n";
		echo "<input type=hidden name=order value=".$cell[8].">\n";
		echo "<input type=hidden name=provider value=\"".$provider."\">\n";
		echo "<tr><td>".$cell[0]."</td>\n";
		echo "<td align=center>".$cell[1]."</td>\n";
		echo "<td align=center>".$cell[10]."</td>\n";
		echo "<input type=hidden name=occ value=$ix>\n";
		echo "<input type=hidden name=copies_req value=".$cell[1].">\n";
		echo "<td align=center>".$cell[2]."</td>\n";
		echo "<input type=hidden name=price value=".$cell[2].">\n";
		echo "<input type=hidden name=tome value=".$cell[9].">\n";
		echo "<input type=hidden name=volume value=".$cell[10].">\n";
		$cond=explode('|',$linea[5]) ;
		echo "<input type=hidden name=institucion value=".$cond[0].">\n";
		echo "<input type=hidden name=canjeadopor value=".$cond[1].">\n";
		echo "<input type=hidden name=condiciones value=".$cond[2].">\n";
		echo "<input type=hidden name=acqtype value=".$linea[6].">\n";
		echo "<td align=center>";
		echo "<input type=text name=received size=2 value=\"\">";
		echo "</td>";
		echo "<td align=center><input type=hidden name=suggestion size=5 value=".$cell[3].">".$cell[3]."</td>\n";
		echo "<td align=center><input type=hidden name=bidding size=5 value=".$cell[4].">".$cell[4]."</td>\n";
		echo "<td align=center><select name=database>" ;
		$fp=file($db_path."acquisitions.dat");
		foreach ($fp as $bd){
			if (trim($bd)!="")  {
				$b=explode('|',$bd);
				$xselected="" ;
				if (strtolower($b[0])==strtolower($cell[5])) $xselected=" selected";
				echo "<option value=".$b[0]." $xselected>".$b[1]."\n";
			}
		}
		echo "</select>\n";
		echo "</td><td align=center><select name=typeofobj>";
		$fp=file($db_path."suggestions/def/".$lang."/typeacquisition.tab");
		if ((int)$cell[7]!=0) $cell[6]="C";
		foreach ($fp as $value){			$ta=explode("|",$value);
			$selected="";			echo "<option value=".$ta[0];
			if ($cell[6]==$ta[0]) $selected= " selected";
			echo "$selected>".$ta[1];		}
		echo "</select></td>\n";
		$ref="";
		if (isset($obj_rec[$cell[3]][$cell[4]]["posts"])){
			$cell[7]= $obj_rec[$cell[3]][$cell[4]]["ctln"];
			if ($obj_rec[$cell[3]][$cell[4]]["posts"]>0)
				$ref= "<a href=../dataentry/show.php?base=biblo&Expresion=$pref_ctl".$cell[7]." target=_new>";
		}
		echo "<td align=center>";
		echo "<input type=hidden name=objectid value=\"".$cell[7]."\">";
		echo $cell[7]."</td>\n";
		if ((int)$cell[10]<(int)$cell[1])			if ($closed=="")
				echo "<td align=center><a href=javascript:Update($ix)>".$msgstr["update"]."</a></td>";
		echo "</form>\n";
	}};
echo "</table>";
if ($closed==""){
	echo "<form name=close action=close_order.php>\n";
	echo "<input type=submit value=\"Close order\">\n";
	echo "<input type=hidden name=order value=".$arrHttp["searchExpr"].">\n";
	echo "<input type=hidden name=Mfn_order value=$Mfn_order>\n";
}
echo "</form>" ;
echo "</div></div>";
include("../common/footer.php");
echo "</body></html>";
die;

//==============================================================================================

function LeerFst($base){
global $tag_ctl,$pref_ctl,$arrHttp,$db_path,$AI,$lang_db,$msgstr,$error;
// GET THE FST TO FIND THE CONTROL NUMBER OF A BIBLIOGRAPHIC DATABASE
	$archivo=$db_path.$base."/data/".$base.".fst";
	if (!file_exists($archivo)){
		echo "missing file ".$base."/data/".$base.".fst";
		die;
	}
	$fp=file($archivo);
	$tag_ctl="";
	$pref_ctl="CN_";
	foreach ($fp as $linea){
		$linea=trim($linea);
		$ix=strpos($linea,"\"CN_\"");
		if ($ix===false){
			$ix=strpos($linea,'|CN_|');
		}
		if ($ix===false){
		}else{
			$ix=strpos($linea," ");
			$tag_ctl=trim(substr($linea,0,$ix));
			break;
		}
	}
	// Si no se ha definido el tag para el número de control en la fdt, se produce un error
	if ($tag_ctl==""){
		echo "<h2>".$msgstr["missingctl"]."</h2>";
		die;
	}
}


function LeerFdt($base){global $tag_ctl,$pref_ctl,$arrHttp,$db_path;
// se lee la FDT para conseguir la etiqueta del campo donde se coloca la numeración automática y el prefijo con el cual se indiza el número de control
    return;
	$archivo=$db_path.$base."/def/".$_SESSION["lang"]."/".$base.".fdt";
	if (file_exists($archivo)){
		$fp=file($archivo);
	}else{
		$archivo=$db_path.$base."/def/".$lang_db."/".$base.".fdt";
		if (file_exists($archivo)){
			$fp=file($archivo);
		}else{
			echo "missing file ".$base."/".$base.".fdt";
		    die;
		 }
	}
	$tag_ctl="";
	$pref_ctl="";
	foreach ($fp as $linea){
		$l=explode('|',$linea);
		if ($l[0]=="AI"){
			$tag_ctl=$l[1];
			$pref_ctl=$l[12];
		}
	}
	// Si no se ha definido el tag para el número de control en la fdt, se produce un error
	if ($tag_ctl=="" or $pref_ctl==""){
		echo "<h2>".$msgstr["missingctl"]."</h2>";
		die;
	}}

?>