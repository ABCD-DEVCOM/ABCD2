<?php

require("include.php");
require("update-x.php");

$UPDATE_X_vars["selectedId"] = UPDATE_X_getParameter($selectedId,$UPDATE_X_ini,"form","selectedId");
$removeParam["database"] = $UPDATE_X_vars["database"];
$removeParam["mfn"] = $UPDATE_X_vars["selectedId"];
$removeParam["lockid"] = $UPDATE_X_vars["user"];
$removeParam["expire"] = INCLUDE_optionalVar($UPDATE_X_ini["VARS"]["expire"],"18000");
$xml = wxis_delete(INCLUDE_wxisParameterList($removeParam));

$searchParam["database"] = $UPDATE_X_vars["database"];
$searchParam["search"] = $UPDATE_X_vars["restriction"];
$xml .= wxis_search(INCLUDE_wxisParameterList($searchParam));
$UPDATE_X_xml = UPDATE_X_setXml($UPDATE_X_vars,$UPDATE_X_ini,$xml);

$xslDocuments = UPDATE_X_getFileParameter($xsl,$UPDATE_X_ini,"XSL","documents");
print(INCLUDE_xml_xsl($UPDATE_X_xml,$xslDocuments));

?>
