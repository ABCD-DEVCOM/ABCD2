<?php
session_start();
include("../common/get_post.php");
include ("../config.php");
$lang=$arrHttp["lang"];
$_SESSION["lang"]=$lang;
include("../lang/dbadmin.php");;
if (!isset($arrHttp["archivo"])) die;
$fp=file("../../dbpath.dat");
if (!$fp)    {	echo "dbpath.dat no existe";
	die;}
$db_path="";
foreach ($fp as $value){	if (strpos($value,"/".$arrHttp["dbdir"]."/")!==false){		$db_path=$value;
		break;	}}
if ($db_path==""){	echo "error";
	die;}
$d=explode("|",$db_path);
$db_path=$d[0];
$archivo=$db_path.$arrHttp["archivo"];
?>
<html>
<body>
<font face=verdana>
<?
if (!file_exists($archivo)){	echo $arrHttp["archivo"]." ".$msgstr["ne"];
}else{
	$fp=file($archivo);
	echo "<h5>".$arrHttp["archivo"]."</h5>
	<xmp>";

	foreach ($fp as $value) echo $value;
	echo "</xmp>";
}
?>
</body>
</html>
