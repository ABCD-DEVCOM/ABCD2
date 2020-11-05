<?php
if (!isset($SESION["super_user"]))  $_SESSION["super_user"]="";
$arrHttp=array();
//include("validar_request.php");
foreach ($_REQUEST as $var => $value) {
	if (trim($value)!="") $arrHttp[$var]=$value;
}

//$fp=fopen("/abcd/www/scripts","a");
//fwrite($fp,$_SERVER["PHP_SELF"]."\n");
//fclose($fp);
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";




?>