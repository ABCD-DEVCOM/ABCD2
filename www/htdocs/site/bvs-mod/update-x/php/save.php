<?php

require("include.php");
require("update-x.php");

//vinicius 13.05.2005
$xml = $_REQUEST["xml"];
$selectedId = $_REQUEST['selectedId'];

$UPDATE_X_vars["UPDATE_X_saveDate"] = date("l d F Y H:i");

if ( !isset($xml) )
{
	UPDATE_X_error('Please, informe the "xml" parameter!');
}

$UPDATE_X_xml = UPDATE_X_setXml($UPDATE_X_vars,$UPDATE_X_ini,stripslashes($xml));

$xslWrite = UPDATE_X_getFileParameter($xslWrite,$UPDATE_X_ini,"XSL","write");

$xml = INCLUDE_xml_xsl($UPDATE_X_xml,$xslWrite);
$xml = INCLUDE_removeXMLpi($xml);

if ( !$UPDATE_X_ini["DATABASE"] )
{
	if ( trim($xml) != "" )
	{
		INCLUDE_putFile($UPDATE_X_vars["edit"],'<?xml version="1.0" encoding="ISO-8859-1"?>' . "\n" . $xml);
	}
}
else
{
	$UPDATE_X_vars["selectedId"] = UPDATE_X_getParameter($selectedId,$UPDATE_X_ini,"form","selectedId");
	$writeParam["database"] = $UPDATE_X_vars["database"];
	$writeParam["mfn"] = $UPDATE_X_vars["selectedId"];
	$writeParam["lockid"] = $UPDATE_X_vars["user"];
	$writeParam["expire"] = INCLUDE_optionalVar($UPDATE_X_ini["VARS"]["expire"],"18000");
	$content = '<field tag="1"><occ>' . $xml . '</occ></field>';
	if ( trim($content) != "" )
	{
		$xml = wxis_write(INCLUDE_wxisParameterList($writeParam),$content);
	}
	if ( $UPDATE_X_vars["selectedId"] == "New" )
	{
		preg_match("/<record mfn=\"(.+)\">/",$xml,$pregMatch);
		$UPDATE_X_vars["selectedId"] = trim($pregMatch[1]);
	}
}

$UPDATE_X_xml = UPDATE_X_setXml($UPDATE_X_vars,$UPDATE_X_ini,$xml);
//die($UPDATE_X_xml);

$xslShow = UPDATE_X_getFileParameter($xsl,$UPDATE_X_ini,"XSL","show");
print(INCLUDE_xml_xsl($UPDATE_X_xml,$xslShow));
?>
