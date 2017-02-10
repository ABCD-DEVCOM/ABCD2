<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      bloquear_registro.php
 * @desc:      Read and lock a record
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
include("../common/get_post.php");
include("../config.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";

// se lee el registro para verificar si está disponible. En caso afirmativo, se bloquea
	$IsisScript=$xWxis."editar.xis";
   	$query =  "&cipar=$db_path"."par/".$arrHttp["base"].".par&Mfn=" . $arrHttp["Mfn"] ."&userid=".$_SESSION["login"];
	include("../commmon/wxis_llamar.php");
   	$tag= "";
   	$ic=-1;
	foreach ($contenido as $linea){
		echo "$linea<br>";
		if ($ic==-1){
			$mfn=$linea;
			$ic=2;
		}else{
			$linea=trim($linea);

			if ($linea!=""){

				$pos=strpos($linea, " ");
				if (is_integer($pos)) {
					$tag=substr($linea,0,$pos);

//
//El formato ALL envía un <br> al final de cada línea y hay que quitarselo
//
					$linea=rtrim(substr($linea, $pos+2,strlen($linea)-($pos+2)-5));

					if (isset($valortag[$tag])){
						$valortag[$tag].=$linea."\n";
					}else {
						$valortag[$tag]=$linea."\n";
					}

				}
			}
		}
	}

	$tag="1002";
	if (isset($valortag["1002"])) $maxmfn=$valortag["1002"];

echo "<script>
		top.PrenderEdicion()\n";

	echo "</script>\n";




?>