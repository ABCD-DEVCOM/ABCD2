<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      valida_rotulos.php
 * @desc:
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
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("rotulos2tags.php");


//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";


include("../lang/admin.php");

include("../common/header_display.php");

//foreach ($arrHttp as $var=>$value)	echo "$var = $value<br>";
// Se lee la tabla de conversión de los rótulos

$base=$arrHttp["base"];
Global $separador;
	$fp=file($db_path."$base/cnv/".$arrHttp["cnv"]);
	$ix=-1;
	foreach($fp as $value){
		if (substr($value,0,2)<>'//'){
			if ($ix==-1){
				$separador=trim($value);
				$ix=0;
			}else{
				$ix=$ix+1;
				$t=explode('|',$value);
				$t[1]=trim($t[1]);
				$t[0]=trim($t[0]);
				//echo $t[0]."=".$t[1]."<br>";
				$rotulo[$t[1]][0]=$t[0];
				$rotulo[$t[1]][1]=$t[1];
				$rotulo[$t[1]][2]=$t[2];
				if (isset($t[3])) $rotulo[$t[1]][3]=$t[3];
				if (isset($t[4])) $rotulo[$t[1]][4]=$t[4];
			}
		}
	}



$variables=explode('##',$arrHttp["Texto"]);

foreach($variables as $registro){
	$noLocalizados="";
	$salida=Rotulos2Tags($rotulo,$registro);
	if (count($salida)>0){
		echo "<p><b>Registro nuevo:</b> <br><font color=red><b>Rótulos localizados:</b></font color=black><br>";
		foreach ($salida as $key=>$value){
			 foreach ($value as $campo){
			 	 echo $rotulo[$key][0]." ".$campo."<br>";
			 }
		}
	}
	if (trim($noLocalizados)!="") {
		echo "<font color=red><b>Rótulos no localizados:</b></font color=black><br>";
		echo nl2br($noLocalizados);
	}
}
?>