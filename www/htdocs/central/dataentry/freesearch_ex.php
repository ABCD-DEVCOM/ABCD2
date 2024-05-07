<?php
/*
20220713 fho4abcd Use $actparfolder as location for .par files
20220716 fho4abcd div-helper, remove unused functions, improve html
20240507 fho4abcd Remove bugs, improve counters, add show button, layout, code cleanup
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

function GenerarSalida($Mfn,$numshown,$total,$Pft){
	/*
	** This function shows the output for one selected record.
	*/
	global $arrHttp,$xWxis,$db_path,$actparfolder,$msgstr;
	$query="&base=".$arrHttp["base"]."&cipar=$db_path".$actparfolder.$arrHttp["cipar"]."&Mfn=$Mfn&count=1";
  	if ($Pft=="") $Pft=$arrHttp["search"].'#';
	$query.="&Formato=".urlencode($Pft.'/')."&Opcion=rango";
	$contenido="";
	$IsisScript=$xWxis."act_tabla.xis";
	include("../common/wxis_llamar.php");// sets $contenido
	foreach ($contenido as $value){
		if (trim($value)=="") continue;
		$val=explode('|',$value);
   		$value=$val[0];
   		$value=explode('$$',$value);
   		if ($arrHttp["tipob"]=="pft" and trim($val[2])!=""){
			$numshown++;
			$Mfn=$val[1];
           	echo "<tr>";
			echo "<td>".$numshown."/".$total."</td>";
			echo "<td>".$val[1]."</td>";
			echo "<td>";
			echo $val[2];
			echo "</td>";
	   		ShowActionBox($Mfn);
   		}else{
	   		if (stristr($val[2],$arrHttp["search"])!==false){
				$numshown++;
	   			$vv=explode('____$$$',$val[2]);
				$Mfn=$val[1];
	   			echo "<tr>";
				echo "<td>".$numshown."/".$total."</td>";
	   			echo "<td>".$Mfn."</td><td>";
				$numrecresults=0;
				$cont="";
	   			foreach ($vv as $conseguido) {
	   				$ixc=stripos($conseguido,$arrHttp["search"]);
	   				if ($ixc!==false){
						if ( $numrecresults>0) $cont.="<br>";
						$numrecresults++;
						$ixter=strlen($arrHttp["search"]);
	   					$cont.=substr($conseguido,0,$ixc)."<font color=red>".substr($conseguido,$ixc,$ixter)."</font>".substr($conseguido,$ixter+$ixc);
	   				}
				}
				echo $cont;
				echo "</td>";
				ShowActionBox($Mfn);
    		}
		}
	}
	return $numshown;
}
function ShowActionBox($Mfn){
	/*
	** Shows the tablecell with actions (selectmarker and show button)
	*/
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

//foreach ($arrHttp as $val=>$value) echo "$val=$value<br>";

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
	border: 1px solid black;
	border-collapse:collapse;
}
table.tabborder td {
	border: 1px solid black;
}
</style>

<div class="sectionInfo">
	<div class="breadcrumb">
	<?php echo $msgstr["m_busquedalibre"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
		<?php $backtoscript="freesearch.php?tipob=".$arrHttp["tipob"];
		if (isset($arrHttp["from"])) $backtoscript.="&from=".$arrHttp["from"];
		if (isset($arrHttp["to"])) $backtoscript.="&to=".$arrHttp["to"];
		if (isset($arrHttp["seleccionados"])) $backtoscript.="&seleccionados=".$arrHttp["seleccionados"];
		if (isset($arrHttp["Expresion"])) $backtoscript.="&Expresion=".urlencode($arrHttp["Expresion"]);
		if (isset($arrHttp["search"])){
			$arrHttp["search"]=urldecode($arrHttp["search"]);
			$backtoscript.="&search=".urlencode($arrHttp["search"]);
		}
		if (isset($arrHttp["count"])) $backtoscript.="&count=".urlencode($arrHttp["count"]);
		if (isset($arrHttp["fields"])) $backtoscript.="&fields=".urlencode($arrHttp["fields"]);
		include "../common/inc_back.php";
		?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php $ayuda="freesearch.html";include "../common/inc_div-helper.php" ?>
<div class="middle form">
<div class="formContent">
<?php

$base =$arrHttp["base"];
$cipar =$arrHttp["cipar"];
//foreach ($arrHttp as $key => $value) echo "$key = $value <br>";//die;
// se lee el archivo mm.fdt
if (!isset($_SESSION["login"])){
  	echo $msgstr["menu_noau"];
  	die;
}
$Fdt=LeerFdt($base);
$Pft="";
if ( $arrHttp["tipob"]=="string"){
	// Convert the fields into a PFT
	$t=explode(';',$arrHttp["fields"]);
	foreach ($t as $value){
		if (trim($value)!="" and trim($value)!="ALL"){
			$Pft.="(if p(v".$value.") then '".$value."= 'v".$value."'____$$$' fi),";
		}
	}
} else {
	$arrHttp["fields"]="";
}
$Pft=str_replace('/','<br>',$Pft);
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
if (isset($arrHttp["numshown"]))	$numshown=$arrHttp["numshown"];
$execmode="";
?>
<div align=center>
<div style="border-style:solid;border-width:2px; text-align:left;">
<table>
	<?php
	if (isset($arrHttp["from"])){
		$execmode="Range";
		?>
		<tr><td><?php echo $msgstr["freesearch_range"]?></td><td>:</td>
			<td><?php echo $msgstr["cg_from"].": ".$arrHttp["from"]." &nbsp; &nbsp; ".$msgstr["cg_to"].": ".$arrHttp["to"];?></td>
		</tr>
		<?php
	}
	if (isset($arrHttp["seleccionados"])){
		$execmode="Selected";
		?>
		<tr><td><?php echo $msgstr["freesearch_selec"]?></td><td>:</td>
			<td><?php echo $arrHttp["seleccionados"];?></td>
		</tr>
		<?php
	}
	if (isset($arrHttp["Expresion"])){
		$execmode="Search";
		?>
		<tr><td><?php echo $msgstr["cg_search"]?></td>
			<td>:</td><td><?php echo $arrHttp["Expresion"];?></td>
		</tr>
		<?php
	}
	$locsearch=$arrHttp["search"];
	if ($arrHttp["tipob"]=="pft"){
		$locsearch=htmlspecialchars($locsearch);
		?>
		<tr><td><b><?php echo $msgstr["freesearch_6"]?></b></td><td>:</td><td><b><?php echo $locsearch;?></b></td>
		<?php
	} else {
		?>
		<tr><td><b><?php echo $msgstr["freesearch_5"]?></b></td><td>:</td><td><b><?php echo $locsearch;?></b></td>
		<?php
	}
	if (isset($arrHttp["fields"]) && $arrHttp["fields"]!=""){
		?>
		<tr><td><?php echo $msgstr["freesearch_fields"]?></td><td>:</td><td><?php echo $arrHttp["fields"];?></td>
		<?php
	}
	?>
</table>
</div></div>
<?php
$arr_mfn=array();
$sel_mfn=array();
if (isset($arrHttp["seleccionados"])){
	$Mfn=explode(',',$arrHttp["seleccionados"]);
	foreach ($Mfn as $m){
		$m=trim($m);
		if ($m!="" and is_numeric($m) and $m>0)
			$sel_mfn[$m]=$m;
	}
}
if ($execmode=="Search"||$execmode=="Range"){
	$total=0;
	$query="&base=".$arrHttp["base"]."&cipar=$db_path".$actparfolder.$arrHttp["cipar"];
  	if ($Pft=="") $Pft=$arrHttp["search"].'#';
	$query.="&Formato=".urlencode($Pft.'/');
	if ($execmode=="Search") {
		$query.="&Expresion=".urlencode(stripslashes($arrHttp["Expresion"]))."&Opcion=buscar";
		$query.="&from=$startofset&Mfn=$startofset&count=$count";
	} else {
		$total=$arrHttp["to"]-$arrHttp["from"]+1;
		$Mfn=$arrHttp["from"];
		if (isset($arrHttp["nextrec"])) $Mfn=$Mfn+$arrHttp["nextrec"]-1;
		$curcount=$count;
		if (($arrHttp["to"]-$Mfn)<$curcount) $curcount=$arrHttp["to"]-$Mfn+1;
		$query.="&Mfn=$Mfn&count=$curcount"."&Opcion=rango";
	}
	$IsisScript=$xWxis."act_tabla.xis";
	include("../common/wxis_llamar.php");
	$ix=0;
	foreach ($contenido as $value){
		if (trim($value)!="") {
			$ix++;
			/* returned format example:
				$$POSICION:1$$5883     |33024|150= Anke____$$$190= Het____$$$ 
			*/
			$val=explode('|',$value);
			$pos=explode('$$',$val[0]);
			if ($execmode=="Search") $total=$pos[2];
			$cont="";
			if ($arrHttp["tipob"]=="string"){
            	if (stristr($val[2],$arrHttp["search"])!==false){
		   			$vv=explode('____$$$',$val[2]);
					$numrecresults=0;
		   			foreach ($vv as $conseguido) {
						$ixc=stripos($conseguido,$arrHttp["search"]);
						if ($ixc!==false){
							if ( $numrecresults>0) $cont.="<br>";
							$numrecresults++;
							$ixter=strlen($arrHttp["search"]);
							$cont.=substr($conseguido,0,$ixc)."<font color=red>".substr($conseguido,$ixc,$ixter)."</font>".substr($conseguido,$ixter+$ixc);
						}
					}
				}
			}
			if ($arrHttp["tipob"]=="pft" or $cont!=""){
				if (isset($val[1])){
					if (!isset($arr_msg[$val[1]])){
						if (isset($val[2]) and trim($val[2])!=""){
							$arr_mfn[$val[1]]=$val[1];
							$arr_msg[$val[1]]=$val[2];
							if ($cont!="") $arr_msg[$val[1]]=$cont;
						}
					}else{
						$arr_mfn[$val[1]]=$val[1];
						$arr_msg[$val[1]]=$cont;
					}
				}
			}
		}
	}
}
else {
	//se construye el rango de Mfn's a procesar
	$Mfn=explode(',',$arrHttp["seleccionados"]);
	foreach ($Mfn as $m){
		$m=trim($m);
		if ($m!="" and is_numeric($m) and $m>0)
			$arr_mfn[$m]=$m;
	}
	$total=count($arr_mfn);
}
?>
<div style="text-align:center">
<?php
echo $msgstr["freesearch_found"]." ";
if ($execmode=="Search") echo $msgstr["cg_search"];
if ($execmode=="Range") echo $msgstr["freesearch_range"];
if ($execmode=="Selected") echo $msgstr["freesearch_selec"];
echo " = ".$total;

?>
</div>
<?php
if ($total!=0) { /* display the result table only if any record is found*/
?>
<div align=center >
<form name=tabla>
<table  cellspacing=1 cellpadding=5 class=tabborder>
	<tr><td></td>
		<td>Mfn</td>
		<td></td>
		<td><input type=checkbox name=chkall onclick=CheckAll() title="<?php echo $msgstr["selected_records_add"]?>"></td>
	</tr>
	<?php
	if ($execmode=="Search" || $execmode=="Range"){
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
	}else{
		$numshown=0;
		foreach ($arr_mfn as $Mfn){
			$numshown=GenerarSalida($Mfn,$numshown,$total,$Pft);
		}
	}
	?>
</table>
<?php
foreach ($arrHttp as $var=>$value){
	if ($var!="nextrec" && $var!="count" ){
		if ($var=="Expresion") $value=htmlentities($value);
		if ($var=="search") $value=urlencode($value);
		echo "<input type=hidden name=$var value=\"$value\">\n";
	}
}
if ($execmode=="Search" || $execmode=="Range"){
	$hasta=$startofset+$count;
	if ($hasta>$total){
		$hasta=1;
		$numshown=0;
	}
	?><br>
        <?php echo $msgstr["cg_nxtr"]?>
        <input type=text size=5 name=nextrec value='<?php echo $hasta?>'>&nbsp;
        <?php echo $msgstr["cg_read"]?>&nbsp;
        <input type=text size=5 name=count value='<?php echo $count?>'>
        <?php echo $msgstr["cg_morer"]?>&nbsp; &nbsp; &nbsp;
		<a href="javascript:EnviarForma()" class="bt bt-green">
			 <i class="fas fa-search"></i> &nbsp; <?php echo $msgstr["cg_execute"]?>
		</a>
	<?php
}
?>
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
<?php include("../common/footer.php")?>
