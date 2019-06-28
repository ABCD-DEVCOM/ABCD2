<?php
require("../php/include.php");
header("Pragma: no-cache");
header("Expires:  -1");
//header("Content-Type: text/xml; charset=\"iso-8859-1\"");
header("Content-Type: text/xml; charset=\"utf-8\"");
//echo "metaiah.xml=$localPath["xml"]"  . "/metaiah.xml";      die;
readfile($localPath["xml"] . "/metaiah.xml");

?>
