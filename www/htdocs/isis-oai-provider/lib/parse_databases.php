<?php
global $DATABASES; // Mantém a variável global para compatibilidade
require_once(dirname(__FILE__) . "/parse_config.php");

$mapping_dir = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'map';
$databases_file = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'oai-databases.php';

if (!is_dir($mapping_dir)) {
	die("mapping directory does not exist! ($mapping_dir)");
}
if (!file_exists($databases_file)) {
	die("databases file does not exist!");
}

// Carrega o array de configuração das bases diretamente
require($databases_file);

$databases = array();
foreach ($DATABASES_CONFIG as $key => $database) {
	if (!isset($database['name'])) continue;

	$set_key = $key;

	$databases[$set_key] = array();
	$databases[$set_key]['setSpec'] = $set_key;
	$databases[$set_key]['setName'] = $database['name'];

	$db_path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $database['database']);
	if (!(file_exists($db_path . '.xrf') && file_exists($db_path . '.mst'))) {
		die("Database files for '{$set_key}' not available at: {$db_path}");
	}
	$databases[$set_key]['database'] = $db_path;

	$mapping_file_path = $mapping_dir . DIRECTORY_SEPARATOR . $database['mapping'];
	if (!file_exists($mapping_file_path)) {
		die("Database mapping {$database['mapping']} not available.");
	}
	$databases[$set_key]['mapping'] = $mapping_file_path;

	$databases[$set_key]['description'] = $database['description'];
	$databases[$set_key]['prefix'] = $database['prefix'];
	$databases[$set_key]['identifier_field'] = $database['identifier_field'];
	$databases[$set_key]['datestamp_field'] = $database['datestamp_field'];
	$databases[$set_key]['cisis_version'] = $database['cisis_version'];
}

// Para compatibilidade com o resto do código, define a variável global original
$GLOBALS['DATABASES'] = $databases;
