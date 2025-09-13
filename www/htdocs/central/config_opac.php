<?php
/*
20211224 fho4abcd Read default message file from central, with central processing, lineends
20220831 rogercgui Included the variable $opac_path to allow changing the Opac root directory
20230223 fho4abcd Check for existence of config.php
*/
//session_start();
error_reporting(E_ALL);

//CHANGE THIS
$opac_path="opac/";

include realpath(__DIR__ . '/../central/config_inc_check.php');
include realpath(__DIR__ . '/../central/config.php'); //CAMINO DE ACCESO HACIA EL CONFIG.PHP DE ABCD

if (isset($_SESSION["db_path"])){
	$db_path=$_SESSION["db_path"];   //si hay multiples carpetas de bases de datos
} elseif (isset($_REQUEST["db_path"]))  {
	$db_path=$_REQUEST["db_path"];
}

$actualScript = basename($_SERVER['PHP_SELF']);
$CentralPath = $ABCD_scripts_path.$app_path."/";
$CentralHttp = $server_url;
$Web_Dir = $ABCD_scripts_path.$opac_path;
$NovedadesDir = "";

$lang_config = $lang; // save the configured language to preset it later

if (isset($_REQUEST["lang"])){
	$lang = $_REQUEST["lang"];
} else if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
	// If the browser language is informed, use it
	$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
} else {
	// Otherwise, use the default language defined in config.php
	$lang = $lang_config;
}

include ($CentralPath."/lang/opac.php");
include ($CentralPath."/lang/admin.php");

$galeria="N";
$facetas="Y";

//$logo="assets/img/logoabcd.png";
$link_logo="/".$opac_path;

$multiplesBases="Y";   //No access is presented for each of the databases
$afinarBusqueda="Y";   //Allows you to refine search expression
$IndicePorColeccion="Y";  //Separate indices are maintained for the terms of the collections


$opac_global_def = $db_path."/opac_conf/opac.def";
$opac_gdef = parse_ini_file($opac_global_def,true); 
$charset=$opac_gdef['charset'];
$shortIcon=$opac_gdef['shortIcon'];

$opac_global_style_def = $db_path."/opac_conf/global_style.def";
$opac_gstyle = parse_ini_file($opac_global_style_def,true); 
$hideSIDEBAR=$opac_gstyle['hideSIDEBAR'];


$db_path=trim(urldecode($db_path));
$ix=explode('/',$db_path);
$xxp="";
for ($i=1;$i<count($ix);$i++) {
	$xxp.=$ix[$i];
	if ($i!=count($ix)-1) $xxp.='/';
}


if (!is_dir($db_path."opac_conf/".$lang)){
	$lang="en";
}

$modo = "";
if (isset($_REQUEST["base"]))
	$actualbase = $_REQUEST["base"];
else
	$actualbase = "";
if (isset($_REQUEST["xmodo"]) and $_REQUEST["xmodo"] != "") {
	unset($_REQUEST["base"]);
	$modo = "integrado";
}

if (isset($_REQUEST["search_form"])){
	$search_form=$_REQUEST["search_form"];
} else {
	$search_form="free";
}

?>