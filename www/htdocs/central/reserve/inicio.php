<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      inicio.php
 * @desc:      Reserves administration menú
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
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../common/get_post.php");
include("../common/header.php");
?>


<script src=../dataentry/js/lr_trim.js></script>

<script languaje=javascript>
</script>
<body>
<?php
include("../common/institutional_info.php");
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["reserva"]."
			</div>
			<div class=\"actions\">

	";
echo "<a href=\"../circulation/configure_menu.php?reinicio=s&base=".$arrHttp["base"]."\" class=\"defaultButton backButton\">";
echo "<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span></a>";
echo "</div>
	<div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: menu_mantenimiento.php";
?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
<form name=maintenance>
<table cellspacing=5 width=400 align=center>
	<tr>
		<td>

		<input type=hidden name=base value=<?php echo $arrHttp["base"]?>>
             <br>
			<ul>
			<li><a href=usuarios.php>Tipos de usuario que pueden reservar</a></li>
			<li><a href=materiales.php>Tipos de material que pueden ser reservados</a></li>
			<li><a href=politicas.php>Políticas de reserva</a></li>
		    <li><a href=browse.php>Revisar reservas</a></li>
		    <li><a href=eliminar_vencidas.php?base=reserva>Eliminar reservas vencidas</a></li>
		   </ul>

		</td>
</table></form>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>

