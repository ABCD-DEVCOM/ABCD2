<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

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
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

$base =$arrHttp["base"];
$cipar =$arrHttp["base"]."par";
include("leer_fdt.php");

$Fdt_unsorted=LeerFdt($base);
$Fdt=array();
foreach ($Fdt_unsorted as $value){	$f=explode('|',$value);
	$Fdt[$f[1]]=$value;}

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
<script language="javascript1.2" src="js/lr_trim.js"></script>
<script languaje=javascript>

function EnviarForma(){	buscar=""	if (document.forma1.tipob[0].checked)
		buscar="valor"
	if (document.forma1.tipob[1].checked)
		buscar="pft"
	if (buscar==""){		alert("<?php echo $msgstr["cg_txtpft"]?>")
		return  false	}
    if ((Trim(document.forma1.from.value)=="" || Trim(document.forma1.to.value)=="") && Trim(document.forma1.Expresion.value)=="" && Trim(document.forma1.seleccionados.value)==""){
		alert("<?php echo $msgstr["cg_selrecords"]?>")
		return  false
	}
	if (Trim(document.forma1.from.value)!="" || Trim(document.forma1.to.value)!="") {		if (Trim(document.forma1.from.value)=="" || (document.forma1.to.value)==""){			alert("<?php echo $msgstr["cg_selrecords"]?>")
			return false		}
		if (document.forma1.to.value>top.maxmfn || document.forma1.from.value>top.maxmfn || document.forma1.to.value<=0
		    || document.forma1.from.value<=0 ||  document.forma1.from.value>document.forma1.to.value ){			alert("<?php echo $msgstr["numfr"]?>")
			return false		}	}
	if ((Trim(document.forma1.from.value)!="" || Trim(document.forma1.to.value)!="") && Trim(document.forma1.Expresion.value)!=""){		alert("<?php echo $msgstr["cg_selrecords"]?>")
		return false	}
	fields=""
	ALL=""
	if (buscar=="valor"){
		for (i=0;i<document.forma1.free_C.options.length;i++){			if (document.forma1.free_C.options[i].selected){				if (i==0) ALL="Y"				tag=document.forma1.free_C.options[i].value
				t=tag.split('|')
				fields=fields+t[0]+";"			}		}
		if (ALL=="Y" && fields!="ALL;"){			alert("<?php echo $msgstr["err_all"]?>")
			return		}
	}
	if (fields=="" && buscar=="valor") {		alert("<?php echo $msgstr["freesearch_3"]?>")
		return	}
	if (Trim(document.forma1.search.value)==""){
		alert("<?php echo $msgstr["err_search"]?>")
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

</script>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
<?php echo $msgstr["m_busquedalibre"].": ".$arrHttp["base"]?>
	</div>
	<div class="actions">
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/freesearch.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/freesearch.html target=_blank>".$msgstr["edhlp"]."</a>";
	echo "&nbsp; &nbsp; &nbsp; <a href=\"http://abcdwiki.net/wiki/es/index.php?title=B%C3%BAsquedas#B.C3.BAsqueda_Libre\" target=_blank>abcdwiki</a>";
	echo "<font color=white>&nbsp; &nbsp; Script: dataentry/freesearch.php</font>";
	echo "

	</div>
	 <div class=\"middle form\">
			<div class=\"formContent\">
	";
?>
<form name=forma1 method=post action=freesearch_ex.php onsubmit="Javascript:return false">
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
<input type=hidden name=cipar value=<?php echo $arrHttp["base"]?>.par>
<input type=hidden name=MaxMfn>
<input type=hidden name=fields>
<center>
<table cellpading=5 cellspacing=5 border=0 width=600>

	<tr>
	<td align=center bgcolor=#cccccc colspan=3><?php echo $msgstr["r_recsel"]?> </td>

	<tr>
		<td  align=left nowrap><?php echo $msgstr["cg_rango"]?> </td>
		<td align=left><?php echo $msgstr["cg_from"]?>:<input type=text name=from size=10></td>
		<td  align=left><?php echo $msgstr["cg_to"]?>: <input type=text name=to size=10>
		<script> if (top.window.frames.length>0)
			document.writeln(" &nbsp; &nbsp; &nbsp; (<?php echo $msgstr["maxmfn"]?>: "+top.maxmfn+")")</script></td>
		</td>

	</tr>
		<?php
	if (isset($arrHttp["seleccionados"])){
		echo "<tr>
				  <td><strong>".$msgstr["selected_records"]."</strong></td><td colspan=2>";
		$sel=str_replace("__",",",trim($arrHttp["seleccionados"]));
		$sel=str_replace("_","",$sel);
		echo "<input type=text name=seleccionados size=100 value=$sel>\n";
		echo "</td></tr>";
	}
	?>
	<TR><td colspan=3><hr></td>
	<tr>
		<td  align=left valign=top><a href=javascript:Buscar()><img src=img/barSearch.png height=24 align=middle border=0><?php echo $msgstr["cg_search"]?> </a></td>
        <TD colspan=2 align=left><?php echo $msgstr["expresion"]?><br>
		<textarea rows=1 cols=80 name=Expresion><?
	if (isset($arrHttp["Expresion"])){
	  	echo $Expresion;
	}
?></textarea>
		</td>
    <tr>
    	<td align=center bgcolor=#cccccc colspan=3 height=10px><?php echo $msgstr["cg_selfield"]?></td>
  	</tr>
	<tr>
		<td valign=top align=right></td>
		<td align=left colspan=2>
			<?php echo $msgstr["freesearch_2"]?><br>
			<Select name=free_C multiple size=10><option value="ALL"><?php echo $msgstr["z3950_all"] ?></option>
<?php foreach ($Fdt as $linea){
		$t=explode('|',$linea);
   		echo "<option value='".$t[1].'|'.$t[5].'|'.$t[6].'|'.$t[0]."'>".$t[2]." [".$t[1]."]";
   		if ($t[5]!="") echo " (".$t[5].")";
   		echo "\n";
  	}
?>
					</select>
					<!--br><?php echo $msgstr["freesearch_1"]?>
					<input type=text name=listfree size=80 -->
					</td>

	<tr>
	<td align=center bgcolor=#cccccc colspan=3 height=10px></td>
	</tr>
	<tr>
	<td align=center colspan=3>
	<?php echo $msgstr["buscar"]?><input type=radio name=tipob value=string>Valor  <input type=radio name=tipob value=pft>Pft:<br><textarea name=search cols=100 rows=2></textarea></td>

</table>
<p><input type=submit value=<?php echo $msgstr["cg_execute"]?> onClick=javascript:EnviarForma()>
</div>
</div>
</center>
</form>
<?php
include("../common/footer.php");
?>

</body>
</html>

