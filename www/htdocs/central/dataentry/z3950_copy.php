<?php
/**    modificado
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      z3950_copy.php
 * @desc:      Copy the selected record from Z39.50 search and applys the conversion format (if any)
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
include ("../config.php");

include("../lang/dbadmin.php");

include("../lang/soporte.php");

$lang=$_SESSION["lang"];
$Permiso=$_SESSION["permiso"];
$VC=explode("\n",$arrHttp["ValorCapturado"]);
$ValCap="";
foreach ($VC as $campo){
	if (trim($campo)!=""){		$ix=strpos($campo," ");
		$tag=trim(substr($campo,0,$ix));
		$campo=substr($campo,$ix+1);
		$ValCap.="<".$tag." 0>$campo</$tag>";
	}}

$ValCap=urlencode($ValCap);
$ValorCapturado=urlencode($arrHttp["ValorCapturado"]);

if (isset($arrHttp["Mfn"]))
	$Mfn=$arrHttp["Mfn"];
else
	$Mfn="New";
if (!isset($arrHttp["cnvtab"])){
// if no conversion

	header("Location:fmt.php?Opcion=capturar&ver=N&Mfn=$Mfn&base=".$arrHttp["base"]."&cipar=".$arrHttp["cipar"]."&ValorCapturado=".$ValorCapturado);
	die;
}
$file=$db_path.$arrHttp["base"]."/def/".$arrHttp["cnvtab"];
if (!file_exists($file)) {	header("Location:fmt.php?Opcion=capturar&ver=N&Mfn=$Mfn&base=".$arrHttp["base"]."&cipar=".$arrHttp["cipar"]."&ValorCapturado=".$ValorCapturado);
	die;}
$fp=file($file);
$Pft="";
foreach ($fp as $value) {	$value=trim($value);	if ($value!=""){		$ix=strpos($value,':');
		$Pft.="'$$^^$$".substr($value,0,$ix).":'".substr($value,$ix+1)."/";
	}
}
$IsisScript=$xWxis."z3950_cnv.xis";
$Pft=urlencode($Pft);
$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&ValorCapturado=".$ValCap."&Pft=$Pft";
include("../common/wxis_llamar.php");

//foreach ($contenido as $value)  echo "$value<br>";die;

$res=implode("\n",$contenido);
$res=explode('$$^^$$',$res);
$ValorCapturado="";
$tag="";
foreach ($res as $value){	$ixpos=strpos($value,':');
	$tag=substr($value,0,$ixpos);
	$campo=substr($value,$ixpos+1);
	$c=explode("\n",$campo);
	foreach($c as $val){
		$val=trim($val);
		if ($val!=""){			$campo=$tag." ".$val;
			if ($ValorCapturado==""){				$ValorCapturado=$campo;
			}else{				$ValorCapturado.="\n".$campo;			}		}	}}
$ValorCapturado=urlencode($ValorCapturado);
header("Location:fmt.php?Opcion=capturar&ver=N&Mfn=$Mfn&base=".$arrHttp["base"]."&cipar=".$arrHttp["cipar"]."&ValorCapturado=".$ValorCapturado);
die;
?>