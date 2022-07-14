<?php
if (isset($_REQUEST["Opcion"])) $_REQUEST["Opcion_Original"]=$_REQUEST["Opcion"];
//foreach ($_REQUEST as $var=>$value)  echo "$var=$value<br>";//die;
include("../central/config_opac.php");
$Actual_path=$db_path;
include("leer_bases.php");
$indice_alfa="N";
//$sidebar="N";
$ActualDir=getcwd();
include("head.php");
$Web_Dir=$CentralPath;
$desde_web="Y";
$desde_opac="Y";
$_REQUEST["vienede"]="orbita";
chdir($CentralPath."reserve");
include ('reservar_ex.php');
include($ActualDir."/components/footer.php");



?>