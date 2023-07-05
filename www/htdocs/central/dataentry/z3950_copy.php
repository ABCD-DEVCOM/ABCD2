<?php
/* Modifications
20220711 fho4abcd Use $actparfolder as location for .par files
20230705 fho4abcd Process ignore fields table.In case of wxis errors "die" to show the error
*/
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
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
$lang=$_SESSION["lang"];
$Permiso=$_SESSION["permiso"];
// Remove entries with numbers in the ignorefields table
if (isset($arrHttp["igntab"])) {
    $archivo=$db_path.$arrHttp["base"]."/def/".$arrHttp["igntab"];
	if (file_exists($archivo)){
        $fields=file($archivo,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
    $VC=explode("\n",$arrHttp["ValorCapturado"]);
    $Val="";
    foreach ($VC as $campo){
        if (trim($campo)!=""){
            $ix=strpos($campo," ");
            $tag=trim(substr($campo,0,$ix));
            if (!in_array($tag,$fields)){
                $Val.=$campo."\n";
            }
        }
    }
    $arrHttp["ValorCapturado"]=$Val;
}
// Copy the data to the database
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

// if no conversion
if (!isset($arrHttp["cnvtab"])){
	header("Location:fmt.php?Opcion=capturar&ver=N&Mfn=$Mfn&base=".$arrHttp["base"]."&cipar=".$arrHttp["cipar"]."&ValorCapturado=".$ValorCapturado);
	die;
}

// check existence of conversion file
$file=$db_path.$arrHttp["base"]."/def/".$arrHttp["cnvtab"];
if (!file_exists($file)) {	header("Location:fmt.php?Opcion=capturar&ver=N&Mfn=$Mfn&base=".$arrHttp["base"]."&cipar=".$arrHttp["cipar"]."&ValorCapturado=".$ValorCapturado);
	die;}

// Convert the data
$fp=file($file);
$Pft="";
foreach ($fp as $value) {	$value=trim($value);	if ($value!=""){		$ix=strpos($value,':');
		$Pft.="'$$^^$$".substr($value,0,$ix).":'".substr($value,$ix+1)."/";
	}
}
$IsisScript=$xWxis."z3950_cnv.xis";
$Pft=urlencode($Pft);
$query = "&base=".$arrHttp["base"] ."&cipar=$db_path".$actparfolder.$arrHttp["base"].".par&ValorCapturado=".$ValCap."&Pft=$Pft";
include("../common/wxis_llamar.php");
if ($err_wxis!="") {
    die;
}
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