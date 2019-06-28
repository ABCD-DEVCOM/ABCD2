<?php

require("include.php");
require("update-x.php");

$UPDATE_X_vars["selectedId"] = INCLUDE_optionalVar($selectedId,"");

$searchParam["database"] = $UPDATE_X_vars["database"];
$searchParam["search"] = $UPDATE_X_vars["restriction"];
$xml = wxis_search(INCLUDE_wxisParameterList($searchParam));
$UPDATE_X_xml = UPDATE_X_setXml($UPDATE_X_vars,$UPDATE_X_ini,$xml);
//die($UPDATE_X_xml);

$xslDocuments = UPDATE_X_getFileParameter($xsl,$UPDATE_X_ini,"XSL","documents");
print(INCLUDE_xml_xsl($UPDATE_X_xml,$xslDocuments));

?>
