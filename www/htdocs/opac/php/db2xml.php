<?php
header('Content-Type: text/xml');
$file=file("/ABCD2.2/www/bases/unimarc/def/marc2xml.xml");
$string="";
foreach ($file as $linea) echo $linea;
?>