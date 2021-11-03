<?php
/*
20211102 fho4abcd Check for array variables (will not be entered in $arrHttp)
*/
if (!isset($SESION["super_user"]))  $_SESSION["super_user"]="";
$arrHttp=array();
//include("validar_request.php");
foreach ($_REQUEST as $var => $value) {
	if ( !is_array($value) AND trim($value)!="") $arrHttp[$var]=$value;
}
?>