<?php
/**
 * @program:   ABCD - ABCD-Central - https://abcd-community.org/
 * @file:      situacion_de_un_objeto_db_ex.php
 * @desc:      Shows the status of the items of an bibliographic record when the items are defined inside the bilbiographic record
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   2.2
*/
session_start();
// Situaci�n de un objeto
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
$script_php="../circulation/item_history_ex.php";
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
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
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp,$msgstr,$lang_db;
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
		if (trim($linea)!=""){
			$t=explode('^',$linea);
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
include("../circulation/scripts_circulation.php");


//SE LEEN LAS TRANSACCIONES DE PR�STAMO
	$trans=LeerTransacciones($arrHttp["inventory"]);
	if (count($trans)==0){
		echo "<h2>".$msgstr["no_transactions"]."<h2>";
	}else{
		echo '<button class="bt bt-blue" onclick="window.print()"><i class="fas fa-print"></i>'.$msgstr['print'].'</button>';
		echo "<table class='table striped'>\n";
		echo "<tr>";
		echo "<th></th>";
		echo "<th>".$msgstr["inventory"]."</th>";
		echo "<th>".$msgstr["usercode"]."</th>";
		echo "<th>".$msgstr["reference"]."</th>";
		echo "<th>".$msgstr["usertype"]."</th>";
		echo "<th>".$msgstr["typeofitems"]."</th>";
		echo "<th>".$msgstr["loandate"]."</th>";
		echo "<th>".$msgstr["devdate"]."</th>";
		echo "<th>".$msgstr["actual_dev"]."</th>";
		echo "<th>".$msgstr["renewals"]."</th>";
	
		foreach ($trans as $value) {
			$t=explode('^',$value);
			echo "<tr>\n";
			echo "<td>";
			if ($t[16]=="P") {
				echo $msgstr["loaned"];
			} else {
				echo $msgstr["returned"];
			}	
			echo "</td>";
			echo "<td>".$t[0]."</td>";
			echo "<td>".$t[10]."</td>";
			echo "<td>".$t[2]."</td>";
			echo "<td>".$t[6]."</td>";
			echo "<td align=center>".$t[3]."</td>";
			echo "<td>".$t[4]."</td>";
			echo "<td>".$t[5]."</td>";
			echo "<td>";
			$date_real_d = $t[8];
			$newDate = date($config_date_format, strtotime($date_real_d));  
			echo $newDate;
			echo "</td>";
			echo "<td>".$t[11]."</td>";
			echo "</tr>\n";
		}
		echo "</table>";
	}

?>
