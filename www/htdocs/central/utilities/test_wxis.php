<?php

//$url="http://abcdwiki.net/cgi-bin/wxis.exe?hello";
$url="http://127.0.0.1:9090/cgi-bin/ansi/wxis.exe?hello";
$result=file_get_contents($url);
var_dump($result);
?>