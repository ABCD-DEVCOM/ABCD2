<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      calendario.php
 * @desc:      Update the calendar of holidays
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
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/prestamo.php");
include("../config.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("calendario_ver.php");

IF (!isset($arrHttp["mes"])) $arrHttp["mes"]="";
if (!isset($arrHttp["cadena"])) $arrHttp["cadena"]="";
if (!isset($arrHttp["ano"])) $arrHttp["ano"]="";
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
if (isset($arrHttp["Opcion"]) and $arrHttp["Opcion"]=="guardar"){	Calendario("feriados.tab");
	die;}

include("../common/header.php");
?>
<script>
function Dias_Fe(Tipo) {
	document.tabla.cadena.value = ' '
	NumeroDias= document.tabla.dias.length
	switch (Tipo){
		case 0: document.tabla.Opcion.value="guardar"
			break
		case 1:
			document.tabla.mes.value = document.tabla.mes_ante.value
			document.tabla.ano.value = document.tabla.ano_ante.value
			break
		case 2:
			document.tabla.mes.value = document.tabla.mes_sig.value
			document.tabla.ano.value = document.tabla.ano_sig.value
			break;

	}
	TColum=' '
	for ( j = 0 ; j < NumeroDias; j++) {
  		if (document.tabla.dias[j].checked == true ){
			Tconta = j + 1
			TColum = TColum+(Tconta)+'|'
		}
	}//Fin de j
	document.tabla.cadena.value = TColum
	document.tabla.submit()
}
</script>
<?php
$encabezado="";
include("../common/institutional_info.php");

echo "
		<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["calendar"]."
			</div>
			<div class=\"actions\">\n";
if (isset($arrHttp["ver"])){	  echo "<a href=javascript:self.close() class=\"defaultButton cancelButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["cancel"]."</strong></span>
				</a>\n";}else{
				echo "<a href=\"configure_menu.php?encabezado=s\" class=\"defaultButton backButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>\n";
}
echo "
				<a href=javascript:Dias_Fe(0) class=\"defaultButton saveButton\">
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>".$msgstr["update"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/circulation/calendario.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
	if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/circulation/calendario.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; calendario.php </font>";
echo "</div>
			<div class=\"spacer\">&#160;</div>
		</div>
		<div class=\"middle homepage\">";

Calendario("feriados.tab");

echo "<BR><BR><BR></CENTER></DIV></div>";
include("../common/footer.php");
echo "</body></html>" ;

?>