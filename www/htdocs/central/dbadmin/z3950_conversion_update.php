<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      z3950_conversion_update.php
 * @desc:      Creates in the def folder a conversion table from z39.50
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
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
//die;
if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";
$lang=$_SESSION["lang"];
$tag=array();
$pft=array();
foreach ($arrHttp as $var=>$value) {	$value=trim($value);	if (substr($var,0,3)=="tag") {		$ix=substr($var,3);
		if (isset($arrHttp["formato".$ix]))
			if (trim($arrHttp["formato".$ix])!="") $pft[$value]=stripslashes($arrHttp["formato".$ix]);
	}}
$file=$db_path.$arrHttp["base"]."/def/".$arrHttp["namecnvtb"];
$fp=fopen($file,"w");
if (!$fp){
	echo $arrHttp["namecnvtb"];	echo $msgstr["nopudoseractualizado"];
	die;}
foreach ($pft as $tag=>$value){	fwrite($fp,$tag.":".$value."\n");
}
fclose($fp);
$add="Y";
$fp=array();
if (file_exists($db_path.$arrHttp["base"]."/def/z3950.cnv")){	$fp=file($db_path.$arrHttp["base"]."/def/z3950.cnv");
	foreach ($fp as $value){		$t=explode('|',$value);
		if ($t[0]==$arrHttp["namecnvtb"]){			$add="N";
			break;		}	}}

if ($add=="Y"){
	$out=fopen($db_path.$arrHttp["base"]."/def/z3950.cnv","w");	foreach ($fp as $value){		$res=fwrite($out,$value);	}
	$res=fwrite($out,$arrHttp["namecnvtb"].'|'.$arrHttp["descr"]."\n");
	fclose($out);}

include("../common/header.php");
echo "<body>";
if (isset($arrHttp["encabezado"])){
    	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{
	$encabezado="";
}
echo "
	<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".$msgstr["z3950"].": ".$msgstr["z3950_cnv"]." (".$arrHttp["base"].")</div>
	<div class=\"actions\">\n";
echo "<a href=z3950_conf.php?base=^a". $arrHttp["base"].$encabezado." class=\"defaultButton backButton\">
	<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
		<span><strong>". $msgstr["back"]."</strong></span>
		</a>
		</div>
			<div class=\"spacer\">&#160;</div>
		</div>";
echo "<div class=\"middle form\">
			<div class=\"formContent\">";
echo "<font size=1 face=arial> &nbsp; &nbsp; Script: z3950_conversion_update.php</font>";
echo "<center><h4>".$arrHttp["base"]."/def/z3950.cnv: ".$msgstr["updated"];
echo "</h4></center></div></div>";
include("../common/footer.php");
echo "</body>
</html>";
?>