<?
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      menu_statistics.php
 * @desc:      Statistics menu for circulation module
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
///////////////////////////////////////////////////////////////////////////////

session_start();
if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
$lang=$_SESSION["lang"];
include("../common/get_post.php");
include("../config.php");

// ARCHIVOS DE LENGUAJE
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../lang/statistics.php");


//foreach ($contenido as $var=>$value) echo "$var=$value<br>";

// EXTRACCIÓN DEL NOMBRE DE LA BASE DE DATOS
if (strpos($arrHttp["base"],"|")===false){

}   else{
		$ix=strpos($arrHttp["base"],'^b');
		$arrHttp["base"]=substr($arrHttp["base"],2,$ix-2);
}

// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILO
include("../common/header.php");

// INCLUSION DE LOS SCRIPTS
?>
<script src=../dataentry/js/lr_trim.js></script>
<script languaje=javascript>

function Update(Option){
	if (document.update_base.base.value==""){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	switch (Option){
		case "stats_var":
			document.update_base.action="../statistics/config_vars.php"
			break
		case "stats_tab":
			document.update_base.action="../statistics/tables_cfg.php"
			break
	}
	document.update_base.submit()
}

</script>
<body>

<?
// ENCABEZAMIENTO DE LA PÁGINA
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["updbdef"]. ": " . $arrHttp["base"]."
			</div>
			<div class=\"actions\">

	";
if (isset($arrHttp["encabezado"])){
	echo "<a href=\"../common/inicio.php?reinicio=s&modulo=loan&base=".$arrHttp["base"]."\" class=\"defaultButton backButton\">";
echo "
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>";
}
echo "			</div>
			<div class=\"spacer\">&#160;</div>
	</div>";

// AYUDA EN CONTEXTO E IDENTIFICACIÓN DEL SCRIPT QUE SE ESTÁ EJECUTANDO
// OPCIONES DEL MENU
 ?>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/admin.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if ($_SESSION["permiso"]=="adm") echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/admin.html target=_blank>".$msgstr["edhlp"]."</a>
<font color=white>&nbsp; &nbsp; Script: menu_statistics.php" ?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">
        		<p>
</center>
<table width=400 align=center>
	<tr>
		<td class=td >
			<form name=update_base onSubmit="return false">
			<input type=hidden name=Opcion value=update>
			<input type=hidden name=type value="">
			<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
			<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";?>
            <br>
            <ul>
            <li><a href=javascript:Update("stats_var")><?php echo $msgstr["estadisticas"]." - ".$msgstr["var_list"]?></a></li>
            <li><a href=javascript:Update("stats_tab")><?php echo $msgstr["estadisticas"]." - ".$msgstr["tab_list"]?></a></li>
            </ul>
			</form>
		</td>
</table>
<br><br><br>
</div>
</div>
<?
// PIE DE PÁGINA
include("../common/footer.php");
?>
</body>
</html>
