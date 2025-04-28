<?php
/*
20211102 fho4abcd Check for array variables (will not be entered in $arrHttp)
20220620 fho4abcd removed (wrong) code for (non-existing) super_user
*/
$arrHttp=array();
//include("validar_request.php");
foreach ($_REQUEST as $var => $value) {
	if ( !is_array($value) AND trim($value)!="") $arrHttp[$var]=$value;
}
?>