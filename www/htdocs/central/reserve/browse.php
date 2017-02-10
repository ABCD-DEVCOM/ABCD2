<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      Browse database records
 * @desc:
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
//
// SHOWS THE RECORD OF A DATABASE IN A TABLE VIEW
//
session_start();
if (!isset($_SESSION["login"])){
	echo "<center><br><br><h2>Ud. no tiene permiso para entrar a este módulo</h2>";
	die;
}
include ("../config.php");
include ("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

if (isset($arrHttp["Expresion"])){
	$arrHttp["Expresion"]=stripslashes($arrHttp["Expresion"]);
	$Expresion=trim($arrHttp["Expresion"]);
	$Expresion=str_replace("  "," ",$Expresion);
	$Expresion=str_replace("  "," ",$Expresion);
	$xor="¬or¬";
	$xand="¬and¬";
	$Expresion=str_replace (" {", "{", $Expresion);
	$Expresion=str_replace (" or ", $xor, $Expresion);
	$Expresion=str_replace ("+", $xor, $Expresion);
	$Expresion=str_replace (" and ", $xand, $Expresion);
	$Expresion=str_replace ("*", $xand, $Expresion);
	while (is_integer(strpos($Expresion,'"'))){
		$nse++;
		$pos1=strpos($Expresion,'"');
		$xpos=$pos1+1;
		$pos2=strpos($Expresion,'"',$xpos);
		$subex[$nse]=trim(substr($Expresion,$xpos,$pos2-$xpos));
		if ($pos1==0){
			$Expresion="{".$nse."}".substr($Expresion,$pos2+1);
		}else{
			$Expresion=substr($Expresion,0,$pos1-1)."{".$nse."}".substr($Expresion,$pos2+1);
		}
	}

	$Expresion=str_replace(" ","*",$Expresion);
	while (is_integer(strpos($Expresion,"{"))){
		$pos1=strpos($Expresion,"{");
		$pos2=strpos($Expresion,"}");
		$ix=substr($Expresion,$pos1+1,$pos2-$pos1-1);
		if ($pos1==0){
			$Expresion=$subex[$ix].substr($Expresion,$pos2+1);
		}else{
			$Expresion=substr($Expresion,0,$pos1)." ".$subex[$ix]." ".substr($Expresion,$pos2+1);
		}
	}
	$Expresion=str_replace ("¬", " ", $Expresion);
	$Expresion=urlencode($Expresion);
}

$base="reserva";
$arrHttp["base"]=$base;

if (isset($arrHttp["unlock"]) and $arrHttp["Mfn"]!="New"){
// if the record editing was cancelled unlock the record or keep deleted
	$query="";
    if (isset($arrHttp["unlock"])){
    	if (isset($arrHttp["Status"]) and $arrHttp["Status"]!=0)
    		$IsisScript=$xWxis."eliminarregistro.xis";
    	else
    		$IsisScript=$xWxis."unlock.xis";
    	$query = "&base=" . $arrHttp["base"] . "&cipar=".$arrHttp["base"]. ".par&Mfn=" . $arrHttp["Mfn"]."&login=".$_SESSION["login"];
    	include("../common/wxis_llamar.php");
    	$res=implode("",$contenido);
    	$res=trim($res);
    }
}
if (!isset($arrHttp["from"])) $arrHttp["from"]=1;

$arrHttp["Mfn"]=1;
$Formato="tbreserva";
$to=$arrHttp["from"]+9;
if (!isset($arrHttp["Expresion"])){
	$query = "&base=".$arrHttp["base"]."&cipar=reserva.par&from=".$arrHttp["from"]."&to=$to&Formato=$Formato&Opcion=buscar";
	$IsisScript=$xWxis."leer_mfnrange.xis";
	include("../common/wxis_llamar.php");
	$lista_users=$contenido;
}else{
	$query = "&base=".$arrHttp["base"]."&cipar=reserva.par&from=".$arrHttp["from"]."&to=$to&Formato=$Formato".".pft&Expresion=".$Expresion;
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$lista_users=$contenido;
}
include("../common/header.php");
?>
<script>
xEliminar="";
Mfn_eliminar=0;
function Browse(){
	if (Indices=="Y") document.browse.Expresion.value=""
	document.browse.submit();
}

function Editar(Mfn,Status){
	document.editar.Mfn.value=Mfn
	document.editar.Status.value=Status
	document.editar.Opcion.value="editar"
	document.editar.submit()
}

function Crear(){
	document.editar.Mfn.value="New"
	document.editar.Opcion.value="nuevo"
	document.editar.submit()
}

function EjecutarBusqueda(Accion){
	switch (Accion){

		case "first":
			document.diccionario.from.value=1
			document.browse.from.value=1
			break
		case "previous":
               desde=desde-20
               if (desde<=0) desde=1
               document.diccionario.from.value=desde
               document.browse.from.value=desde
			break
		case "next":
			break
		case "last":
			desde=last-9
			if (desde<=0) desde=1
			document.diccionario.from.value=desde
			document.browse.from.value=desde
			break
	}
	if (Indices=="Y"){
		ix=document.forma1.indexes.selectedIndex
		sel=document.forma1.indexes.options[ix].value
		t=sel.split('|')

        document.diccionario.target=""
        if (Indices=="Y") document.diccionario.Expresion.value=document.forma1.expre.value
        document.diccionario.action="browse.php"
		document.diccionario.campo.value=escape(t[0])
		document.diccionario.prefijo.value=t[2]
		document.diccionario.id.value=t[1]
		document.diccionario.Opcion.value="buscar"
		document.diccionario.submit()
	}else{
		if (Indices=="Y")document.diccionario.Expresion.value=document.forma1.expre.value
		document.browse.submit()
	}
}

function PresentarDiccionario(){
	msgwin=window.open("","Diccionario","scrollbars, height=400")
	ix=document.forma1.indexes.selectedIndex
	if (ix<1){
		alert("Debe seleccionar el campo de búsqueda")
		return
	}
	sel=document.forma1.indexes.options[ix].value
	t=sel.split('|')

	document.diccionario.campo.value=escape(t[0])
	document.diccionario.prefijo.value=t[2]
	document.diccionario.id.value=t[1]
	document.diccionario.Diccio.value="document.forma1.expre"
	document.diccionario.submit()
	msgwin.focus()
}
function Eliminar(Mfn){
	xEliminar=""
	document.eliminar.Mfn.value=Mfn
	document.eliminar.submit()
}
</script>
<?php
echo "<body>";
$ad_s="";  // Hay formulario de búsqueda avanzada?
$archivo=$db_path."/".$arrHttp["base"]."/pft/camposbusqueda.tab";
if (file_exists($archivo)){
	$ad_s="S";
	echo "<Script>Indices='Y'</script>\n" ;
?>
<form name=forma1 onsubmit="javascript:return false">
<table width=750>
<td align=center>
<table bgcolor="#cccccc">
	<td>

			<strong>Buscar</strong>
			<input type="text" name="expre" id="Expre" class="textEntry" onfocus="this.className = 'textEntry textEntryFocus';"  onblur="this.className = 'textEntry';"
			value='<?php if (isset($arrHttp["Expresion"])) echo $arrHttp["Expresion"]?>' />
			<select name="indexes" class="textEntry">
				<option></option>
<?php

	$fp=file($archivo);
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$t=explode('|',$value);
			$xselected="";
			if (isset($arrHttp["Indice"])){
				if ($arrHttp["Indice"]==trim($t[1])) $xselected=" selected";
			}
			echo "<Option value='$value' $xselected>".$t[0]."\n";
		}

	}
?>
				</select>

				<input type="button" name="ok" value="Índice" xclass="submit" onClick=javascript:PresentarDiccionario() />
				<input type="submit" name="ok" value="Buscar" class="submit" onClick=javascript:document.diccionario.from.value=1;EjecutarBusqueda() />
				<?php if (isset($arrHttp["Expresion"]))
					echo "\n<input type=\"submit\" name=\"ok\" value=\"Recorrer por MFN\"  onClick=javascript:Browse() />"
				?>
				<input type=hidden name=Target value=S>
	</td>
</table>

</form>

<?php }else{
	echo "<Script>Indices='N'</script>\n" ;
}
echo "
			<p><table bgcolor=#cccccc  cellpadding=5>
				<tr>
					<th>&nbsp;</th>
	";
// se lee la tabla con los títulos de las columnas
$fp[0]="Cod.Usuario";
$fp[1]="No.Clasificación";
$fp[2]="Fecha reserva";
foreach ($fp as $value){
	$value=trim($value);
	if (trim($value)!=""){
		$t=explode('|',$value);
		foreach ($t as $rot) echo "<th class=titulo2>$rot</th>";
	}
}
echo "<th>&nbsp;</th></tr>";
foreach ($lista_users as $value){
	$value=trim($value);
	if ($value!=""){
		$u=explode('|',$value);
		$Mfn=$u[0];
		$Status=$u[1];
		if ($Status=="") $Status=0;
		$desde=$u[2];
		$hasta=$u[3];
		$arrHttp["showdeleted"]="Y";
		if (($Status==0 or $Status==-2) or (isset($arrHttp["showdeleted"]) and $Status==1)){
			echo "<tr onmouseover=\"this.className = 'rowOver';\" onmouseout=\"this.className = '';\">\n";
			echo "<td>".$u[2]."/",$u[3];
			if ($Status==1) echo "<img src=\"../images/delete.png\" align=absmiddle alt=\"excluir base de dados\" title=\"excluir base de dados\" />";
			echo "</td>";
			for ($ix=4;$ix<count($u);$ix++) echo "<td>" .$u[$ix]."</td>";
			echo "<td>";
			if ($Status==0)
				echo "<a href=\"javascript:Eliminar($Mfn)\"><img src=\"../images/delete.png\" alt=\"Eliminar\" title=\"Eliminar\" /></a>";
			else {
				switch ($Status){
					case -2:
						echo "Registro Bloqueado";
						break;
					case 1:
						echo "Registro eliminado";
						break;
				}
			}
			echo "</td>";
			echo "</tr>";
		}
	}
}
echo "			</table>";

?>

	<div class="pagination">
		<a href="javascript:EjecutarBusqueda('first')" class="singleButton">
			&#160; &#171; primero &#160;
		</a>
		<a href="javascript:EjecutarBusqueda('previous')" class="singleButton">
			&#160; &#171; anterior &#160;
		</a>
		<a href="javascript:EjecutarBusqueda('next')" class="singleButton">
			&#160; &#187; siguiente &#160;
		</a>
		<a href="javascript:EjecutarBusqueda('last')" class="singleButton">
			&#160; &#187; último &#160;
		</a>
		<a href="inicio.php?Opcion=continuar" class="singleButton">
			&#160; &#187; menú &#160;
		</a>
		<div class="spacer">&#160;</div>
	</div>
<?php
echo "
 <form name=eliminar method=post action=eliminar_registro.php>
 <input type=hidden name=base value=".$arrHttp["base"].">
 <input type=hidden name=from value=".$arrHttp["from"].">
 <input type=hidden name=retorno value=browse.php?base=".$arrHttp["base"]."&modulo=loan>\n ";
 if (isset($arrHttp["Expresion"])) echo "<input type=hidden name=Expresion value=".urlencode($arrHttp["Expresion"]).">\n";
 echo "<input type=hidden name=Mfn>\n";
 $desde++;
echo "</form>
<form name=diccionario method=post action=diccionario.php target=Diccionario>
	<input type=hidden name=showdeleted>
	<input type=hidden name=base value=".$arrHttp["base"].">
	<input type=hidden name=cipar value=".$arrHttp["base"].".par>
	<input type=hidden name=prefijo>
	<input type=hidden name=Formato>
	<input type=hidden name=campo>
	<input type=hidden name=id>
	<input type=hidden name=Diccio>
	<input type=hidden name=from value=$desde>
	<input type=hidden name=Opcion value=diccionario>
	<input type=hidden name=Target value=s>
	<input type=hidden name=Expresion>
	<input type=hidden name=Tabla value=browse>
</form>
<form name=browse method=post action=browse.php>
	<input type=hidden name=showdeleted>
	<input type=hidden name=base value=reserva>
	<input type=hidden name=cipar value=reserva.par>
	<input type=hidden name=from value=$desde>
	<input type=hidden name=to>";
if (isset($arrHttp["Expresion"])) echo "<input type=hidden name=Expresion value=".urlencode($arrHttp["Expresion"])."\">\n";
echo "</form>
<form name=editar method=post action=fmt.php>
	<input type=hidden name=from value=".$arrHttp["from"].">
	<input type=hidden name=base value=reserva>
	<input type=hidden name=cipar value=reserva.par>
    <input type=hidden name=Mfn>
    <input type=hidden name=Status>
    <input type=hidden name=retorno value=browse.php>
    <input type=hidden name=Opcion value=editar>
    <input type=hidden name=encabezado value=s>
";
if (isset($arrHttp["Expresion"])) echo "<input type=hidden name=Expresion value=".urlencode($arrHttp["Expresion"]).">\n";
echo "</form>
</td>
</table>
	</body>
</html>
<script>
	first=1
	last=$hasta
	desde=$desde
</script>
";

function MenuBrowse(){
global $msgstr,$arrHttp,$ret;
	echo "<div class=\"actions\">";

		if (!isset($arrHttp["return"])){
			$ret="../inicio.php?reinicio=s$encabezado";
			if (isset($arrHttp["base"])) $ret.="&base=".$arrHttp["base"];
		}else{
			$ret=str_replace("|","?",$arrHttp["return"])."&encabezado=".$arrHttp["encabezado"];
		}
	?>
		<a href=<?php echo $ret?>><?php echo $msgstr["back"]?></a> |
		<a href="javascript:Crear()"><?php echo $msgstr["crear"]?></a>
        &nbsp; &nbsp; &nbsp;
	</div>

<?php }?>
