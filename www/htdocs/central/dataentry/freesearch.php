<?php
/* Modifications
2021-03-03 fho4abcd Replaced helper code fragment by included file
2021-03-03 fho4abcd Conformance:moved <body>, deleted <td> replaced <center>,...
2024-05-07 fho4abcd Improved user interface &layout, code cleanup
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
$cipar =$arrHttp["base"]."par";
include("leer_fdt.php");

$Fdt_unsorted=LeerFdt($base);
$Fdt=array();
foreach ($Fdt_unsorted as $value){
	$f=explode('|',$value);
	$Fdt[$f[1]]=$value;
}

ksort($Fdt);

if (isset($arrHttp["Expresion"]) and $arrHttp["Expresion"]!=""){
	$Opcion="buscar";
	$Expresion=stripslashes($arrHttp["Expresion"]);
}else{
  	$Opcion="rango";
  	$Expresion="";
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
	}
	buscar=""
	if (document.forma1.tipob[0].checked)
		buscar="valor"
	if (document.forma1.tipob[1].checked)
		buscar="pft"
	fields=""
	if (buscar=="valor"){
		for (i=0;i<document.forma1.free_C.options.length;i++){
			if (document.forma1.free_C.options[i].selected){
				tag=document.forma1.free_C.options[i].value
				t=tag.split('|')
				fields=fields+t[0]+";"
			}
		}

	}
	if (fields=="" && buscar=="valor") {
		alert("<?php echo $msgstr["freesearch_3"]?>")
		return
	}
	if (buscar==""){
		alert("<?php echo $msgstr["freesearch_psel"]." '".$msgstr["freesearch_4"]."'"?>")
		return
	}
	if (document.forma1.search.value==""){
		alert("<?php echo $msgstr["freesearch_nostr"]." '".$msgstr["freesearch_4"]."'"?>")
		return
	}
	document.forma1.fields.value=fields
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
</script>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["m_busquedalibre"].": ".$arrHttp["base"]?>
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

<form name=forma1 method=post action=freesearch_ex.php onsubmit="Javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=MaxMfn>
<input type=hidden name=fields>
<table style="border-spacing:3px;padding-left:2px;padding-right:2px">
	<tr>
	<td style="text-align:center;background-color:#cccccc" colspan=4><?php echo $msgstr["r_recsel"]?> </td>
	<tr>
		<td nowrap><?php echo $msgstr["cg_rango"]?> &rarr;&nbsp;</td>
		<td><?php echo $msgstr["cg_from"]?>:
			<input type=text name=from size=10 value=<?php if(isset($arrHttp["from"])) echo $arrHttp["from"];?>>
			&nbsp; (>0)
		</td>
		<td><?php echo $msgstr["cg_to"]?>:
			<input type=text name=to size=10 value=<?php if(isset($arrHttp["to"])) echo $arrHttp["to"];?>>
			<script> if (top.window.frames.length>0)
				document.writeln(" &nbsp; (<?php echo $msgstr["maxmfn"]?>: "+top.maxmfn+")")</script></td>
		<td></td>
	</tr>
	<?php
	if (isset($arrHttp["seleccionados"]) &&
		$arrHttp["seleccionados"]!="" && $arrHttp["seleccionados"]!="__" && $arrHttp["seleccionados"]!="_"){
		?>
		<tr><td colspan=4><hr></td>
		<tr>
			<td><?php echo $msgstr["selected_records"]?> &rarr;&nbsp;</td>
			<td colspan=2>
				<?php
				$sel=str_replace("__",",",trim($arrHttp["seleccionados"]));
				$sel=str_replace("_","",$sel);
				?>
				<textarea rows=1 cols=60 name=seleccionados readonly
					title="<?php echo $msgstr["freesearch_ro"]?>"><?php echo $sel?> </textarea>
			</td>
			<td><a href="javascript:ClearSelectField()" class="bt bt-gray">
				<i class="fas fa-trash-alt bt-gray"></i> &nbsp; <?php echo $msgstr["freesearch_clear"]?></td>
			</a>
			</td>
		</tr>
		<?php
	} else {
		echo "<tr><td><input type=hidden name=seleccionados value=''></td></tr>";
	}
	?>
	<tr><td colspan=4><hr></td>
	<tr>
		<td>
		<a href=javascript:Buscar()><img src=img/barSearch.png height=24 align=middle border=0><?php echo $msgstr["cg_search"]?> </a>
		 &rarr;&nbsp;
		</td>
		<td colspan=3><?php echo $msgstr["expresion"]?><br>
		<textarea rows=1 cols=80 name=Expresion><?php if (isset($arrHttp["Expresion"])){ echo $Expresion;}?></textarea>
		</td>
	<tr>
		<td style="text-align:center;background-color:#cccccc" colspan=4><?php echo $msgstr["freesearch_4"]?></td>
	<tr>
	<td style="text-align:left;">
		<input type=radio name=tipob value=string
			<?php if (isset($arrHttp["tipob"]) && $arrHttp["tipob"]=="string") echo "checked";?>> <?php echo $msgstr["freesearch_5"]?>
		<br><input type=radio name=tipob value=pft
			<?php if (isset($arrHttp["tipob"]) && $arrHttp["tipob"]=="pft") echo "checked";?>> <?php echo $msgstr["freesearch_6"]?>
	<td colspan=3><textarea name=search cols=80 rows=2><?php if (isset($arrHttp["search"])) echo $arrHttp["search"]?></textarea>
	</td>
	<tr>
		<td style="text-align:center;background-color:#cccccc" colspan=4><?php echo $msgstr["freesearch_fld4str"]?></td>
	</tr>
	<tr><td colspan=4>
			<table>
			<tr><td width=30%>
						<?php echo $msgstr["freesearch_2"]?>
				</td><td>&nbsp;</td>
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
			</tr>
			</table>
	</tr>
	<tr><td colspan=4 style="text-align:right"><a href="javascript:EnviarForma()" class="bt bt-green">
		 <i class="fas fa-search"></i> &nbsp; <?php echo $msgstr["cg_execute"]?></a>
		 </td>
	</tr>
</table>
</form>
</div>
</div>
</div>
<?php
include("../common/footer.php");
?>
