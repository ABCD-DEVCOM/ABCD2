<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      ec_include.php
 * @desc:      Display the user statment
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
// se determina si el préstamo está vencido
function compareDate ($FechaP,$lapso_p){
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

	$ixTime=strpos($FechaP," ");
	if ($lapso_p=="H") {		$exp_date.=substr($FechaP,$ixTime);
		$todays_date = date("Y-m-d h:i A");	}else{		$todays_date = date("Y-m-d");	}
	$today = strtotime($todays_date);
	$expiration_date = strtotime($exp_date);
	$diff=$expiration_date-$today;
	return $diff;

}//end Compare Date

include ("dias_vencimiento.php");
if (isset($arrHttp["usuario"])){
// se presenta la  información del usuario
	$formato_us="";
	if (isset($arrHttp["vienede"]) and $arrHttp["vienede"]=="ecta_web"){		$formato_us=$db_path."users/loans/".$_SESSION["lang"]."/loans_usdisp_web.pft";
		if (!file_exists($formato_us)) $formato_us="";
	}
	if ($formato_us==""){
		$formato_us=$db_path."users/loans/".$_SESSION["lang"]."/loans_usdisp.pft";
	    if (!file_exists($formato_us)) $formato_us=$db_path."users/loans/".$lang_db."/loans_usdisp.pft";
	}
   	$query = "&Expresion=".trim($uskey).$arrHttp["usuario"]."&base=users&cipar=$db_path/par/users.par&Formato=".$formato_us;
	$contenido="";
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	if (isset($arrHttp["vienede"]) and $arrHttp["vienede"]=="ecta_web"){		$c=implode("\n",$contenido);
		if (trim($c)=="")
			$ec_output="**";	}
	if ($ec_output!="**"){
		if (isset($arrHttp["reserve"])){
			$ec_output.="<table border=0>";
			$ec_output.="<td align=right valign=top>";
			$ec_output.="<br>".$msgstr["reserve"];
			$copies="";
			$ec_output.=SeleccionarBaseDeDatos($db_path,$msgstr);
			$ec_output.="<br><a href=\"javascript:Reservar('".$arrHttp["usuario"]."')\">
								".$msgstr["reserve"]."
							</a>";
			$ec_output.="</td><td>";
		}
		foreach ($contenido as $linea){			$ec_output.= $linea."\n";
		}
	    if (isset($arrHttp["reserve"])){
			$ec_output.="</td></table>";
		}
		$ec_output.="\n<script>nMultas=0;nSusp=0;nNota=0;</script>\n" ;
		include("sanctions_read.php");
		$ec_output.=$sanctions_output;

	//	foreach ($prestamo as $linea) echo "$linea<br>";
	    $permitir_prestamo="S";
	// se leen los prestamos pendientes
		$formato_obj=$db_path."trans/pfts/".$_SESSION["lang"]."/loans_display.pft";
	    if (!file_exists($formato_obj)) $formato_obj=$db_path."trans/pfts/".$lang_db."/loans_display.pft";
	   	$query = "&Expresion=TRU_P_".$arrHttp["usuario"]."&base=trans&cipar=$db_path"."par/trans.par&Pft=v40'$$$',@".$formato_obj;
		$IsisScript=$xWxis."cipres_usuario.xis";
		include("../common/wxis_llamar.php");
		$prestamos=array();
		foreach ($contenido as $linea){
			if (trim($linea)!=""){				$prestamos[]=$linea;
			}
		}
		$nv=0;   //número de préstamos vencidos
		$np=0;   //Total libros en poder del usuario
	   // echo "<pre>".print_r($politica);
		if (count($prestamos)>0) {			$ec_output.= "\n<strong>".$msgstr["loans"]."</strong>
			<table width=100% bgcolor=#cccccc>
			<td> </td><th>".$msgstr["inventory"]."</th><th>".$msgstr["control_n"]."</th><th>".$msgstr["reference"]."</th><th>".$msgstr["typeofitems"]."</th><th>".$msgstr["loandate"]."</th><th>".$msgstr["devdate"]."</th><th>".$msgstr["overdue"]."</th><th>".$msgstr["renewed"]."</th>\n";
	        $xnum_p=0;
	        $total_politica=array();
			foreach ($prestamos as $linea) {
				if (trim($linea)!=""){
					$array_p=explode('$$$',$linea);
					$Fecha_vencimiento=$array_p[0];
					$p=explode("^",$array_p[1]);
					//SI LA POLITICA SE GRABÓ CON EL REGISTRO DE LA TRANSACCION, ENTONCE SE APLICA ESA
					// DE OTRA FORMA SE UBICA LA POLÍTICA LEÍDA DE LA TABLA
					if (isset($p[17]) and trim($p[17])!=""){						$politica_este=explode('|',$p[17]);
						$politica_str=$p[17];
					}else{
						$politica_este=explode('|',$politica[strtoupper($p[3])][strtoupper($p[6])]);
						$politica_str=$politica[strtoupper($p[3])][strtoupper($p[6])];					}
	                $lapso_p=$politica_este[5];
	                $obj_ec=strtoupper($politica_este[0]);
	                if (isset( $total_politica[$obj_ec]))
	                	$total_politica[$obj_ec]= $total_politica[$obj_ec]+1;
	                else
	                	$total_politica[$obj_ec]=1;
	                #if ($lapso_p=="") $lapso_p="D";

					$mora=0;
					$fuente="";
	                if ($p[3]!="0"){
						$dif= compareDate ($p[5],$lapso_p);
						$fuente="";
						$mora="0";
						if ($dif<0) {
							if ($lapso_p=="D"){								$mora=floor(abs($dif)/(60*60*24));    //cuenta de préstamos vencidos							}else{
								$fulldays=floor(abs($dif)/(60*60*24));
								$fullhours=floor((abs($dif)-($fulldays*60*60*24))/(60*60));
								$fullminutes=floor((abs($dif)-($fulldays*60*60*24)-($fullhours*60*60))/60);
								$mora=$fulldays*24+$fullhours;
								//echo "<br>** $fulldays, $fullhours , $fullminutes";
							}
						    $fuente="<font color=red>";
						    if ($mora>0){
						    	if ($politica_este[12]!="Y") $nv=$nv+1;						    }
						}
					}

					$ec_output.= "\n<tr><td  bgcolor=white valign=top nowrap>";

					if (!isset($_SESSION["library"])or (isset($_SESSION["library"]) and substr($p[0],0,strlen($_SESSION["library"]))==$_SESSION["library"])) {
						$xnum_p++;
						$np=$np+1;
						$ec_output.="$xnum_p";
						$ec_output.= "<input type=radio name=chkPr_".$xnum_p." value=$mora  id='".$p[0]."'>";
						$ec_output.= "<input type=hidden name=politica value=\"".$politica_str."\"> \n";

					}


					$ec_output.="</td>

						<td bgcolor=white nowrap align=center valign=top>".$p[0]."</td>".
						"<!--td bgcolor=white nowrap align=center valign=top>".$p[14]."</td>".
						"<td bgcolor=white nowrap align=center valign=top>".$p[15]."</td -->".
						"<td bgcolor=white nowrap align=center valign=top>".$p[12]."(".$p[13].")</td><td bgcolor=white valign=top>".$p[2];
						if (isset($p[19]) and $p[19]!="") $ec_output.= "<br><Font color=darkred>".$p[19]."</font>";
						$ec_output.="</td><td bgcolor=white align=center valign=top>". $p[3]. "</td><td bgcolor=white nowrap align=center valign=top>".$p[4]."</td><td nowrap bgcolor=white align=center valign=top>$fuente";
						 if ($lapso_p=="D"){						 	$ixd=strpos($p[5]," ");
						 	if ($ixd>0){
						 		$ec_output.=  trim(substr($p[5],0,$ixd));
							}else{
						 		$ec_output.=  $p[5];
							}						 }else{						 	$ec_output.=  $p[5];						 }
						 if ($mora>0){
							if ($CALENDAR_S=="Y"){
								$now = date("Ymd"); // or your date as well
								$fecha_d=$p[5];
								$ix=strpos($fecha_d," ");
								if ($ix>0)
									$fecha_d=substr($fecha_d,0,$ix);
								$datediff = strtotime($now) - strtotime($fecha_d);
								$dias_vencido= floor($datediff/(60*60*24));
							}else{						 		$dias_vencido=DiasVencimiento($Fecha_vencimiento);
							}						 }else{						 	$dias_vencido=0;						 }
						 $ec_output.=  "</td><td align=center bgcolor=white valign=top>".$dias_vencido." ".$lapso_p."</td><td align=center bgcolor=white valign=top>". $p[11]."</td></tr>\n";
	        	}
			}
			$ec_output.= "</table>\n";

			$ec_output.= "</dd>";
	        $ec_output.= "<script>
			np=$np
			nv=$nv
			</script>\n";
		}
	}

}



?>