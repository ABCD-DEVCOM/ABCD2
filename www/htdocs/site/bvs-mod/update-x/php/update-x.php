<?php

define("UPDATE_X","update-x");
define("UPDATE_X_VERSION","0.6");

// declare local variables for $_REQUEST[] parameters (register_globals=off)
$ini =  $_REQUEST['ini'];
$lang = $_REQUEST['lang'];
$user = $_REQUEST['user'];
$edit = $_REQUEST['edit'];
$database = $_REQUEST['database'];
$restriction = $_REQUEST['restriction'];
$column = $_REQUEST['column'];
$order = $_REQUEST['order'];

function UPDATE_X_error ( $message )
{
	header("Content-type: text/plain\n\n");
	print("UPDATE-X " . UPDATE_X_VERSION . "\n\n");
	die($message);
}

function UPDATE_X_fileExists ( $file, $parameter )
{
//	clearstatcache();
	if ( !file_exists($file) )
	{
		UPDATE_X_error('The ' . $parameter . ' file "' . $file . '" was not found!');
		return false;
	}
	
	return true;
}

function UPDATE_X_getIni ( $ini )
{
	if ( !isset($ini) )
	{
		UPDATE_X_error('Please, informe the "ini" parameter!');
	}
	UPDATE_X_fileExists($ini,"ini");
	
	return $ini;
}

function UPDATE_X_getParameter ( $cgiParameter, $ini, $group, $parameter )
{
	$var = INCLUDE_optionalVar($cgiParameter,$ini[$group][$parameter]);
	if ( !isset($var) )
	{
		UPDATE_X_error('Please inform the "' . $group . ' ' . $parameter . '" parameter!');
	}
	
	return $var;
}

function UPDATE_X_getFileParameter ( $cgiParameter, $ini, $group, $parameter )
{
	$fileParameter = UPDATE_X_getParameter($cgiParameter,$ini,$group,$parameter);
	UPDATE_X_fileExists($fileParameter,$group . " " . $parameter);
	
	return $fileParameter;
}

function UPDATE_X_setXml ( $vars, $ini, $data )
{
	$xml  = "<?xml version='1.0' encoding='ISO-8859-1'?>\n";
	$xml .= "<UPDATE-X>\n";
	
	$xml .= "<vars>\n" . INCLUDE_listElements($vars) . "</vars>\n";
	
	$xml .= "<ini>\n";
	reset($ini);
	while ( list($key, $value) = each($ini) )
	{
		$xml .= "<" . $key . ">" . INCLUDE_listElements($value) . "</" . $key . ">\n";
	}
	$xml .= "</ini>\n";
	$xml .= "<data>\n";
	$xml .= $data;
	$xml .= "</data>\n";
	$xml .= "</UPDATE-X>\n";
	
	return $xml;
}

$UPDATE_X_vars["UPDATE_X"] = UPDATE_X;
$UPDATE_X_vars["UPDATE_X_VERSION"] = UPDATE_X_VERSION;
$UPDATE_X_vars["ini"] = UPDATE_X_getIni($ini);
$UPDATE_X_ini = parse_ini_file($UPDATE_X_vars["ini"],true);
$UPDATE_X_vars["lang"] = INCLUDE_optionalVar($lang,$UPDATE_X_ini["VARS"]["lang"]);

if ( !$UPDATE_X_ini["DATABASE"] )
{
	$UPDATE_X_vars["user"] = INCLUDE_optionalVar($user,"-unknown-");
	$UPDATE_X_vars["edit"] = UPDATE_X_getFileParameter($edit,$UPDATE_X_ini,"XML","edit");
}
else
{
	require("../../wxis-php/wxis.php");
	
	$UPDATE_X_vars["user"] = UPDATE_X_getParameter($user,$UPDATE_X_ini,"FORM","user");
	$UPDATE_X_vars["database"] = UPDATE_X_getParameter($database,$UPDATE_X_ini,"DATABASE","edit");
	UPDATE_X_fileExists($UPDATE_X_vars["database"] . ".mst","DATABASE edit");
	$UPDATE_X_vars["restriction"] = UPDATE_X_getParameter($restriction,$UPDATE_X_ini,"DATABASE","restriction");
	$UPDATE_X_vars["column"] = INCLUDE_optionalVar($column,"");
	$UPDATE_X_vars["order"] = INCLUDE_optionalVar($order,"descending");
}

?>
