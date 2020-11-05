<?php
//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>";  die;
include("config_opac.php");
chdir($CentralPath."circulation");
$desde_opac="Y";
$vienede="orbita";
include ('reservar_anular.php');

?>