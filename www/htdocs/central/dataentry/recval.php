<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      recval.php
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
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

global $ValorCapturado,$arrHttp;
include("../common/get_post.php");
include ("../config.php");

include("../lang/admin.php");

include("actualizarregistro.php");
require_once ('plantilladeingreso.php');


function VariablesDeAmbiente($var,$value){
global $arrHttp;


		if (substr($var,0,3)=="tag") {
			$ixpos=strpos($var,"_");
			if ($ixpos!=0) {
				$occ=explode("_",$var);
				if (trim($value)!=""){
					$value="^".trim($occ[2]).$value;
					$var=$occ[0]."_".$occ[1];
					if (is_array($value)) {
						$value = implode("\n", $value);
					}
					if (isset($arrHttp[$var])){
						$arrHttp[$var].=$value;
					}else{
						$arrHttp[$var]=$value;
					}
				}
			}else{
				if (is_array($value)) {
			   		$value = implode("\n", $value);
				}
				if (isset($arrHttp[$var])){
					$arrHttp[$var].="\n".$value;
				}else{
					$arrHttp[$var]=$value;
				}
			}
		}else{
			if (trim($value)!="") $arrHttp[$var]=$value;
		}
}


foreach ($arrHttp as $var => $value) {
	if (substr($var,0,3)=="tag" ){

		$tag=explode("_",$var);
		if (substr($var,0,3)=="sta" ){
			$tag[0]="tag".substr($tag[0],3);
		}
		if (isset($variables[$tag[0]])){

			$variables[$tag[0]].="\n".$value;
			$valortag[substr($tag[0],3)].="\n".$value;
		}else{
			$variables[$tag[0]]=$value;
			$valortag[substr($tag[0],3)]=$value;
		}
   	}

}

$tag=array();
$pft=array();
echo $tm."-".$nr;
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".val";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".val";
$rec_validation="";
if (file_exists($archivo)){
	$fp = file($archivo);
	foreach($fp as $value){		$value=trim($value);
		if ($value!="") {
			$value=str_replace('/',"\n",$value);
			$ix=strpos($value,':');
			if ($ix===false){

			}else{
				$tag_val=substr($value,0,$ix-1);
				$rec_validation.=substr($value,$ix+1)." / "  ;
			}
		}
	}

}
$base=$arrHttp["base"];
$arrHttp["cipar"]="$base.par";
$archivo=$db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/".$arrHttp["base"].".fdt";
if (!file_exists($archivo)) $archivo=$db_path.$arrHttp["base"]."/def/".$lang_db."/".$arrHttp["base"].".fdt";
$fp=file($archivo);
global $vars;
$ix=-1;
foreach ($fp as $value){

	$ix=$ix+1;
	$vars[$ix]=$value;
}
ActualizarRegistro();

$formato=urlencode($rec_validation);
$ValorCapturado=urlencode($ValorCapturado);
$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&ValorCapturado=$ValorCapturado&Pft=".$formato."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"];
$IsisScript=$xWxis."validar_registro.xis";
include("../common/wxis_llamar.php");
?>
<html>
<title>Record validation</title>

<body>
<?

echo "<span class=title>".$msgstr["rval"]."</span>";
echo "<font size=1 face=arial> &nbsp; &nbsp; Script: dataentry/recval.php</font><p>";
$recval_pft="";
foreach ($contenido as $linea)	{	if (strpos($linea,'execution error')===false)
    	if (trim($linea)!="")$recval_pft.=$linea."\n";
    else{
    	echo $linea;
    	die;
    }}
echo "<span class=textbody03>";
echo nl2br($recval_pft);
echo "</body>
</html>";
?>