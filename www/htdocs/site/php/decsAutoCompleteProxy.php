<?php

$DirNameLocal=dirname(__FILE__).'/';
include_once($DirNameLocal . "./include.php");
include_once($DirNameLocal . "./common.php");

$query = trim($_REQUEST['query']);
$query = str_replace(" ","+",$query);
$query = replace_accents($query) . "*";

$serviceUrl = "http://" . $def['SERVICES_SERVER'] . "/decsQuickTerm/search?query=" . $query . "&lang=" . $checked["lang"];

$serviceResponse = getDoc($serviceUrl);

header("Content-type: text/xml");
echo $serviceResponse;

?>
