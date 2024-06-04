<?php
/*
20220713 fho4abcd Use $actparfolder as location for .par files
20220716 fho4abcd div-helper, remove unused functions, improve html
20240507 fho4abcd Remove bugs, improve counters, add show button, layout, code cleanup
20240511 fho4abcd Added sort option. Replaced act_tabla.xis by act_tabla_sort.xis.
20240523 fho4abcd Allow Search + PFT actions,improve search&display,several new options to control output
20240526 fho4abcd Typo. Added down button. Prepare for reverse sort
20240528 fho4abcd Add reverse sort option
20240604 fho4abcd Avoid display of empty/sparsely filled tables. Processing indicator
*/
session_start();
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
//foreach ($arrHttp as $var=>$value) echo "$var=".htmlspecialchars($value)."<br>";//die;

include("../lang/soporte.php");
include("../lang/admin.php");
include("leer_fdt.php");
set_time_limit(0);

function ShowActionBox($Mfn){
	/*
	** Shows the tablecell with actions (selectmarker and show button)
	*/
	global $msgstr;
	echo "<td nowrap>";
	echo "<input type=checkbox name=sel_mfn  value=".$Mfn." id=".$Mfn." onclick=SelecReg(this)>";
	?>
	<a href="javascript:Showrecord(<?php echo $Mfn;?>)" title="<?php echo $msgstr["freesearch_disp"]?>">
		 <i class="far fa-eye"></i>
	</a>
	</td>
	<script>
	var selecttop=top.main.document.getElementById(<?php echo $Mfn;?>);
	var checkvalue=top.SeleccionarRegistroCheck(<?php echo $Mfn;?>);
	if (checkvalue==true){
		selecttop.setAttribute("checked",true);
	}
	</script>
	<?php
}
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================
include ("../common/header.php");
?>
<body>
<script src="js/lr_trim.js"></script>
<script>
function CheckAll(){
	len=document.tabla.sel_mfn.length
	if (document.tabla.chkall.checked){
		for (i=0;i<len;i++){
			if (document.tabla.sel_mfn[i].checked==false){
				document.tabla.sel_mfn[i].checked=true
				top.SeleccionarRegistro(document.tabla.sel_mfn[i])
			}
		}
	}else{
		for (i=0;i<len;i++){
			if (document.tabla.sel_mfn[i].checked==true){
				document.tabla.sel_mfn[i].checked=false
				top.SeleccionarRegistro(document.tabla.sel_mfn[i])
			}
		}
	}
}

function SelecReg(Ctrl){
	top.SeleccionarRegistro(Ctrl)
}

function EnviarForma(){
	document.tabla.nextrec.value=Trim(document.tabla.nextrec.value)
	if (document.tabla.nextrec.value==""){
		alert("<?php echo $msgstr["freesearch_next"]?>")
		return
	}
	if (document.tabla.nextrec.value!="") {
		if (document.tabla.nextrec.value>top.maxmfn || document.tabla.nextrec.value<=0 ){
			alert("<?php echo $msgstr["numfr"]?>")
			return
		}
	}
	document.tabla.submit()
}
function Showrecord(mfn){
		document.showform.seleccionados.value=mfn;
		msgwin=window.open("","VistaPrevia"+mfn,"width=800,top=0,left=0,resizable, status, scrollbars")
		document.showform.target="VistaPrevia"+mfn
		msgwin.focus()
		msgwin.document.write('<title>fred</title>')
		document.showform.submit()
}
</script>
<style>
table.tabborder {
	border-collapse:collapse;
}
table.tabborder td {
	border: 1px solid LightGray;
}
table.noborder td{
	border: 0;
}
</style>

<div class="sectionInfo">
	<div class="breadcrumb">
	<?php echo $msgstr["m_busquedalibre"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
		<?php
		// The back to script parameters
		$locsearch="";
		$locpftstr="";
		$omitfld=false;
		$backtoscript="freesearch.php?";
		if (isset($arrHttp["omitrec"])){
			 $backtoscript.="omitrec=".$arrHttp["omitrec"];
			 $omitrec=true;
		} else {
			 $backtoscript.="omitrec=-";
			 $omitrec=false;
		}
		if (isset($arrHttp["omitfld"])) {
			$backtoscript.="&omitfld=".$arrHttp["omitfld"];
			$omitfld=true;
		}
		if (isset($arrHttp["from"])) $backtoscript.="&from=".$arrHttp["from"];
		if (isset($arrHttp["to"])) $backtoscript.="&to=".$arrHttp["to"];
		if (isset($arrHttp["seleccionados"])){
			$backtoscript.="&seleccionados=".$arrHttp["seleccionados"];
			$backtoscript.="&seloutdated=1";
		}
		if (isset($arrHttp["Expresion"])) $backtoscript.="&Expresion=".urlencode($arrHttp["Expresion"]);
		if (isset($arrHttp["search"])){
			$arrHttp["search"]=urldecode($arrHttp["search"]);
			$backtoscript.="&search=".urlencode($arrHttp["search"]);
			$locsearch=Trim($arrHttp["search"]);
		}
		if (isset($arrHttp["pftstr"])){
			$arrHttp["pftstr"]=urldecode($arrHttp["pftstr"]);
			$backtoscript.="&pftstr=".urlencode($arrHttp["pftstr"]);
			$locpftstr=Trim($arrHttp["pftstr"]);
		}
		if (isset($arrHttp["count"])) $backtoscript.="&count=".urlencode($arrHttp["count"]);
		if (isset($arrHttp["fields"])) $backtoscript.="&fields=".urlencode($arrHttp["fields"]);
		if (isset($arrHttp["repeat_ind"])) $backtoscript.="&repeat_ind=".$arrHttp["repeat_ind"];
		if (isset($arrHttp["title_ind"])) $backtoscript.="&title_ind=".$arrHttp["title_ind"];
		if (isset($arrHttp["sorttag"])) $backtoscript.="&sorttag=".urlencode($arrHttp["sorttag"]);
		if (isset($arrHttp["sortdir"])) $backtoscript.="&sortdir=".$arrHttp["sortdir"];
		include "../common/inc_back.php";
		?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php $ayuda="freesearch.html";include "../common/inc_div-helper.php" ?>
<div class="middle form">
<div class="formContent">
    <img  src="../dataentry/img/preloader.gif" alt="Loading..." id="preloader"
          style="visibility:hidden;position:absolute;top:30%;left:45%;border:2px solid;"/>
<?php

$base =$arrHttp["base"];
$cipar =$arrHttp["cipar"];
if (!isset($_SESSION["login"])){
  	echo $msgstr["menu_noau"];
  	die;
}
/*
** The FDT was used for field "ALL" (no longer shown)
** The FDT is used to have a translation table from Tags (=number) to Titles (=string)
*/
$Fdt=LeerFdt($base);
$fdttitles=Array();
foreach ($Fdt as $tag=>$linea){
	if (trim($linea)!=""){
		$t=explode('|',$linea);
		if ($t[0]!="S" and $t[0]!="H" and $t[0]!="L" and $t[0]!="LDR"){
			// Tag=t[1], Title=t[2]
			if ($t[1]!="" && $t[2]!="") $fdttitles[$t[1]]=$t[2];
		}
	}
}
/*
** Create a PFT for the selected search fields 
*/
$Pftsearch="";
if ( $locsearch!=""){
	// Convert the search fields into a PFT
	$t=explode(';',$arrHttp["fields"]);
	foreach ($t as $value){
		if (trim($value)!="" and trim($value)!="ALL"){
			if ($arrHttp["repeat_ind"]=="rep_S") {
				//(...)=repeatable group: Shows the value + ____$$$ for each occurrence
				$Pftsearch.="(if p(v".$value.") then '".$value."= 'v".$value."'____$$$' fi),";
			}else {
				// ...=standard: Shows values on one line separated by ;
				$Pftsearch.="if p(v".$value.") then '".$value."= 'v".$value."|; |'____$$$' fi,";
			}
		}
	}
}
//echo "<br>Pftsearch=".$Pftsearch."<br";
$Pftsearch=str_replace('/','<br>',$Pftsearch);
$IxMfn=0;
if (!isset($arrHttp["nextrec"])){
	$startofset=1;
}else{
	$startofset=$arrHttp["nextrec"];
}
if(!isset($arrHttp["count"])){
	if (isset($arrHttp["to"])){
		$count=$arrHttp["to"]-$arrHttp["from"]+1;
		if($count>50) $count=50;
		$arrHttp["count"]=$count;
	} else {
		$arrHttp["count"]=50;
	}
}
if (isset($arrHttp["to"]))		$total=$arrHttp["to"];
if (isset($arrHttp["total"]))	$total=$arrHttp["total"];
$count=$arrHttp["count"];
$numshown=0;
if (isset($arrHttp["numshown"]))$numshown=$arrHttp["numshown"];
$sorttag="";
$sortdir="";
if (isset($arrHttp["sorttag"]))	{
	$sorttag="&sortkey=v".$arrHttp["sorttag"];
	$sortdir="&sortdir=";
	if (isset($arrHttp["sortdir"]))$sortdir.="On";
}
$execmode="";
?>
<div align=center>
<div style="text-align:left;">
<table style="table-layout:fixed;margin-left:auto;margin-right:auto;width:100%;background-color:var(--abcd-gray-500)">
	<?php
	if (isset($arrHttp["from"])){
		$execmode="Range";
		?>
		<tr><td style="width:120px"><?php echo $msgstr["freesearch_range"]?></td><td style="width:10px">:</td>
			<td><?php echo $msgstr["cg_from"].": ".$arrHttp["from"]." &nbsp; &nbsp; ".$msgstr["cg_to"].": ".$arrHttp["to"];?></td>
		</tr>
		<?php
	}
	if (isset($arrHttp["seleccionados"])){
		$execmode="Selected";
		?>
		<tr><td style="width:120px"><?php echo $msgstr["freesearch_selec"]?></td><td style="width:10px">:</td>
			<td style="word-break: break-word;"><?php echo $arrHttp["seleccionados"];?></td>
		</tr>
		<?php
	}
	if (isset($arrHttp["Expresion"])){
		$execmode="Search";
		?>
		<tr><td style="width:120px"><?php echo $msgstr["cg_search"]?></td><td style="width:10px">:</td>
			<td style="word-break: break-word;"><?php echo $arrHttp["Expresion"];?></td>
		</tr>
		<?php
	}
	if (isset($arrHttp["sorttag"])) {
		?>
		<tr><td><?php echo $msgstr["freesearch_sort"]?></td><td style="width:10px">:</td>
			<td><?php
				$sorttitle=$arrHttp["sorttag"];
				$resultname=$sorttitle;
				if ( isset($fdttitles[$sorttitle])){
					// Convert the Tag number into the language dependent fdt Title
					$resultname=$fdttitles[$resultname]." [".$sorttitle."] ";
				}
				echo $resultname;
				if (isset($arrHttp["sortdir"])) echo "&nbsp; &nbsp; ".$msgstr["freesearch_sortrev"];
				?>
			</td>
		</tr>
		<?php
	}
	if ($locsearch!="") {
		$locsearch=htmlspecialchars($locsearch);
		?>
		<tr><td><b><?php echo $msgstr["freesearch_5"]?></b></td><td>:</td>
			<td style="word-break: break-word;"><b><?php echo $locsearch;?></b></td>
		<?php
	}
	if (isset($arrHttp["fields"]) && $arrHttp["fields"]!=""){
		?>
		<tr><td><?php echo $msgstr["freesearch_fields"]?></td><td>:</td>
			<td style="word-break: break-word;"><?php echo $arrHttp["fields"];?></td>
		<?php
	}
	if (isset($arrHttp["omitrec"]) || isset($arrHttp["omitfld"])){
		?>
		<tr><td><?php echo $msgstr["freesearch_fndact"]?></td><td>:</td>
			<td style="word-break: break-word;">
				<?php
				if (isset($arrHttp["omitrec"])) echo $msgstr["freesearch_omitrec"];
				if (isset($arrHttp["omitrec"]) && isset($arrHttp["omitfld"])) echo "&nbsp;+&nbsp;";
				if (isset($arrHttp["omitfld"])) echo $msgstr["freesearch_omitfld"];
				?>
			</td>
		<?php
	}
	if ($locpftstr!="") {
		$locpftstr=htmlspecialchars($locpftstr);
		?>
		<tr><td><b><?php echo $msgstr["freesearch_7"]?></b></td><td>:</td>
			<td style="word-break: break-word;"><b><?php echo $locpftstr;?></b></td>
		<?php
	}
	?>
</table>
</div></div>
<script>document.getElementById('preloader').style.visibility='visible'</script>
<?php
ob_flush();flush();
$total=0;
/*
** Creation of the full PFT with elements
**	- applied PFT
**	- search fields PFT
*/
$PftSepar="---$$";
$PftTotal="";
if (isset($arrHttp["pftstr"])&& $arrHttp["pftstr"]!="") {
	$PftTotal.=$arrHttp["pftstr"];
}
$PftTotal.="'".$PftSepar."'";
if ($Pftsearch!=""){
	$PftTotal.=$Pftsearch;
}
$PftTotal.="#";
if ($Pftsearch=="") $Pftsearch=$arrHttp["pftstr"].'#';
$arr_mfn=Array();
$arr_msg=Array();
$actualnumshown=0;
$stop_iteration="N";
/*
** Loop to find records to show
*/
while ($actualnumshown<$count && $stop_iteration=="N"){
	/*
	** Creation of the query for wxis_llamar
	*/
	$query="&base=".$arrHttp["base"]."&cipar=$db_path".$actparfolder.$arrHttp["cipar"];
	$query.="&Formato=".urlencode($PftTotal.'/');
	if ($execmode=="Search") {
		$endofset=$count+$startofset-1;
		$query.="&Expresion=".urlencode(stripslashes($arrHttp["Expresion"]))."&Opcion=buscar";
		$query.="&fromset=$startofset&toset=$endofset".$sorttag.$sortdir;
	} elseif ($execmode=="Range") {
		$total=$arrHttp["to"]-$arrHttp["from"]+1;
		$from=$arrHttp["from"];
		$to=$arrHttp["to"];
		$fromset=$startofset;
		$toset=$fromset+$count-1;
		if ($toset>$to) $toset=$to;
		$query.="&from=$from&to=$to"."&Opcion=rango";
		$query.="&fromset=$fromset&toset=$toset".$sorttag.$sortdir;
	} elseif ($execmode=="Selected") {
		$seleccion="";
		$mfn_sel=explode(',',$arrHttp["seleccionados"]);
		$total=sizeof($mfn_sel);
		foreach ($mfn_sel as $sel){
			if ($seleccion==""){
				$seleccion="'$sel'";
			}else{
				$seleccion.="/,'$sel'";
			}
		}
		$query.="&Opcion=seleccionados";
		$query.="&Mfn=$seleccion".$sorttag.$sortdir;
	} else {
		echo "programming error. die";
		die;
	}
	$IsisScript=$xWxis."act_tabla_sort.xis";
	include("../common/wxis_llamar.php");
	/*
	** Processing the results of the database query
	*/
	foreach ($contenido as $contenido_ar){
		if (trim($contenido_ar)!="") {
			/* 	returned format examples:
				$$POSICION:1$$5883     |33024|150= Anke____$$$190= Het____$$$
				$val format: $val[0]=$$POSICION:1$$5883
							 $val[1]=33024								==The MFN
							 $val[2]=150= Anke____$$$190= Het____$$$	==The complete search result
				$pos format: $pos[0]=empty
							 $pos[1]=??
							 $pos[2]=5883
				$$POSICION:1$$2|36017|---$$196= Sprln164; Nederland; Wiene; Goor; Delden; ____$$$
				$val format: $val[0]=$$POSICION:1$$2
							 $val[1]=36017								==The MFN
							 $val[2]=---$$196= Sprln164; Nederland; Wiene; Goor; Delden; ____$$$==The complete search result
			*/
			$val=explode('|',$contenido_ar);
			$pos=explode('$$',$val[0]);
			$res=explode($PftSepar,$val[2]);
			if ($execmode=="Search") $total=$pos[2];
			$cont="";
			$contentnum=0;
			$numsrcresults=0;
			/*
			** It may happen that $res[0] is set and $res[0]==""
			** This indicates that the required fields are not present in the database
			** We only process records with required fields
			*/
			if (isset($res[0]) && $res[0]!="" ){
				$cont.="<td>";
				$cont.=$res[0];
				$cont.="</td>";
				$contentnum++;
				$numsrcresults++;/* to ensure that this is seen if no search string will be handled*/
			}
			if (isset($res[1]) && trim($res[1])!=""){
				$cont.="<td>";
				$numsrcresults=0;
				$numsrcshown=0;
				$vv=explode('____$$$',$res[1]);
				foreach ($vv as $conseguido) {
					$resultlinear=explode("=",$conseguido,2);
					if (sizeof($resultlinear)==1) break;
					$resultname=$resultlinear[0];
					if ( $arrHttp["title_ind"]=="tit_Title" && isset($fdttitles[$resultname])){
						// Convert the Tag number into the language dependent fdt Title
						$resultname="<b>".$fdttitles[$resultname]."</b>";
					}
					$resultvalue=$resultlinear[1];
					$ixc=stripos($resultvalue,$arrHttp["search"]);
					if ($ixc!==false){
						if ( $numsrcshown>0) $cont.="<br>";
						$numsrcshown++;
						$numsrcresults++;
						$ixter=strlen($arrHttp["search"]);
						$cont.=$resultname.": ";
						$cont.=substr($resultvalue,0,$ixc)."<font color=red>".substr($resultvalue,$ixc,$ixter)."</font>".substr($resultvalue,$ixter+$ixc);
						$contentnum++;
					} else if (!$omitfld){
						if ( $numsrcshown>0) $cont.="<br>";
						$numsrcshown++;
						$contentnum++;
						$cont.=$resultname.": ".$resultvalue;
					}
				}
			}
			if ($contentnum>0 && ($numsrcresults>0||$omitrec==false)) {
				$arr_mfn[$val[1]]=$val[1];
				$arr_msg[$val[1]]="<table class='noborder'><tr>".$cont."</tr></table>";
				$actualnumshown++;
			}
			$startofset++;
		}
	}
	if ($startofset>=$total) $stop_iteration="Y";
}
?>
<div style="text-align:center">
	<script>document.getElementById('preloader').style.visibility='hidden'</script>
<?php
echo $msgstr["freesearch_found"]." ";
if ($execmode=="Search") echo $msgstr["cg_search"];
if ($execmode=="Range") echo $msgstr["freesearch_range"];
if ($execmode=="Selected") echo $msgstr["freesearch_selec"];
echo " = ".$total;
?>
</div>
<?php
/* Display the result table only if any record is found*/
if ($total!=0) {
?>
<div align=center >
<form name=tabla>
<table  cellspacing=1 cellpadding=5 class=tabborder>
	<tr style="background-color:LightGray"><td></td>
		<td>Mfn</td>
		<td></td>
		<td nowrap><input type=checkbox name=chkall onclick=CheckAll() title="<?php echo $msgstr["selected_records_add"]?>">
		<a class="bt bt-blue" href="#bottom"><i class="fa fa-arrow-down"></i></a></td>
	</tr>
	<?php
	if (count($arr_mfn)==0) {
		$showcount=min($count,$total);
		?>
		<tr><td colspan=4><?php echo $msgstr["freesearch_noloc"]." ".$showcount." ".$msgstr["registros"]?>
		</tr>
		<?php
	} else {
		foreach ($arr_mfn as $Mfn){
			$numshown++;
			?>
			<tr>
			<td><?php echo $numshown."/".$total?></td>
			<td><?php echo $Mfn?></td>
			<td ><?php echo $arr_msg[$Mfn]?></td>
			<?php
			ShowActionBox($Mfn);
		}
	}
	?>
</table>
<?php
foreach ($arrHttp as $var=>$value){
	if ($var!="nextrec" && $var!="count" ){
		if ($var=="Expresion") $value=htmlentities($value);
		if ($var=="search") $value=urlencode($value);
		if ($var=="pftstr") $value=urlencode($value);
		echo "<input type=hidden name=$var value=\"$value\">\n";
	}
}
?>
<br>
<div style='display:inline-block;float:left'>
	<?php include "../common/inc_back.php";?>
</div>
<?php
if ($execmode=="Search" || $execmode=="Range"){
	if ($startofset>$total){
		$startofset=1;
		$numshown=0;
	} else{
	?>
        <div style='display:inline-block'><?php echo $msgstr["cg_nxtr"]?>
        <input type=text size=5 name=nextrec value='<?php echo $startofset?>'>&nbsp;
        <input type=hidden name=count value='<?php echo $count?>'>
        &nbsp;<b>&#8649;</b>&nbsp;
		<a href="javascript:EnviarForma()" class="bt bt-green">
			 <i class="fas fa-search"></i> &nbsp; <?php echo $msgstr["cg_execute"]?>
		</a>
		</div>
	<?php
	}
}
?>
<div style='display:inline-block;float:right'>
<a class="bt bt-blue" href="#top"><i class="fa fa-arrow-up"></i></a>
</div>
<br>
<input type=hidden name=total value=<?php echo $total?>>
<input type=hidden name=numshown value=<?php echo $numshown?>>
</form>
<form name=showform method=post action=../dataentry/imprimir_g.php >
<input type=hidden name=base value=<?php echo $base?>>
<input type=hidden name=cipar value=<?php echo $cipar?>>
<input type=hidden name=fgen value=<?php echo $base?>>
<input type=hidden name=seleccionados value="">
<input type=hidden name=target value="">
</form>
</div>
<?php
}
?>
</div>
</div>
<div id="bottom"></div>
<?php include("../common/footer.php")?>
