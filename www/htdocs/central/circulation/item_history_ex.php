<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      situacion_de_un_objeto_db_ex.php
 * @desc:      Shows the status of the items of an bibliographic record when the items are defined inside the bilbiographic record
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
// Situación de un objeto
if (!isset($_SESSION["permiso"])){	header("Location: ../common/error_page.php") ;
}
$script_php="../circulation/item_history_ex.php";if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
$arrHttp["ecta"]="Y";
include("../config.php");
include("../config_loans.php");
$lang=$_SESSION["lang"];

include("../lang/admin.php");
include("../lang/prestamo.php");

include("../reserve/reserves_read.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>"; die;

include("leer_pft.php");
include("borrowers_configure_read.php");
include("calendario_read.php");
include("locales_read.php");

function LeerTransacciones($inventario){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$msgstr;
	$tr_prestamos=array();
	$formato_obj=$db_path."trans/pfts/".$_SESSION["lang"]."/loans_display.pft";
	if (!file_exists($formato_obj)) $formato_obj=$db_path."trans/pfts/".$lang_db."/loans_display.pft";
	$query = "&Expresion=NI=".$inventario;
	if (isset($arrHttp["year"]) or isset($arrHttp["volumen"])){
		$query.="_";
		if (isset($arrHttp["year"])) $query.="A:".$arrHttp["year"];
		if (isset($arrHttp["volumen"])) $query.="V:".$arrHttp["volumen"];
		if (isset($arrHttp["numero"])) $query.="N:".$arrHttp["numero"];
	}
	$query.="&base=trans&cipar=$db_path"."par/trans.par&Formato=".$formato_obj."&reverse=ON";
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$tr_prestamos=array();
	$ix=0;
	foreach ($contenido as $linea){
		if (trim($linea)!=""){			$t=explode('^',$linea);
			$ix=$ix+1;
			$tr_prestamos[$t[8]."_$ix"]=$linea;
        }
	}
    krsort($tr_prestamos);
	return $tr_prestamos;
}


// ------------------------------------------------------
// INICIO DEL PROGRAMA
// ------------------------------------------------------
include("../common/header.php");
include("../common/institutional_info.php");
include("../circulation/scripts_circulation.php");
?>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["co_history"]?>
	</div>
	<div class="actions">
		<a href="item_history.php" class="defaultButton backButton">
			<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
			<span><?php echo $msgstr["back"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/item_history.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/item_history.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: item_history_ex.php</font>\n";

echo "
	</div>
<div class=\"middle form\">
	<div class=\"formContent\">";
//SE LEEN LAS TRANSACCIONES DE PRÉSTAMO
	$trans=LeerTransacciones($arrHttp["inventory"]);
	if (count($trans)==0){		echo "<h2>".$msgstr["no_transactions"]."<h2>";	}else{		echo "<table cellpadding=5>\n";
		echo "<tr><th> </th><th>".$msgstr["inventory"]."</th><th>".$msgstr["usercode"]."</th>";
		echo "<th>".$msgstr["reference"]."</th>";
		echo "<th>".$msgstr["usertype"]."</th>";
		echo "<th>".$msgstr["typeofitems"]."</th>";
		echo "<th>".$msgstr["loandate"]."</th>";
		echo "<th>".$msgstr["devdate"]."</th>";
		echo "<th>".$msgstr["actual_dev"]."</th>";
		echo "<th>".$msgstr["renewals"]."</th>";
		foreach ($trans as $value) {			$t=explode('^',$value);
			echo "<tr>\n";
			echo "<td>";
			if ($t[16]=="P")
				echo $msgstr["loaned"];
			else
				echo $msgstr["returned"];
			echo "</td>";
			echo "<td>".$t[0]."</td>";
			echo "<td>".$t[10]."</td>";
			echo "<td>".$t[2]."</td>";
			echo "<td>".$t[6]."</td>";
			echo "<td align=center>".$t[3]."</td>";
			echo "<td>".$t[4]."</td>";
			echo "<td>".$t[5]."</td>";
			echo "<td>".$t[18]."</td>";
			echo "<td>".$t[11]."</td>";
			echo "</tr>\n";		}
		echo "</table>";
	}

echo "<p>";
echo "</div></div>";
include("../common/footer.php");
echo "</body></html>";
?>
