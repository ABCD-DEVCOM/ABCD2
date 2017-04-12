<?php
/**
 * @desc Configuration system file. In this file are all the parameters
 * necessary to the use of this system
 * @author  Domingos Teruel <domingosteruel@terra.com.br>
 * @author  Bruno Neofiti de Andrade <bruno.neofiti@bireme.org>
 * @since   24/01/2008
 * @copyright  BIREME|PFI - 2008
*/

/*
* Debug setting
* //enable errors, but not basic them
* ini_set("error_reporting", E_PARSE|E_ERROR|E_WARNING);
* ini_set("error_reporting", E_ALL); //View all errors
* ini_set("display_errors",true);
*/
//ini_set("error_reporting", 0); //disable all errors

//Set the application diretory under htdocs
define("BVS_ROOT_DIR",getcwd());
//echo "BVS_ROOT_DIR=".BVS_ROOT_DIR."<BR>";
/**
 * The BVS_DIR constant, set the diretory where is htdocs, bases, cgi-bin and
 * temp folders. But to change it, you will need to do it in chdir("../../");
 * Example of regular installation:
 * chdir("../../");
 * define("BVS_DIR",getcwd());
 *
 * Result:  /install_diretory/htdocs/
 *          /install_diretory/htdocs/secs-web/
 *          /install_diretory/bases/
 *          /install_diretory/cgi-bin/
 *          /install_diretory/temp/
 *
 * In case you are trying to install secs-web in a folder not under htdocs.
 * Example of a different structure:
 * chdir("../../../");
 * define("BVS_DIR",getcwd());
 *
 * Result:  /install_diretory/htdocs/
 *          /install_diretory/htdocs/abcd/secs-web/
 *          /install_diretory/bases/
 *          /install_diretory/cgi-bin/
 *          /install_diretory/temp/
 *
**/
getcwd();
chdir("../../");
define("BVS_DIR",getcwd());
//echo "BVS_DIR=".BVS_DIR."<BR>";

// Now in ABCD BVS_DIR is the www-folder, from where bases will be referenced
// Constants used in the system are loaded in this file
require_once("constants.inc.php");

//Sets the value of a configuration option
ini_set('include_path', BVS_COMMON_DIR); // Set the includes path
ini_set("session.save_path",BVS_TEMP_DIR ."/sessions"); //Set sessions directory
ini_set("session.name","uin");  //Set the session name
ini_set("session.cookie_lifetime",0); //Set the time of session
ini_set("session.gc_maxlifetime", 9999);
session_cache_limiter("private");
session_cache_expire(15); // set the cache expire to 15 minutes old
session_start(); //Starting Session
/**
 * Load additional configuration files.
 * Files with classes or funtions used in this system.
 * 
 * require_once(BVS_COMMON_DIR . "/plugins/nusoap/lib/nusoap.php"); //deprecated
**/
require_once(BVS_COMMON_DIR . "/class/beans/configurator.class.php");
require_once(BVS_COMMON_DIR . "/class/beans/model.class.php");
require_once(BVS_COMMON_DIR . "/class/beans/broker.class.php");
require_once(BVS_COMMON_DIR . "/class/xml2array.class.php");
require_once(BVS_COMMON_DIR . "/class/mask.class.php");
require_once(BVS_COMMON_DIR . "/class/title.class.php");
require_once(BVS_COMMON_DIR . "/class/facic.class.php");
require_once(BVS_COMMON_DIR . "/class/facic.data.class.php");
require_once(BVS_COMMON_DIR . "/class/futureIssues.class.php");
require_once(BVS_COMMON_DIR . "/class/session.class.php");
require_once(BVS_COMMON_DIR . "/class/users.class.php");
require_once(BVS_COMMON_DIR . "/class/titleplus.class.php");
require_once(BVS_COMMON_DIR . "/class/library.class.php");
require_once(BVS_COMMON_DIR . "/class/facicOperations.class.php");
require_once(BVS_COMMON_DIR . "/class/pInterface.class.php");
require_once(BVS_COMMON_DIR . "/class/export.class.php");
require_once(BVS_COMMON_DIR . "/class/validation.class.php");
require_once(BVS_COMMON_DIR . "/plugins/xml.class.php");
require_once(BVS_COMMON_DIR . "/plugins/JSON.php");
require_once(BVS_COMMON_DIR . "/plugins/error.inc.php");
require_once(BVS_COMMON_DIR . "/plugins/smarty/libs/Smarty.class.php");
require_once(BVS_COMMON_DIR . "/ini/functions.inc.php");
require_once(BVS_COMMON_DIR . "/class/hldgModule.class.php");
require_once(BVS_COMMON_DIR . "/ini/bases.conf.php");
require_once(BVS_COMMON_DIR . "/ini/language.ini.php"); 
require_once(BVS_COMMON_DIR . "/ini/library.ini.php");
//require_once(BVS_DIR. "\\htdocs\\isisws\\directIsis.php");
require_once(BVS_DIR. "/htdocs/isisws/directIsis.php");
//Instaced the primitive class
$configurator = new Configurator();
$isisBroker = new IsisBroker();
//Smarty template configuration
$smarty = new Smarty(); // Instanced of smarty class
$smarty->template_dir = BVS_TPL_DIR . "/interface/";
//echo "smarty templates:".BVS_TPL_DIR. "/interface/"."<BR>";
$smarty->compile_dir = BVS_TEMP_DIR . '/templates_c/interface/';
//echo "smarty compile:".BVS_TEMP_DIR. "/templates_c/interface/"."<BR>";
$smarty->config_dir = BVS_COMMON_DIR . '/plugins/smarty/configs/';
//echo "smarty config:".BVS_COMMON_DIR. "/plugins/smarty/configs/"."<BR>";
$smarty->cache_dir = BVS_TEMP_DIR . '/cache/';
//echo "smarty cache:".BVS_TEMP_DIR. "/cache/"."<BR>";
$smarty->caching = false;
//echo "After Smarty config<BR>";

//Header settings
@header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
@header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
@header("Cache-Control: no-store, no-cache, must-revalidate");
@header("Cache-Control: post-check=0, pre-check=0", false);
@header("Pragma: no-cache");
if(__FILE__ == "yuiservice.php") {
	@header('Content-type: application/json');
}else{
	@header("Content-type: text/html; charset=".$BVS_LANG["metaCharset"]);
}
@header("Vary: Negotiate,Accept");

//Change the function will go mananger the error report from now
$old_error_handler = set_error_handler('erros');
//echo "end of config.ini";
?>
