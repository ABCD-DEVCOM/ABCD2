<?php
/**
 * @file:	constants.php
 * @desc:	Constants for SeCS-Web System
 * @author:	Domingos Teruel <domingos.teruel@dteruel.com.br>
 * @author      Bruno Neofiti de Andrade <bruno.neofiti@bireme.org>
 * @since :	2008-01-18
 *
 * The contents of this file are subject to the Mozilla Public License Version
 * 1.1 (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
 * for the specific language governing rights and limitations under the
 * License.
 */
 //Set operation system variable

$strInitialPosition = stripos($_SERVER["SERVER_SOFTWARE"],"Win");
$serverOS = substr($_SERVER["SERVER_SOFTWARE"], $strInitialPosition, "3");
if($serverOS == "Win"){
    //Windows variables
    //echo "WINDOWS<BR>";
    $BVS_CONF['PATHMX'] = BVS_DIR."\\cgi-bin\\ansi\\mx.exe";
    $BVS_CONF['PATHMXTB'] = BVS_DIR."\\cgi-bin\\ansi\\mxtb.exe";
    define("BVS_DATABASE_DIR",BVS_DIR."\\bases\\secs-web\\"); //Databases directory
}else{
    //Linux variables
    //echo "LINUX<BR>";
    $BVS_CONF['PATHMX'] = BVS_DIR."/cgi-bin/ansi/mx";
    $BVS_CONF['PATHMXTB'] = BVS_DIR."/cgi-bin/ansi/mxtb";
    define("BVS_DATABASE_DIR",BVS_DIR."/bases/secs-web/"); //Databases directory
}

//Defines a named constant used in the system, defines initial configuration
define("NAME_SYSTEM","[SeCS-Web for ABCD] -  Administra&#231;&#227;o");
define("_WEBMASTER","bruno.neofiti@bireme.org");
define("_VERSION","1.0.6");
define("BVS_TEMP_DIR",  BVS_DATABASE_DIR."temp");
define("BVS_LOG_DIR",BVS_TEMP_DIR);
define("BVS_COMMON_DIR",BVS_ROOT_DIR . "/common");
define("BVS_PUBLIC_DIR",BVS_ROOT_DIR . "/public");
define("BVS_LANG_DIR",BVS_ROOT_DIR . "/lang");
define("BVS_TPL_DIR",BVS_PUBLIC_DIR . "/templates");
define("INIFILE",BVS_COMMON_DIR ."/ini/bases.conf.php");
define("DEBUG",false);
define("HLDGMODULE","hldgChronOrder"); # hldgModule(old) or hldgChronOrder
define("HLDGMODULE_DEBUG","no"); # yes or no
define("HLDGMODULE_TAG","970"); # yes or no

//echo "TEMPPath=". BVS_TEMP_DIR."<BR>";
//echo "DatabaseDir=". BVS_DATABASE_DIR."<BR>";

//Create the error report E_STRICT in case of E_STRICT dont exist
if(!(defined("E_STRICT"))){
	define("E_STRICT",2048);
}
define('PERMISSION_ERROR', -1);
define('CREATE_LOCK_ERROR', -2);
define('FILE_READ_ERROR', -3);

//Set initial variables
date_default_timezone_set("America/Sao_Paulo"); 
$BVS_CONF["metaAuthor"] = "BIREME|OPAS|OMS";
$BVS_CONF["authorURI"] = "http://www.bireme.org/";
$BVS_CONF["copyright"] = date("Y");
$BVS_CONF["install_dir"] = dirname($_SERVER['PHP_SELF']);
$BVS_CONF["temp_dir"] = BVS_TEMP_DIR;
$BVS_LANG["index"] = dirname($_SERVER['PHP_SELF']);
$BVS_CONF["detection"] = "true"; # Enable automatic content negotiation
$BVS_CONF["version"] = _VERSION;
$BVS_CONF["numRecordsPage"] = "50"; # Number of displayed topics per page
$BVS_CONF['TIMEOUT'] = 1800;

//echo "BVSCONF_TEMP=".$BVS_CONF["temp_dir"]."<BR>";

/*
 * Set databases directory, for title, mask, users and library.
 *
 * The variables $BVS_CONF['PATH2FACIC'], $BVS_CONF['PATH2TITLEPLUS'] and
 * $BVS_CONF['PATH2HOLDINGS'] are in the file library.ini.php
 */
$BVS_CONF['PATH2TITLE'] = BVS_DATABASE_DIR."title";
$BVS_CONF['PATH2MASK'] = BVS_DATABASE_DIR."mask";
$BVS_CONF['PATH2USERS'] = BVS_DATABASE_DIR."users";
$BVS_CONF['PATH2LIBRARY'] = BVS_DATABASE_DIR."library";
//echo "BVSCONF_path2masks=".$BVS_CONF["PATH2MASK"]."<BR>";

/*
 * Deprecated or not used variables, could came back in future versions
 *
 *
 * #path to directory of files upload
 * $BVS_CONF["upload_dir"] = BVS_DIR."/temp/importedFiles/";
 *
 * $BVS_CONF['URLWS'] = "http://" . $_SERVER['HTTP_HOST'] . "/isisws/isiswsdl.php?wsdl";
 * $BVS_CONF["images_dir"] = dirname($_SERVER['PHP_SELF'])."/public/images/common";
 * $BVS_CONF["wlcSection"] = "Administra&#231;&#227;o";
 * # Name of the Publisher
 * $BVS_CONF["metaPublisher"] = "PFI";
 * # Contact information
 * $BVS_CONF["msgContactOwnText"] = "BIREME [PFI]";
 * #allowed extensios of upload files
 * $BVS_CONF['allow_ext'] = array(".txt",".lst",".iso",".002");
 * #operator for where cluses
 * $BVS_CONF['adm_opertors'] = array("AND","OR","AND NOT");
 * #ISO 639 language code list - DO NOT CHANGE!
 * $languageCodes = array (
 *                	"PT-BR" => "Portugues - Brasil",
 *                );
 * # Copyrighttext for the startpage
 * $BVS_CONF["copyright_eintrag"] = "BIREME|ABCD";
 */

?>
