<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      opac_reservas.php
 * @desc:      Display the reserves an user has
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
//SI EL ESTADO DE CUENTA SE ESTA CONSULTANDO DESDE EL WEB POR EL USUARIO,
//O SE ESTÁ PRESTANDO EL TÍTULO
// SE OBTIENE LA LISTA DE LAS RESERVAS PENDIENTES
$reserva_output="";

$formato_obj=$db_path."reserve/pfts/".$_SESSION["lang"]."/opac_reserve.pft";
if (!file_exists($formato_obj)) $formato_obj=$db_path."reserve/pfts/".$lang_db."/opac_reserve.pft";
if (!file_exists($formato_obj)) $formato_obj="";
if (isset($arrHttp["vienede"]) and ($arrHttp["vienede"]=="ecta_web" or $arrHttp["vienede"]=="prestamos") and $formato_obj!=""){
	if ($arrHttp["vienede"]=="ecta_web")
		$Expresion="CU_".$arrHttp["usuario"];
	else
		$Expresion="CN_3";

	$query = "&Expresion=$Expresion&base=reserve&cipar=$db_path"."par/reserve.par&Formato=$formato_obj";
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$reservas=array();
	foreach ($contenido as $linea){		$reservas[]=$linea;
	}
	$total_atraso=0;
	$reservas_vencidas="";
	$dias_atraso=0;
	$fecha_inicio="";
	$lista_reservas=array();
	$reserva_output="";
	$reserva_novencidas="";
	if (count($reservas)>0){
		$reserva_output="<strong>".$msgstr["reserves"]."</strong>
			<table bgcolor=#cccccc>
			<th>"."título"."</th><th>".$msgstr["reserve_date"]."</th><th>".$msgstr["reserve_expire"]."</th><th></th>";
		foreach ($reservas as $res){
			if (trim($res)!=""){				$r=explode('|',$res);
				$fecha=$r[1];
				$vence=$r[2];
			 	$difference=compareDate ($r[2]);
			 	$datediff = floor($difference / 86400);
			 	//SE DETERMINA LA FECHA DE VENCIMIENTO MAS RECIENTE PARA
			 	//CALCULAR LA SUSPENSIÓN A PARTIR DE ELLS
			 	$anular="";
			 	if ($datediff>0){			 		$reservas_vencidas="S";
			 		$total_atraso+=1;
			 		$vence="<font color=red>".$r[2]."</font>";
			 		$anular="&nbsp;";

			 	}else{
		 			if ($arrHttp["vienede"]=="ecta_web") $anular="<a href=javascript:AnularReserva(".$r[3].")>".$msgstr["reserve_discard"]."</a>";
			 	}
	            $reserva_output.="<tr><td bgcolor=#FFFFFF>".$r[0]."</td><td bgcolor=#FFFFFF align=center>".$fecha."</td><td bgcolor=white align=center>$vence</td><td bgcolor=#FFFFFF>$anular</td>";
            }
		}
		$reserva_output.="</table>";

	}
}
?>