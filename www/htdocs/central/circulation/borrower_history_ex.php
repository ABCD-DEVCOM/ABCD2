<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
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

// se determina si el préstamo está vencido
function compareDate ($FechaP){
global $locales,$config_date_format;
//Se convierte la fecha a formato ISO (yyyymmaa) utilizando el formato de fecha local
	$f_date=explode('/',$config_date_format);
	switch ($f_date[0]){
		case "DD":
			$dia=substr($FechaP,0,2);
			break;
		case "MM":
			$mes=substr($FechaP,0,2);
			break;
	}
	switch ($f_date[1]){
		case "DD":
			$dia=substr($FechaP,3,2);
			break;
		case "MM":
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
			$dia=substr($FechaP,6,2);
			break;
		case "MM":
			$mes=substr($FechaP,6,2);
			break;
	}
	switch ($df[1]){
		case "DD":
			$dia=substr($FechaP,4,2);
			break;
		case "MM":
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
		$ec_output.= "<strong>".$msgstr["loans"]."</strong>
		<table width=95% bgcolor=#cccccc>
		<td> </td><th>".$msgstr["inventory"]."</th><th>".$msgstr["control_n"]."</th><th>".$msgstr["reference"]."</th><th>".$msgstr["typeofitems"]."</th><th>".$msgstr["loandate"]."</th><th>".$msgstr["devdate"]."</th><th>".$msgstr["actual_dev"]."</th><th>".$msgstr["renewals"]."</th>";

		foreach ($prestamos as $linea) {			if (trim($linea)!=""){
				$p=explode("^",$linea);

				$np=$np+1;
				$fuente="";
				$mora=0;
				if ($p[16]=="P"){
					$dif= compareDate ($p[5]);
					$fuente="";
					$mora="0";
					if ($dif<0) {
						$nv=$nv+1;
						$mora=abs($dif/(60*60*24));    //cuenta de préstamos vencidos
				    	$fuente="<font color=red>";
					}
				}
				$ec_output.= "<tr><td  bgcolor=white valign=top>";
				if ($p[16]=="P")
					$ec_output.=$msgstr["loaned"];
				else
					$ec_output.=$msgstr["returned"];
				$ec_output.="</td>

					<td bgcolor=white nowrap align=center valign=top>".$p[0]."</td>".
					"<td bgcolor=white nowrap align=center valign=top>".$p[12]."(".$p[13].")</td><td bgcolor=white valign=top>".$p[2]."</td><td bgcolor=white align=center valign=top>". $p[3]. "</td><td bgcolor=white nowrap align=center valign=top>".$p[4]."</td><td nowrap bgcolor=white align=center valign=top>$fuente".$p[5]."</td><td align=center bgcolor=white valign=top>". $p[18]."</td><td align=center bgcolor=white valign=top>". $p[11]."</td></tr>";
        	}
		}
		$ec_output.= "</table></dd>";
	}
    $Expr_b= "TRANS_S_".$arrHttp["usuario"]." or TRANS_M_".$arrHttp["usuario"]." or TRANS_N_".$arrHttp["usuario"];
	include("sanctions_read.php");

	if ($sanctions_output!=""){		$ec_output.="<font color=red><strong>".$msgstr["pending_sanctions"]."</strong></font>";
		$ec_output.=$sanctions_output;	}

$reserves="";
if (!isset($reserve_active) or isset($reserve_active)and $reserve_active!="N"){
	$reserves_arr=ReservesRead("CU_".$arrHttp["usuario"],"N"," ");
	$reserves=$reserves_arr[0];
	if (trim($reserves)!=""){		 $reserves="<p><strong>".$msgstr["reserves"]."</strong>".$reserves;	}
}

ProduceOutput($ec_output.$reserves);


//=====================================================================================


function ProduceOutput($ec_output){
global $msgstr,$arrHttp,$reservas_p,$signatura,$posicion_cola,$msg_1,$cont,$institution_name,$db_path;
	include("../common/header.php");
    echo "<body>";
 	include("../common/institutional_info.php");
?>
<script  src="../dataentry/js/lr_trim.js"></script>
<body>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["bo_history"]?>
	</div>
	<div class="actions">
		<?php include("submenu_prestamo.php");?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<div class="helper">
<?php echo "
<a href=../documentacion/ayuda.php?help=". $_SESSION["lang"]."/circulation/borrower_history.html target=_blank>". $msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
    echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/circulation/borrower_history.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: borrower_history_ex.php </font>
	</div>";
// prestar, reservar o renovar
?>
<div class="middle form">
	<div class="formContent">
<form name=ecta>
<?php
echo $ec_output;
echo "</div></div>\n";
include("../common/footer.php");
echo "</body>
</html>" ;
}  //END FUNCTION PRODUCEOUTPUT
?>