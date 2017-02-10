<?php

require("include.php");
require("update-x.php");

if ( !$UPDATE_X_ini["DATABASE"] )
{
	$xml = INCLUDE_getFile($UPDATE_X_vars["edit"]);
}
else
{
	$UPDATE_X_vars["selectedId"] = UPDATE_X_getParameter($selectedId,$UPDATE_X_ini,"form","selectedId");
	$listParam["database"] = $UPDATE_X_vars["database"];
	$listParam["from"] = $UPDATE_X_vars["selectedId"];
	$listParam["count"] = "1";
	$xml = wxis_list(INCLUDE_wxisParameterList($listParam));
}
$UPDATE_X_xml = UPDATE_X_setXml($UPDATE_X_vars,$UPDATE_X_ini,$xml);
//die($UPDATE_X_xml);

$xslShow = UPDATE_X_getFileParameter($xsl,$UPDATE_X_ini,"XSL","show");
print(INCLUDE_xml_xsl($UPDATE_X_xml,$xslShow));

?>
