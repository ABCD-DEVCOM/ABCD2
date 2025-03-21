<?php
/* Modifications
2021-03-03 fho4abcd Replaced helper code fragment by included file
2021-03-03 fho4abcd Conformance:moved <body>, deleted <td> replaced <center>,...
2024-05-07 fho4abcd Improved user interface &layout, code cleanup
2024-05-11 fho4abcd Added sort option, added options to save&recall form parameters
2024-05-23 fho4abcd Save parameters controlled by profile,allow PFT and search fields,Add directives for result
2024-05-26 fho4abcd Sort only on fields without subfields, move use parameterset to top.
2024-05-28 fho4abcd Add reverse sort option
2024-06-06 fho4abcd Layout+texts. Allow field selection without marking
2025-02-06 fho4abcd Button Delete parameterset:red
*/
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");



include ("../lang/soporte.php");
include ("../lang/admin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=".htmlspecialchars($value)."<br>";//die;

$base =$arrHttp["base"];
include("freesearch_save_inc.php");
$Savparam_arr=array();
Freesearch_table_file("Read",$Savparam_arr);

include("leer_fdt.php");
$Fdt_unsorted=LeerFdt($base);
$Fdt=array();
foreach ($Fdt_unsorted as $value){
	$f=explode('|',$value);
	$Fdt[$f[1]]=$value;
}
ksort($Fdt);

if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!=""){
	$Expresion=stripslashes($arrHttp["Expresion"]);
}else{
  	$Expresion="";
}
if (isset($arrHttp["from"])){
	$displayrange="";
} else {
	$displayrange="none";
}
include("../common/header.php");
?>
<body>
<script src="js/lr_trim.js"></script>
<script>
function EnviarForma(){
	document.forma1.from.value         =Trim(document.forma1.from.value)
	document.forma1.to.value           =Trim(document.forma1.to.value)
	document.forma1.Expresion.value    =Trim(document.forma1.Expresion.value)
	document.forma1.search.value       =Trim(document.forma1.search.value)
	document.forma1.seleccionados.value=Trim(document.forma1.seleccionados.value)
	onemethod="<?php echo $msgstr["freesearch_norec"]." '".$msgstr["r_recsel"]."'"?>"
	if (document.forma1.from.value=="" && document.forma1.to.value==""
		&& document.forma1.Expresion.value=="" && document.forma1.seleccionados.value=="") {
		alert(onemethod)
		return
	}
    if ((document.forma1.from.value=="" || document.forma1.to.value=="") && document.forma1.Expresion.value=="" && document.forma1.seleccionados.value==""){
		alert(onemethod);
		return
	}
	if ((document.forma1.from.value!="" || document.forma1.to.value!="") && document.forma1.Expresion.value!=""){
		alert(onemethod);
		return
	}
	if ((document.forma1.from.value!="" || document.forma1.to.value!="") && document.forma1.seleccionados.value!=""){
		alert(onemethod);
		return
	}
	if (document.forma1.seleccionados.value!="" && document.forma1.Expresion.value!=""){
		alert(onemethod);
		return
	}
	if (document.forma1.from.value!="" || document.forma1.to.value!="") {
		if (document.forma1.from.value=="" || document.forma1.to.value==""){
			alert(onemethod);
			return
		}
		if (document.forma1.to.value>top.maxmfn || document.forma1.from.value>top.maxmfn || document.forma1.to.value<=0
		    || document.forma1.from.value<=0 ||  document.forma1.from.value>document.forma1.to.value ){
			alert("<?php echo $msgstr["cg_rango"].": ".$msgstr["numfr"]?>");
			return
		}
		var maxrange=20000 /* value found by try&error. seems reasonable*/
		var actrange=document.forma1.to.value-document.forma1.from.value+1
		if (actrange>maxrange ){
			alert("<?php echo $msgstr["cg_rango"].": "?>"+actrange+"\n"+
					"<?php echo $msgstr["freesearch_maxrange"].": "?>"+maxrange);
			return
		}
	}
	mark=""
	if (document.forma1.search.value!="") mark="set"
	fields=""
	for (i=0;i<document.forma1.free_C.options.length;i++){
		if (document.forma1.free_C.options[i].selected){
			tag=document.forma1.free_C.options[i].value
			t=tag.split('|')
			fields=fields+t[0]+";"
		}
	} 
	document.forma1.fields.value=fields

	if (fields=="" && mark=="set") {
		alert("<?php echo $msgstr["freesearch_selmrk"]?>")
		return
	}
	if (document.forma1.fields.value=="" && document.forma1.pftstr.value==""){
		alert("<?php echo $msgstr["freesearch_nodis"]?>")
		return
	}
	if (mark!="set"){
		document.forma1.omitrec.value=""
		document.forma1.omitfld.value=""
	}
	if (document.forma1.sorttag.value=="" )document.forma1.sortdir.value=""
	document.forma1.target=""
	document.forma1.action='freesearch_ex.php'
	document.forma1.submit()
}

function Buscar(){
	base=document.forma1.base.value
	cipar=document.forma1.cipar.value
	ix=top.menu.document.forma1.formato.selectedIndex
	if (ix==-1) ix=0
	Formato=top.menu.document.forma1.formato.options[ix].value
	FormatoActual="&Formato="+Formato
	Opcion="rango"
	Url="buscar.php?Opcion=formab&prologo=prologoact&Tabla=cGlobal&Target=s&base="+base+"&cipar="+cipar+FormatoActual
	msgwin=window.open(Url,"FREE","menu=no,resizable=yes, scrollbars=yes")
	msgwin.focus()
}
function ClearSelectField(){
	document.forma1.seleccionados.value=""
}
function EraseSelection(){
	document.forma1.seleccionados.value=""
	if(top.RegistrosSeleccionados=="") {
		alert("<?php echo $msgstr["freesearch_nomfn"];?>");
	} else {
		top.RegistrosSeleccionados=""
		alert("<?php echo $msgstr["freesearch_mfncleared"];?>");
	}
	var item=top.menu.toolbar.getItem('browseby');
	item.selElement.options[0].selected =true
	top.browseby="mfn"
}
function DelSavParams(){
	if (document.forma1.SavParams.length<=1){
		alert("<?php echo $msgstr["freesearch_nopar"]?>")
		return
	}
	document.delsavparams.target="savefreesearch"
	var winl = (screen.width-300)/2;
	var wint = (screen.height-200)/2;
	msgwin=window.open("","savefreesearch","menu=no,status=yes,width=600, height=400,left="+winl+",top="+wint)
	msgwin.focus()
	document.delsavparams.submit()
}
function LoadSavParams(){
	for (i=0;i<document.forma1.SavParams.options.length;i++){
		if (document.forma1.SavParams.options[i].selected){
			tag=document.forma1.SavParams.options[i].value
		}
	}
	if(tag!="") {
		var myurl=window.origin+window.location.pathname+"?"+tag
		if(top.RegistrosSeleccionados!="") myurl=myurl+"&seleccionados="+top.RegistrosSeleccionados
		window.open(myurl,'_self');
	}
}
function SaveSavParams(){
	fields=""
		for (i=0;i<document.forma1.free_C.options.length;i++){
			if (document.forma1.free_C.options[i].selected){
				tag=document.forma1.free_C.options[i].value
				t=tag.split('|')
				fields=fields+t[0]+";"
			}
		}

	document.forma1.fields.value=fields

	document.forma1.action='freesearch_save.php'
	document.forma1.target="savefreesearch"
	var winl = (screen.width-300)/2;
	var wint = (screen.height-200)/2;
	msgwin=window.open("","savefreesearch","menu=no,status=yes,width=600, height=400,left="+winl+",top="+wint)
	msgwin.focus()
	document.forma1.submit()
}

function Togglerange() {
    var hiddenRow= document.getElementById('rangerow');
	if (hiddenRow.style.display === "none") {
      hiddenRow.style.display = "";
    } else {
      hiddenRow.style.display = "none";
    }
};
</script>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["freesearch_title"]?>
	</div>
	<div class="actions">
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php $wiki_help="B%C3%BAsquedas#B.C3.BAsqueda_Libre";
      include "../common/inc_div-helper.php"
?>
<div class="middle form">
<div class="formContent">
<div align=center>

<form name=forma1 method=post><!--action and target set by javascript-->
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value="<?php echo $arrHttp["base"]?>.par">
<input type=hidden name=fields>
<table style="border-spacing:3px;padding-left:2px;padding-right:2px">
	<?php if (sizeof($Savparam_arr)>0){ // Show the saved parameters dropbox ?>
	<tr>
		<td><?php echo $msgstr["freesearch_use"]?>&nbsp;</td>
		<td colspan=2>
			<select name=SavParams size=1 onchange="javascript:LoadSavParams()">
				<option></option>
				<?php
				foreach($Savparam_arr as $value){
					$savarr=explode('|',$value);
					?><option value="<?php echo $savarr[1]?>"> <?php echo $savarr[0]?></option>
					<?php
				}
				?>
			</select>
		</td>
	</tr>
	<?php } ?>
	<tr>
	<td style="text-align:center;background-color:#cccccc" colspan=4><?php echo $msgstr["r_recsel"]?> </td>
	<tr>
		<td>
			<a href=javascript:Buscar()>
			<img src=img/barSearch.png height=24 align=middle border=0><?php echo $msgstr["cg_search"]?></a>
		</td>
		<td colspan=3><?php echo $msgstr["expresion"]?><br>
		<textarea rows=1 cols=80 name=Expresion><?php if (isset($arrHttp["Expresion"])){ echo $Expresion;}?></textarea>
		</td>
	</tr>
	<?php
	if (isset($arrHttp["seleccionados"]) &&
		$arrHttp["seleccionados"]!="" && $arrHttp["seleccionados"]!="__" && $arrHttp["seleccionados"]!="_"){
		?>
		<tr>
			<td></td>
			<td style="text-align:center;background-color:#cccccc" colspan=3></td>
		</tr>
		<tr>
			<td><?php echo $msgstr["selected_records"]?>&nbsp;
				<?php if(isset($arrHttp["seloutdated"])) echo "<br><span style='color:red'>".$msgstr["freesearch_outof"]."!!</span>";?>
			</td>
			<td colspan=2>
				<?php
				$sel=str_replace("__",",",trim($arrHttp["seleccionados"]));
				$sel=str_replace("_","",$sel);
				$sel=ltrim($sel,",");
				?>
				<textarea rows=2 cols=40 name=seleccionados readonly
					title="<?php echo $msgstr["freesearch_ro"]?>"><?php echo $sel?> </textarea>
			</td>
			<td style="text-align:right">
				<a href="javascript:ClearSelectField()" class="bt bt-gray">
					<i class="fas fa-times bt-gray"></i> &nbsp; <?php echo $msgstr["freesearch_clear"]?>
				</a>&nbsp;
				<a href="javascript:EraseSelection()" class="bt bt-red">
				<i class="fas fa-trash-alt bt-red"></i> &nbsp; <?php echo $msgstr["undo_selected"]?></td>
			</a>
			</td>
		</tr>
		<?php
	} else {
		echo "<tr><td><input type=hidden name=seleccionados value=''></td></tr>";
	}
	?>
	<tr>
		<td></td>
		<td style="text-align:center;background-color:#cccccc;font-size:10px" colspan=3>
		<a style="text-decoration:none" title="<?php echo $msgstr["freesearch_shrange"];?>" href="javascript:Togglerange()">
			<i class="fas fa-chevron-up"></i>&nbsp;  &nbsp; &nbsp;<i class="fas fa-chevron-down"></a></td>
	<tr>
	<tr id="rangerow" style="display:<?php echo $displayrange;?>">
		<td nowrap><?php echo $msgstr["cg_rango"]?>&nbsp;</td>
		<td><?php echo $msgstr["cg_from"]?>:
			<input type=text name=from size=10 value="<?php if(isset($arrHttp["from"])) echo $arrHttp["from"];?>">
			&nbsp; (>0)
		</td>
		<td colspan=2><?php echo $msgstr["cg_to"]?>:
			<input type=text name=to size=10 value="<?php if(isset($arrHttp["to"])) echo $arrHttp["to"];?>">
			<script> if (top.window.frames.length>0)
				document.writeln(" &nbsp; (<?php echo $msgstr["maxmfn"]?>: "+top.maxmfn+")")</script></td>
		<td></td>
	</tr>
	<tr>
		<td style="text-align:center;background-color:#cccccc" colspan=4><?php echo $msgstr["freesearch_4"]?></td>
	<tr>
		<td style="text-align:left;"><?php echo $msgstr["freesearch_sort"];?></td>
		<td>
			<select name=sorttag size=1>
				<?php
					$sorttag="";
					if (isset($arrHttp["sorttag"])) $sorttag=$arrHttp["sorttag"];
				?>
				<option value='' <?php if ($sorttag=="") echo "selected"?>></option>
				<?php
				foreach ($Fdt as $linea){
					$ischecked="";
					$t=explode('|',$linea);
					if ($t[1]==$sorttag) {$ischecked=" selected";}
					if ($t[5]=="") {
						/* Show only entries without subfields*/
						echo "<option value='".$t[1]."'".$ischecked.">".$t[2]." [".$t[1]."]";
						echo "</option>"."\n";
					}
				}
				?>
			</select>
		</td>
		<td><input type=checkbox name=sortdir value=On
			<?php if(isset($arrHttp["sortdir"])) echo "checked";?>> <?php echo $msgstr["freesearch_sortrev"]?>
		</td>
	</tr>
	<tr>
		<td style="text-align:left;"><?php echo $msgstr["freesearch_mrk"]?></td>
		<td colspan=3><input type=text name=search size=80
			value="<?php if (isset($arrHttp["search"])) echo $arrHttp["search"]?>">
	</tr>
	<tr>
		<td><?php echo $msgstr["freesearch_mrkact"]?></td>
		<td><input type=checkbox name=omitrec value=omitrec
			<?php if(isset($arrHttp["omitrec"])&&$arrHttp["omitrec"]=="omitrec") echo "checked";?>> <?php echo $msgstr["freesearch_omitrec"]?> </td>
		<td ><input type=checkbox name=omitfld value=omitfld
			<?php if(isset($arrHttp["omitfld"])&&$arrHttp["omitfld"]=="omitfld") echo "checked";?>> <?php echo $msgstr["freesearch_omitfld"]?> </td>
	</tr>
	<tr>
		<td style="text-align:center;background-color:#cccccc" colspan=4><?php echo $msgstr["freesearch_spcdisp"]?></td>
	</tr>
	<tr>
		<td style="text-align:left;"><?php echo $msgstr["freesearch_fieldsel"]?></td>
		<td colspan=3>
			<table>
			<tr>
				<td>
					<select name=free_C multiple size=10>
						<?php
						$ftag=array("notag");
						if (isset($arrHttp["fields"])){
							$ftag=explode(";",$arrHttp["fields"]);
						}
						foreach ($Fdt as $linea){
							$ischecked="";
							$t=explode('|',$linea);
							if (in_array($t[1],$ftag)) {$ischecked=" selected";}
							echo "<option value='".$t[1].'|'.$t[5].'|'.$t[6].'|'.$t[0]."'".$ischecked.">".$t[2]." [".$t[1]."]";
							if ($t[5]!="") echo " (".$t[5].")";
							echo "</option>"."\n";
						}
						?>
					</select>
				</td>
				<td>&nbsp;</td>
				<td>
					<span class="bt-disabled"><i class="fas fa-info-circle"></i> <?php echo $msgstr["freesearch_2"];?></span>
					<br><br>
					<?php echo $msgstr["freesearch_inst"]?><br>
					<input type=radio name=repeat_ind value="rep_M" 
						<?php if (isset($arrHttp["repeat_ind"]) && $arrHttp["repeat_ind"]=="rep_M" ||
									!isset($arrHttp["repeat_ind"])) echo "checked";?>>
						<?php echo $msgstr["freesearch_repm"];?><br>
					<input type=radio name=repeat_ind value="rep_S"
						<?php if (isset($arrHttp["repeat_ind"]) && $arrHttp["repeat_ind"]=="rep_S") echo "checked";?>>
						<?php echo $msgstr["freesearch_reps"];?><br>
					<br>
					<input type=radio name=title_ind value="tit_Title" 
						<?php if (isset($arrHttp["title_ind"]) && $arrHttp["title_ind"]=="tit_Title" ||
									!isset($arrHttp["title_ind"])) echo "checked";?>>
						<?php echo $msgstr["freesearch_tittit"];?><br>
					<input type=radio name=title_ind value="tit_Tag"
						<?php if (isset($arrHttp["title_ind"]) && $arrHttp["title_ind"]=="tit_Tag") echo "checked";?>>
						<?php echo $msgstr["freesearch_tittag"];?><br>
				</td>
			</tr>
			</table>
	</tr>
	<tr>
		<td style="text-align:left;"><?php echo $msgstr["freesearch_6"]?></td>
		<td colspan=3><textarea name=pftstr cols=80 rows=2><?php if (isset($arrHttp["pftstr"])) echo $arrHttp["pftstr"]?></textarea>
	</td>
	<tr>
		<td style="text-align:center;background-color:#cccccc;" colspan=4>&nbsp;</td>
	</tr>
	<tr>
		<td colspan=3>
			<?php
			if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_SAVEXPR"])){
			?>
			<a href="javascript:SaveSavParams()" class="bt bt-blue">
				<i class="far fa-save"></i> &nbsp; <?php echo $msgstr["freesearch_save"]?></a>
			<a href="javascript:DelSavParams()" class="bt bt-red"> &nbsp;
				<i class="fas fa-trash"></i> &nbsp; <?php echo $msgstr["freesearch_del"]?></a>
			<?php } ?>
		</td>
		<td style="text-align:right"><a href="javascript:EnviarForma()" class="bt bt-green">
		 <i class="fas fa-search"></i> &nbsp; <?php echo $msgstr["cg_execute"]?></a><br>
		</td>
</table>
</form>
<form name=delsavparams method=post action="freesearch_save.php">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value="<?php echo $arrHttp["base"]?>.par">
<input type=hidden name=Option value="delete">
</form>
</div>
</div>
</div>
<?php
include("../common/footer.php");
?>
