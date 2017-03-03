<?PHP
/* ini configuration */

include("../../php/include.php");

ini_set("error_reporting", E_PARSE|E_ERROR|E_WARNING);    //Enable errors, but not basic them
//ini_set("error_reporting", E_ALL);                    //View all errors
//ini_set("error_reporting", 0);                          //Disable all errors

ini_set("register_globals", "off");
ini_set("upload_max_filesize","10MB");        // Maximum allowed size for uploaded files


if (USE_SERVER_PATH == true) {
    $sitePath = preg_replace('/admin.*$/','',$sitePath);
    $def = parse_ini_file($sitePath ."/bvs-site-conf.php");
    
    // compatibility with bvs-site5.2
    if ( !isset($def['UPLOAD_FILES_PATH']) ){
        $def['UPLOAD_FILES_PATH'] = $def['DATABASE_PATH'];
    }
} else {
    // compatibility with bvs-site5.2
    if ( !isset($def['UPLOAD_FILES_PATH']) ){
        $def['UPLOAD_FILES_PATH'] = $def['SITE_PATH'];
    }
}

/* Define constants of system */
define("pFNOW", dirname(__FILE__));
define("pHOME", $def['UPLOAD_FILES_PATH']);

$cfg["base_directory"] = "local/";
$cfg["lang"] = ($_REQUEST['lang'] ? $_REQUEST['lang'] : "pt");
$cfg["allowed_extensions"] = "(gif|bmp|png|jpg|jpeg|doc|txt|xml|pdf|swf)";

/* Including necessary files */
require_once($sitePath . "/php/xmlRoot_functions.php");
require_once(pFNOW . "/include_functions.php");
?>
