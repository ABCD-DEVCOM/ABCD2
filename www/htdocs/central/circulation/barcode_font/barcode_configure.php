<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      barcode_configure.php
 * @desc:      Configuración de la etiqueta y códigos de barra
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
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include ("../config.php");
include ("../lang/admin.php");
include ("../lang/dbadmin.php");

include("../common/header.php");
$base=$arrHttp["base"];
$parms=array();
if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/barcode_label.tab")){
	$fp=file($db_path.$base."/def/".$_SESSION["lang"]."/barcode_label.tab");
	foreach ($fp as $linea){
		$linea=trim($linea);
		$l=explode('=',$linea);
		$parms[$l[0]]=$l[1];
	}

}
?>
<!-- calendar stylesheet -->
  <link rel="stylesheet" type="text/css" media="all" href="../dataentry/calendar/calendar-win2k-cold-1.css" title="win2k-cold-1" />
  <!-- main calendar program -->
  <script type="text/javascript" src="../dataentry/calendar/calendar.js"></script>
  <!-- language for the calendar -->
  <script type="text/javascript" src="../dataentry/calendar/lang/calendar-es.js"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
  <script type="text/javascript" src="../dataentry/calendar/calendar-setup.js"></script>
  <script type="text/javascript" src="../dataentry/js/lr_trim.js"></script>
<script>

function Actualizar(){
	if (Trim(document.actualizar.width.value)=="" || Trim(document.actualizar.height.value)=="" ||
	    Trim(document.actualizar.cols.value)==""  || Trim(document.actualizar.formato.value)=="" ){
	  alert("Debe suministrar toda la información solicitada")
	  return	}
	document.actualizar.submit()
}
</script>
<body>
<?php
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
	</div>
	<div class="actions">
		<a href="javascript:document.regresar.submit()" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"];?></strong></span></a>
	</div>

<div class="spacer">&#160;</div>
</div>
<?php
}
?>
<div class="helper">
<!--a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/circulation/file_reports.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/file_reports.html target=_blank>".$msgstr["edhlp"]."</a-->";
echo "<font color=white>&nbsp; &nbsp; Script: barcode_font/barcode_configure.php";
?>
</font>
</div>
<div class="middle homepage">
<form name=actualizar method=post action=barcode_configure_ex.php onsubmit="javascript:return false">
 <h4>Configuracion para la impresión del código de barras</h4>
 <table>
 	<tr>
 		<td>Nombre del formato con los datos de la etiqueta</td>
 		<td><input type=text name=formato size=20 value=<?php if (isset($parms["formato"])) echo $parms["formato"]?>></td>
 	</tr>
 	<tr>
 		<td>Alto de la etiqueta</td>
 		<td><input type=text name=height size=10 value=<?php if (isset($parms["height"])) echo $parms["height"]?>> cms</td>
 	</tr>
 	<tr>
 		<td>Ancho de la etiqueta</td>
 		<td><input type=text name=width size=10 value=<?php if (isset($parms["width"])) echo $parms["width"]?>> cms</td>
 	</tr>
 	<tr>
 		<td>Número de etiquetas por línea</td>
 		<td><input type=text name=cols size=10 value=<?php if (isset($parms["cols"])) echo $parms["cols"]?>></td>
 	</tr>
    </table>
	<p>
	<input type=submit value="Actualizar" onclick=javascript:Actualizar()>

</div>
<form name=enviar method=post action=barcode_menu.php>
<? if (isset($arrHttp["encabezado"]))
		echo "<input type=hidden name=encabezado value=s>\n";
	if (isset($arrHttp["retorno"]))
		echo "<input type=hidden name=retorno value=".$arrHttp["retorno"].">\n";
	if (isset($arrHttp["modulo"]))
		echo "<input type=hidden name=modulo value=".$arrHttp["modulo"].">\n";
   echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
?>
</form>
</body>
</html>