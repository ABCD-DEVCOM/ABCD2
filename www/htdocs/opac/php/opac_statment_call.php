<?php
//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>";
if (isset($_REQUEST["Opcion"])) $_REQUEST["Opcion_Original"]=$_REQUEST["Opcion"];
include("config_opac.php");
include("leer_bases.php");
$indice_alfa="N";
//$sidebar="N";
$ActualDir=getcwd();
//include("tope.php");
include($Web_Dir."/php/head.php");
chdir($CentralPath."circulation");
$desde_opac="Y";
$ecta_web="Y";
include ('opac_statment_orbita.php');


?>