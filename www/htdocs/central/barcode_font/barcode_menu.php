<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      barcode_menu.php
 * @desc:      Menú para configuración y emisión de códigos de barra utilizando el número de control
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
if (isset($arrHttp["base"])) $_SESSION["base_barcode"]=$arrHttp["base"];
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
function Configurar(){	document.enviar.action="barcode_configure.php";
	document.enviar.submit()}
function Generar(){
	if (Trim(document.emitir.desde.value)==""){		alert("Debe especificar el primer valor del código de barras a emitir")
		return	}
	if (Trim(document.emitir.hasta.value)==""){
		alert("Debe especificar el último valor del código de barras a emitir")
		return
	}
	ix=document.emitir.sendto.length
	ixSendto=""
	for (i=0;i<ix;i++){
		if (document.emitir.sendto[i].checked)
			ixSendto=document.emitir.sendto[i].value
	}
	if (ixSendto==""){
		alert("Debe especificar el tipo de salida requerida")
		return
	}
	if (ixSendto!="xls" && ixSendto!="doc"){
		msgwin=window.open("","barcode","height=600,resizable,menubar,scrollbars")
		msgwin.focus()
		document.emitir.target="barcode"
	}
	switch (ixSendto){		case "vp":
			document.emitir.action="barcode_ex.php"
			document.emitir.target="barcode"
			break
		case "xls":
			document.emitir.action="barcode_xls_ex.php"
			document.emitir.target=""
			break
		case "doc":
			document.emitir.action="barcode_doc_ex.php"
			document.emitir.target=""
			break	}
	document.emitir.submit()
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
echo "<font color=white>&nbsp; &nbsp; Script: barcode_font/barcode_menu.php";
?>
</font>
</div>
<div class="middle homepage">
    <h4>Configurar Etiquetas</h4>
	<ul>
	<li><a href=javascript:Configurar()>Datos de las etiquetas</a></li>
	<!--li><a href=javascript:Barcode()>Especificaciones del código de barras</a></li-->
	</ul>
<form name=emitir method=post action=barcode_ex.php onsubmit="javascript:return false;">
	<h4>Emitir códigos de barras</h4>
	<table cellpadding=5>
		<tr>
			<td>MFN desde</td><td><input type=text name=desde></td>
		</tr>
		<tr>
			<td>MFN hasta</td><td><input type=text name=hasta></td>
		</tr>
		<tr>
			<td>Enviar a</td>
			<td><input type=radio name=sendto value=doc>Documento DOC<br>
			    <input type=radio name=sendto value=xls>Hoja XLS<br>
			    <input type=radio name=sendto value=vp>Vista previa<br>
			</td>
		</tr>
		<tr>
			<td colspan=2 align=right><input type=submit value=Generar onclick=javascript:Generar()></td>
		</tr>
	</table>
	<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
</form>
</div>
<form name=enviar method=post action=../barcode/barcode_menu.php>
<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
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