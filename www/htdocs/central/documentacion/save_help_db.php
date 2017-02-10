<?php

$arrHttp=Array();
include("../common/get_post.php");
include("../config.php");
include("../lang/dbadmin.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$salida=$arrHttp["FCK"];
$salida=stripslashes($salida);
$archivo=$arrHttp["archivo"];
$ix=strripos($archivo,'/');
$ar=substr($archivo,0,$ix);
if (!file_exists($ar)) {	echo "<h4>"."$ar:  ".$msgstr["folderne"]."</h4>";
	die;}
$fp = fopen($archivo, "w", 0); #open for writing
  fputs($fp, $salida); #write all of $data to our opened file
  fclose($fp); #close the file

	echo $salida;






?>