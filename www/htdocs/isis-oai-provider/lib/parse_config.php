<?php

require_once(dirname(__FILE__) . '/Log.php');

$config_file = APPLICATION_PATH . DIRECTORY_SEPARATOR . "oai-config.php";

if (!file_exists($config_file)) {
    die("ERROR: config file does not exist! ($config_file)");
}

// Carrega o array de configuração diretamente do arquivo PHP
require($config_file);

if (!isset($CONFIG['INFORMATION']['MAX_ITEMS_PER_PASS'])) {
    $CONFIG['INFORMATION']['MAX_ITEMS_PER_PASS'] = 20;
}

$logDir = rtrim($CONFIG['ENVIRONMENT']['DATABASE_PATH'], '/\\') . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR;
if (!defined('LOG_DIR')) {
    define('LOG_DIR', $logDir);
}

$log = new Log();
$log->setFileName(date('Ym') . '.log');
