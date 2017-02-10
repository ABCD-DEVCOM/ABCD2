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
	if ( $UPDATE_X_vars["selectedId"] == "New" )
	{
		$xml = "";
	}
	else
	{
		$editParam["database"] = $UPDATE_X_vars["database"];
		$editParam["mfn"] = $UPDATE_X_vars["selectedId"];
		$editParam["lockid"] = $UPDATE_X_vars["user"];
		$editParam["expire"] = INCLUDE_optionalVar($UPDATE_X_ini["VARS"]["expire"],"18000");
		$xml = wxis_edit(INCLUDE_wxisParameterList($editParam));
	}
}
$UPDATE_X_xml = UPDATE_X_setXml($UPDATE_X_vars,$UPDATE_X_ini,$xml);
//die($UPDATE_X_xml);

$xslEdit = UPDATE_X_getFileParameter($xsl,$UPDATE_X_ini,"XSL","edit");
print(INCLUDE_xml_xsl($UPDATE_X_xml,$xslEdit));

?>
