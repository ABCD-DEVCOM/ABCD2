<?php
/**
 * Define global variables and system behavior
 *
 * This file script set system behavior loading the configuration
 * file bvs-site-conf.php and $_REQUEST variables
 *
 * PHP version 5
 */

/*
 * Edit this file in ISO-8859-1 - Test String áéíóúÁÉÍÓÚ
 */

$DirNameLocal=dirname(__FILE__).'/';

// define constants
define("VERSION","5.3.1");
define("USE_SERVER_PATH", false);

if (USE_SERVER_PATH == true){
    $sitePath = $_SERVER['DOCUMENT_ROOT'];
}else{
    $sitePath = realpath($DirNameLocal . "..");
}


if (stripos($_SERVER["SERVER_SOFTWARE"],"Win") > 0)
$def = @parse_ini_file("../ABCD-site-win.conf");
else
$def = @parse_ini_file("../ABCD-site-lin.conf");

if( isset($def["SHOW_ERRORS"]) && $def["SHOW_ERRORS"] == true ){
    error_reporting( E_ALL ^E_NOTICE );
    ini_set('display_errors', true);
} else {
    error_reporting( 0 );
    ini_set('display_errors', false);
}

// Parse language
$lang = '';
if(isset($_REQUEST["lang"])) {
    $lang = $_REQUEST["lang"];
} else if(isset($_COOKIE["clientLanguage"])) {
    $lang = $_COOKIE["clientLanguage"];
} else if(isset($def["ACCEPT_LANGUAGES"])){
    preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)s*(;s*qs*=s*(1|0.[0-9]+))?/i',
                                       $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang);
    if(isset($lang[1][1])){
        if(preg_match("/\\b{$lang[1][1]}\\b/", $def["ACCEPT_LANGUAGES"])){
            $lang = $lang[1][1];
        }
    }
}
if(!preg_match('/^[a-z][a-z](-[a-z][a-z])?$/',$lang)) {
    $lang = $def["DEFAULT_LANGUAGE"];
}
if(!isset($_COOKIE["clientLanguage"]) || $_COOKIE["clientLanguage"] != $lang) {
    setCookie("clientLanguage", $lang, time()  +60*60*24*30, "/");
}

// URL parameters security filter
$checked  = array();

if (isset($_GET["component"]) && !preg_match("/^[0-9]+$/", $_GET["component"]))
    die("404 - Component not Found");
else
    $checked['component'] = $_GET["component"];

if (isset($_GET["item"]) && !preg_match("/^[0-9]+$/", $_GET["item"]))
    die("404 - Item not Found");
else
    $checked['item'] = $_GET["item"];

if (isset($_GET["id"]) && !preg_match("/^[0-9]+$/", $_GET["id"]))
    die("404 - File Not Found");
else
    $checked['id'] = $_GET["id"];

//$checked['lang'] = 'en';
$checked['lang'] = $lang;

$def['DEFAULT_DATA_PATH'] = $def['DATABASE_PATH'];
if ( isset($_REQUEST['portal']) && preg_match('/^[a-zA-Z0-9_]+$/', $_REQUEST['portal'])){
    $portal_path = preg_replace(
        '/[a-zA-Z0-9_]+\/$/',
        '',
        $def['DATABASE_PATH']
    );
    $portal_path .= $_REQUEST['portal'];

    if( file_exists($portal_path)){
        $checked['portal'] = $_REQUEST['portal'];
        $def['DATABASE_PATH'] = $portal_path . '/';
    }
    unset( $portal_path );
}

foreach ($def as $key => $value){
    define($key, $value);
}

if ( !isset($def['SERVICES_SERVER']) ){
    $def['SERVICES_SERVER'] = 'srv.bvsalud.org';
}    

$localPath['html']= $def['DATABASE_PATH'] . "html/" . $checked['lang'] . "/";
$localPath['xml'] = $def['DATABASE_PATH'] . "xml/" . $checked['lang'] . "/";
$localPath['ini'] = $def['DATABASE_PATH'] . "ini/" . $checked['lang'] . "/";

unset($database);
?>
