<?php

$xml = stripslashes($xml);

header("Content-type: text/xml\n\n");
print("<?xml version='1.0' encoding='ISO-8859-1'?>" . $xml);

?>
