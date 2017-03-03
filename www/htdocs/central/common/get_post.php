<?php
if (!isset($SESSION["super_user"]))  $_SESSION["super_user"]="";
$arrHttp=array();
if (isset($_GET)){
	foreach ($_GET as $var => $value) {
		if (trim($value)!="") $arrHttp[$var]=$value;
		}
}
if (isset($_POST)){
	foreach ($_POST as $var => $value) {
		if (trim($value)!="") $arrHttp[$var]=$value;
	}
}
//$fp=fopen("/abcd/www/scripts","a");
//fwrite($fp,$_SERVER["PHP_SELF"]."\n");
//fclose($fp);
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";




?>