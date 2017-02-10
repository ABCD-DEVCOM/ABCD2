<?php

require_once(dirname(__FILE__) . '/Log.php');


$config_file = APPLICATION_PATH . "/oai-config.php";
if(!file_exists($config_file)) {
	die("ERROR: config file does not exists!");
}

$CONFIG = parse_ini_file($config_file, true);

if ( !isset($CONFIG['INFORMATION']['MAX_ITEMS_PER_PASS']) ){
    $CONFIG['INFORMATION']['MAX_ITEMS_PER_PASS'] = 20;
}

define('LOG_DIR', $CONFIG['ENVIRONMENT']['DATABASE_PATH'] . $CONFIG['ENVIRONMENT']['DIRECTORY'] . '/log/');

// Log name example 201111.log
$log = new Log();
$log->setFileName(date('Ym') . '.log');

?>