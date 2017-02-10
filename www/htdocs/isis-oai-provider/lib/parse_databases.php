<?php

require_once(dirname(__FILE__) . "/parse_config.php");

$mapping_dir = APPLICATION_PATH . '/map';
$databases_file = APPLICATION_PATH . '/oai-databases.php';

if(!is_dir($mapping_dir)) {
	$error = "mapping directory does not exists! ($mapping_dir)";
	$log->logError($error);
	die;
}

if(!file_exists($databases_file)) {
	$error = "databases file does not exists!";
	$log->logError($error);
	die;
}

$mapping_dir = realpath($mapping_dir);
$databases_file = realpath($databases_file);

$DATABASES = parse_ini_file($databases_file, true);

foreach($DATABASES as $database) {

	if(!file_exists($mapping_dir . '/' . $database['mapping'])) {
		die("O arquivo ${database['mapping']} não existe.");
	}

	$database_xrf = $database['database'] . '.xrf';
	$database_mst = $database['database'] . '.mst';
	
	//$database_cnt = $database['path'] . '/' . $database['name'] . '.cnt';
	
	if(!(file_exists($database_xrf) && file_exists($database_mst))) {
		die("As bases não existem, ou estão incompletas.");
	}
}

$databases = array();
foreach($DATABASES as $key => $database) {
	$databases[$key] = array();
	$databases[$key]['setSpec'] = $key;
	$databases[$key]['setName'] = $database['name'];
	$databases[$key]['database'] = $database['database'];
	$databases[$key]['description'] = $database['description'];
	$databases[$key]['mapping'] = $mapping_dir . '/' . $database['mapping'];
	$databases[$key]['prefix'] = $database['prefix'];
	$databases[$key]['prefix'] = $database['prefix'];	
	$databases[$key]['identifier_field'] = $database['identifier_field'];
	$databases[$key]['datestamp_field'] = $database['datestamp_field'];
	$databases[$key]['isis_key_length'] = $database['isis_key_length'];	
}

?>