<?php
/**
 * @program:   ABCD - ABCD-Central - https://abcd-community.org/
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      borrower_history.php
 * @desc:      Shows the transactions history of a borrower
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
include("../reserve/reserves_read.php");
//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");

//Horario de la biblioteca, unidades de multa, moneda
include("locales_read.php");
include("functions.php");

 	//include("../common/institutional_info.php");
//include("functions.php");
// se determina si el préstamo está vencido
function compareDate_reports ($FechaP){
global $locales,$config_date_format;
//Se convierte la fecha a formato ISO (yyyymmaa) utilizando el formato de fecha local
	$f_date=explode('/',$config_date_format);

	switch ($f_date[0]){
		case "DD":
		case "d":
			$dia=substr($FechaP,0,2);
			break;
		case "MM":
		case "m":
			$mes=substr($FechaP,2,2);
			break;
	}

	switch ($f_date[1]){
		case "DD":
		case "d":
			$dia=substr($FechaP,3,2);
			break;
		case "MM":
		case "m":
			$mes=substr($FechaP,3,2);
			break;
	}
	$year=substr($FechaP,6,4);
	$exp_date=$year."-".$mes."-".$dia;
	$todays_date = date("Y-m-d");
	$today = strtotime($todays_date);
	$expiration_date = strtotime($exp_date);
	$diff=$expiration_date-$today;
	return $diff;

}//end Compare Date

function PrepararFecha($FechaP){

global $locales,$config_date_format;;
//Se convierte la fecha al formato de fecha local
	$df=explode('/',$config_date_format);
	switch ($df[0]){
		case "DD":
		case "d":
			$dia=substr($FechaP,6,2);
			break;
		case "MM":
		case "m":
			$mes=substr($FechaP,6,2);
			break;
	}
	switch ($df[1]){
		case "DD":
		case "d":
			$dia=substr($FechaP,4,2);
			break;
		case "MM":
		case "m":
			$mes=substr($FechaP,4,2);
			break;
	}
	$year=substr($FechaP,0,4);
	return $dia."-".$mes."-".$year;
}


// se presenta la  información del usuario
	$formato_us=$db_path."users/loans/".$_SESSION["lang"]."/loans_usdisp.pft";
    if (!isset($formato_us)) $formato_us=$db_path."users/loans/".$lang_db."/loans_usdisp.pft";
   	$query = "&Expresion=CO_".$arrHttp["usuario"]."&base=users&cipar=$db_path/par/users.par&Formato=".$formato_us;
	$contenido="";
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$ec_output="";
	foreach ($contenido as $linea){
		$ec_output.= $linea."\n";
	}
    $permitir_prestamo="S";
// se leen los prestamos pendientes
	$formato_obj=$db_path."trans/pfts/".$_SESSION["lang"]."/loans_display.pft";
    if (!file_exists($formato_obj)) $formato_obj=$db_path."trans/pfts/".$lang_db."/loans_display.pft";
   	$query = "&Expresion=CU_".$arrHttp["usuario"]."&base=trans&cipar=$db_path"."par/trans.par&Formato=".$formato_obj;
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$prestamos=array();
	foreach ($contenido as $linea){
		$prestamos[]=$linea;
	}
	$nv=0;   //número de préstamos vencidos
	$np=0;   //Total libros en poder del usuario

	if (count($prestamos)>0) {
		$ec_output.= "<h3>".$msgstr["loans"]."</h3><hr>";
		$ec_output.= "<table class='table striped'>";
		$ec_output.= "<tr><th>#</th><th>".$msgstr["inventory"]."</th><th>".$msgstr["control_n"]."</th><th>".$msgstr["reference"]."</th><th>".$msgstr["typeofitems"]."</th><th>".$msgstr["loandate"]."</th><th>".$msgstr["devdate"]."</th><th>".$msgstr["actual_dev"]."</th><th>".$msgstr["renewals"]."</th></tr>";

		foreach ($prestamos as $linea) {
			if (trim($linea)!=""){
				$p=explode("^",$linea);

				if (isset($p[0])) $p0=$p[0]; else $p0=""; 
				if (isset($p[2])) $p2=$p[2]; else $p2="";
				if (isset($p[3])) $p3=$p[3]; else $p3="";
				if (isset($p[4])) $p4=$p[4]; else $p4="";
				if (isset($p[5])) $p5=$p[5]; else $p5="";
				if (isset($p[11])) $p11=$p[11]; else $p11="";
				if (isset($p[12])) $p12=$p[12]; else $p12="";
				if (isset($p[13])) $p13=$p[13]; else $p13="";
				if (isset($p[18])) $p18=$p[18]; else $p18="";				

				$np=$np+1;
				$fuente="";
				$mora=0;
				if ($p[16]=="P"){
					$dif= compareDate_reports ($p[5]);
					$fuente="";
					$mora="0";
					if ($dif<0) {
						$nv=$nv+1;
						$mora=abs($dif/(60*60*24));    //cuenta de préstamos vencidos
				    	$fuente="<font color=red>";
					}
				}
				$ec_output.= "<tr><td valign=top>";
				if ($p[16]=="P")
					$ec_output.=$msgstr["loaned"];
				else
					$ec_output.=$msgstr["returned"];



				$ec_output.="</td>
					<td nowrap align=center valign=top>".$p0."</td>".
					"<td nowrap align=center valign=top>".$p12."(".$p13.")</td><td valign=top>".$p2."</td><td align=center valign=top>". $p3. "</td><td nowrap align=center valign=top>".$p4."</td><td nowrap align=center valign=top>$fuente".$p5."</td><td align=center valign=top>". $p18."</td><td align=center valign=top>". $p11."</td></tr>";
        	}
		}
		$ec_output.= "</table></dd>";
	}
    $Expr_b= "TRANS_S_".$arrHttp["usuario"]." or TRANS_M_".$arrHttp["usuario"]." or TRANS_N_".$arrHttp["usuario"];
	


	include("sanctions_read.php");

	if ($sanctions_output!=""){
		if ($nmulta=!0 or $nsusp!=0) //$ec_output.="<h3 class='color-red'><strong>".$msgstr["pending_sanctions"]."</strong></h3>";
		$ec_output.=$sanctions_output;
	}

$reserves="";
if (!isset($reserve_active) or isset($reserve_active)and $reserve_active!="N"){
	$reserves_arr=ReservesRead("CU_".$arrHttp["usuario"],"N"," ");
	$reserves=$reserves_arr[0];
	if (trim($reserves)!=""){
		 $reserves="<p><strong>".$msgstr["reserves"]."</strong>".$reserves;
	}
}

ProduceOutput($ec_output.$reserves);


//=====================================================================================


function ProduceOutput($ec_output){
global $msgstr,$arrHttp,$reservas_p,$signatura,$posicion_cola,$msg_1,$cont,$institution_name,$db_path;
?>
<script language="JavaScript" type="text/javascript"  src="../dataentry/js/lr_trim.js"></script>
<body>
<button class='bt bt-blue' onclick="window.print()"><i class="fas fa-print"></i> <?php echo $msgstr['print']?></button>
<form name=ecta>
<?php
echo $ec_output;
}  //END FUNCTION PRODUCEOUTPUT
?>