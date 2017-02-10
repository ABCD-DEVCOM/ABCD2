<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      fecha_de_devolucion.php
 * @desc:      Return date calculation
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
//Se calcula la fecha de devolución, tomando en cuenta los días feriados
function FechaDevolucion($lapso,$unidad,$fecha_inicio){
global $feriados,$locales,$notrabaja,$config_date_format,$CALENDAR_S;


	$f_date=explode("/",$config_date_format);
	switch ($unidad){
		case "H":
		//	$date=$timeStamp;
			$newdate = date("Ymd h:i A",strtotime("+$lapso hours"));
        	return $newdate;

			break;
		case "D":
            if ($fecha_inicio==""){
				$dev= date("Y-m-d",strtotime("+0 days"));
	        }else{	        	$dev= date("Y-m-d",strtotime($fecha_inicio."+0 days"));	        }

	        $ix=strpos($dev," ");
	        if (!$ix===false)
	        	$dev=trim(substr($dev,0,$ix));
			break;
	}
    $d=0;
    $df=0;
    $diaFeriado="F";
    $dia_sem="F";
    $timeStamp=strtotime($dev);
    $total_days=-1;
    // se determinan los días feriados
    $ii=0;
    while ($d<$lapso){
    	$ii=$ii+1;
    	if ($ii>5000) {    		echo "check script fecha_devolucion.php";
    		die;    	}
    	$total_days++;
    	$fdev=date("Y-m-d",strtotime($dev."+$total_days days"));
    	$timeStamp=strtotime($fdev);
    	$f=explode('-',$fdev);
    	$mes=$f[1];
    	$dia=$f[2]-1;
    	if (isset($feriados[$mes*1]) and substr($feriados[$mes*1],$dia,1)=="F"){
    		$diaFeriado="F";
    		$df=$df+1;
    		$dia_sem="";
    	}else{
    		$diaFeriado="";
    		// se determina cuáles dias no trabaja la biblioteca
    		$dia_sem=date("w",$timeStamp);
    		if (!isset($locales[$dia_sem]["from"])) {
    			$df=$df+1;
    			$dia_sem="F";
    		}else{    			$d++;    		}
    	}
    }
    $lapso=$lapso+$df-1;

    $dev= date("Ymd h:i:s A",strtotime($dev."+$lapso days"));
	return $dev;

}
?>