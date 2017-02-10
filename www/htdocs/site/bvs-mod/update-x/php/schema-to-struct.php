<?php

require("include.php");
require("update-x.php");

$schema = UPDATE_X_getFileParameter($schema,$UPDATE_X_ini,"XSD","schema");
$xsd = INCLUDE_getFile($schema);

print(INCLUDE_xml_xsl($xsd,"/home2/schematic/htdocs/update-x/xsl/schema-to-struct.xsl"));

?>
