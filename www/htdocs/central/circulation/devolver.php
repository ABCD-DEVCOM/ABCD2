<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      devolver.php
 * @desc:      Ask for the item to be returned
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["base"]="users";
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
if (!isset($uskey)) $uskey="";
$ec_output="";

function ImprimirRecibo($Recibo){
$Recibo=str_replace("</",'<\/',$Recibo);
?>

<script>
	Recibo="<?php echo $Recibo?>"
	msgwin=window.open("","recibo","width=400, height=300, scrollbars, resizable")
	msgwin.document.write(Recibo)
	msgwin.document.close()
	msgwin.focus()
	msgwin.print()
	msgwin.close()
</script>
<?php
}
include("../circulation/scripts_circulation.php");
?>
<script>
document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13)
		EnviarForma()

    return true;
  };


function EnviarForma(){
	if (Trim(document.inventorysearch.inventory.value)=="" ){
		alert("<?php echo $msgstr["falta"]." ".$msgstr["inventory"]?>")
		return
	}
	INV=escape(document.inventorysearch.inventory.value)
	<?php if (isset($inventory_numeric) and $inventory_numeric =="Y")
		//echo "INV=parseInt(document.inventorysearch.inventory.value,10)\n";
	?>
    document.inventorysearch.searchExpr.value=INV
    document.inventorysearch.submit()
}

function AbrirIndiceAlfabetico(){
	db="trans"
	cipar="trans.par"
	postings=1
	tag="10"
	<?php if (isset($_SESSION["library"])){		echo "Prefijo='TR_P_".$_SESSION["library"]."_'\n";	}else{		echo "Prefijo='TR_P_'\n";	}
	?>
	Ctrl_activo=document.inventorysearch.inventory
	lang="<?php echo $_SESSION["lang"]?>"
	Separa=""
	Repetible="1"
	Formato="v10,`$$$`,v10"
	Prefijo=Separa+"&prefijo="+Prefijo
	ancho=200
	url_indice="capturaclaves.php?opcion=autoridades&base="+db+"&cipar="+cipar+"&Tag="+tag+"&tagfst=10"+Prefijo+"&lang="+lang+"&repetible="+Repetible+"&Formato="+Formato+"&postings=1"
	msgwin=window.open(url_indice,"Indice","width=480, height=425,left=300,scrollbars")
	msgwin.focus()
}

function DeleteSuspentions(){
	Mfn=""
	switch (nSusp){
		case 1:
			if (document.ecta.susp.checked){
            	Mfn=document.ecta.susp.value
			}
			break
		default:
			for (i=0;i<nSusp;i++){
				if (document.ecta.susp[i].checked){
					Mfn+=document.ecta.susp[i].value+"|"
				}
			}
			break
	}
	if (Mfn==""){
		alert("<?php echo $msgstr["selsusp"]?>")
		return
	}
	document.multas.Mfn.value=Mfn
	document.multas.submit()
}


</script>
<?php
echo "<body onload='javascript:document.inventorysearch.inventory.focus()'>\n";
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["return"]?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/devolver.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php echo "
<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/circulation/loan.html target=_blank>". $msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/circulation/loan.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: devolver.php </font>
	</div>";
// prestar, reservar o renovar
?>
<div class="middle list">

	<div class="searchBox">
	<form name=inventorysearch action=devolver_ex.php method=post onsubmit="javascript:return false">
	<table>
		<tr>
		<td width=100 valign=top>
		<label for="searchExpr">
			<strong><?php echo $msgstr["inventory"]?></strong>
		</label>
		</td><td valign=top>
		<textarea name="inventory" id="inventory" value="" class="textEntry" onfocus="this.className = 'textEntry';"  onblur="this.className = 'textEntry';" /></textarea>
        <input type=hidden name=base value=trans>
        <input type=hidden name=searchExpr>
        </td><td valign=top>
		<input type="button" name="list" value="<?php echo $msgstr["list"]?>" class="submit" onclick="javascript:AbrirIndiceAlfabetico();return false"/>
		<input type="submit" name="reservar" value="<?php echo $msgstr["return"]?>" xclass="submitAdvanced" onclick="javascript:EnviarForma()"/>
		</td></table>
		<?php echo $msgstr["clic_en"]." <i>[".$msgstr["return"]."]</i> ".$msgstr["para_c"]?>
	</form>
	</div>
<?php
if (isset($arrHttp["usuario"])){   // include("ec_include.php");
   // echo "<div class=formContent>$ec_output</div>";
}
if (isset($arrHttp["devuelto"]) and $arrHttp["devuelto"]=="S" and isset($arrHttp["errores"])){	$inven=explode(';',$arrHttp["errores"]);
	foreach ($inven as $inventario){
		if (trim($inventario)!=""){
			$Mfn=trim($inventario);
			echo "<p><font color=red>". $inventario." ".$msgstr["item"].": ".$msgstr["copynoexists"]." </font>";
		}
	}

}

if (isset($arrHttp["devuelto"]) and $arrHttp["devuelto"]=="S" and isset($arrHttp["resultado"])){
	$lista_mfn=explode(';',$arrHttp["resultado"]);
	foreach ($lista_mfn as $Mfn){
		if (trim($Mfn)!=""){
			echo "<p><font color=red>".$msgstr["returned"]." ".$msgstr["item"].":  </font>";
			$Formato="v10,' ',mdl,v100'<br>'";
			$Formato="&Pft=$Formato";
			$IsisScript=$xWxis."leer_mfnrange.xis";
			$query = "&base=trans&cipar=$db_path"."par/trans.par&from=$Mfn&to=$Mfn$Formato";
			include("../common/wxis_llamar.php");
			foreach ($contenido as $value){
				echo $value;
			}
		}
	}
}

//SE VERIFICA SI ALGUNO DE LOS EJEMPLARES DEVUELTOS ESTÁ RESERVADO
if (isset($arrHttp["lista_control"])) {	include("../reserve/reserves_read.php");
	$rn=explode(";",$arrHttp["lista_control"]);
	$Expresion="";
	foreach ($rn as $value){		$value=trim($value);		if ($value!=""){			if ($Expresion=="")
				$Expresion=$value;
			else
				$Expresion.=" or ".$value;
		}
	}
	$Expresion='('.$Expresion.')' ;
	$reserves_arr= ReservesRead($Expresion,"S");
	$reserves_title=$reserves_arr[0];
	if ($reserves_title!=""){
		echo "<p><!--strong>".$msgstr["reserves"]."</strong><br-->";
		echo $reserves_title."<p>";
	}}

// se imprimen los recibos de devolucion, si procede
if (isset($arrHttp["rec_dev"])) {
	$r=explode(";",$arrHttp["rec_dev"]);
	$recibo="";
	foreach ($r as $Mfn){		if ($Mfn!=""){
			$Formato="";
			if (file_exists($db_path."trans/pfts/".$_SESSION["lang"]."/r_return.pft")){
				$Formato=$db_path."trans/pfts/".$_SESSION["lang"]."/r_return";
			}else{
				if (file_exists($db_path."trans/pfts/".$lang_db."/r_return.pft")){
					$Formato=$db_path."trans/pfts/".$lang_db."/r_return";
				}
			}
			if ($Formato!="") {
                $Formato="&Formato=$Formato";
				$IsisScript=$xWxis."leer_mfnrange.xis";				$query = "&base=trans&cipar=$db_path"."par/trans.par&from=$Mfn&to=$Mfn$Formato";
				include("../common/wxis_llamar.php");
				foreach ($contenido as $value){					$recibo.=trim($value);				}			}		}
	}
	if ($recibo!="") {
		ImprimirRecibo($recibo);	}
}

if (isset($arrHttp["error"])){	echo "<script>
			alert('".$arrHttp["error"]."')
			</script>
	";}
echo "</div>";
include("../common/footer.php");
echo "</body></html>" ;
?>