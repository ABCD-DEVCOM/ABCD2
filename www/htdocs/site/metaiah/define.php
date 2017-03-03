<?php
require("../php/include.php");
header("Pragma: no-cache");
header("Expires:  -1");
//header("Content-Type: text/xml; charset=\"iso-8859-1\"");
header("Content-Type: text/xml; charset=\"utf-8\"");
readfile($localPath["xml"] . "/metaiah.xml");

?>
