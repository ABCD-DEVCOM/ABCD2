<html>
<head>
<title>Folleteria</title>
<style>
BODY {	font-family:  Arial, Verdana, Helvetica;
	font-size: 10px;
}
td {	font-family:  Arial, Verdana, Helvetica;
	font-size: 10px;}
</style>
</head>
<body>
<?php
set_time_limit(0);
include ("../config.php");
$db_path="e:/bases_abcd/alvaro/";
$base="folleteria";
$file=$db_path.$base."/dr_path.def";
if (!file_exists($file)){	echo $file." no existe";
	die;}
$def = parse_ini_file($file);
$img_path=trim($def["ROOT"]);
function LlamarWxis($base,$ValorCapturado,$IsisScript,$query){
global $arrHttp,$xWxis,$wxisUrl,$OS,$db_path,$Wxis;
	include("../common/wxis_llamar.php");
	return ($contenido);
}
$IsisScript=$xWxis."leer_mfnrange.xis";
$query = "&base=".$base ."&cipar=$db_path"."par/".$base.".par&from=1&to=1651&Pft=f(mfn,1,0)'|'v12'|'v800^a'|'v810^a'|'v800^b'|'v810^b/";
$contenido=LlamarWxis($base,"",$IsisScript,$query);
foreach ($contenido as $value) {
	$value=trim($value);
	if ($value!=""){		$value=trim($value);		$v=explode('|',$value);
		$folleto[$v[1]]=$value;	}}/*
print('<xmp>');
print_r($folleto);
print('</xmp>');
*/
if( $_SERVER['SERVER_NAME']=="localhost"){	$http_dir="http://localhost:9090/";
}else{	$http_dir="http://abcdwiki.net/ABCD/";}
ksort($folleto);
echo "<table align=center>";
foreach ($folleto as $value){	$v=explode('|',$value);
	echo "<tr><td valign=top>";
	echo $v[0]."</td><td width=600px>".$v[1]."</td>";
	echo "<td valign=top>";
	$l1=round($v[4]/1000);
	$l2=round($v[5]/1000);
	if (file_exists($img_path."cl/".$v[2])){		echo "<a href=$http_dir"."central/common/show_image.php?base=folleteria&image=cl/".str_replace(" ","+",$v[2]);
		echo " target=_blank>cl (".$l1." kb)</a>";	}else{		echo "<font color=red>**</font>";	}
	echo "</td><td valign=top>";
	if (file_exists($img_path."bn/".$v[3])){
		echo "<a href=$http_dir"."central/common/show_image.php?base=folleteria&image=bn/".str_replace(" ","+",$v[3]);
		echo " target=_blank>bn (".$l2." kb)</a>";
	}else{
		echo "<font color=red>**</font>";
	}
	echo "</td>";}
echo "</table>";
?>
