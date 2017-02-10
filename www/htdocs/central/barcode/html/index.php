<?php
session_start();
$base=$_SESSION["base_barcode"];
$arrHttp["base"]=$base;
include("../../config.php");
$parms=array();
if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/barcode_code.tab")){
	$parms=parse_ini_file($db_path.$base."/def/".$_SESSION["lang"]."/barcode_code.tab",true);

}
if (isset($parms["type"]))
	$type=trim($parms["type"]);
else
	$type="BCGcode39.php";
header('Location: '.$type.'?base='.$_REQUEST["base"]);
?>