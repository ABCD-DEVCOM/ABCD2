<?php

class ISISDb
{
  var $dbname;
  var $wxis_host;
  var $wxis_action_base;
  var $dbpath;
  var $app_path;

  function __construct($dbname)
  {
    global $CONFIG, $DATABASES;

    if (!isset($DATABASES[$dbname])) {
      return;
    }

    $this->wxis_host = $_SERVER['HTTP_HOST'];
    $this->dbname = $dbname;
    $this->app_path = APPLICATION_PATH;

    // CORREÇÃO: Usa a chave 'database' que é definida em parse_databases.php
    $this->dbpath = $DATABASES[$dbname]['database'];

    // Monta apenas a parte base da ação, o resto será adicionado dinamicamente
    $this->wxis_action_base = $CONFIG['ENVIRONMENT']['CGI-BIN_DIRECTORY'] .
      $DATABASES[$dbname]['cisis_version'] .
      'wxis' .
      $CONFIG['ENVIRONMENT']['EXE_EXTENSION'];
  }

  private function wxis_url($IsisScript, $params, $key_length)
  {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

    $request = $protocol . $this->wxis_host . $this->wxis_action_base . "/wxis/?IsisScript=" . $this->app_path . "/wxis/" . $IsisScript;

    foreach ($params as $key => $value) {
      $request .= "&" . $key . "=" . urlencode($value);
    }
    return $request;
  }

  public function getrecord($params, $key_length)
  {
    $url = $this->wxis_url("getrecord.xis", $params, $key_length);
    $response = @file_get_contents($url);

    if (function_exists('mb_convert_encoding')) {
      return mb_convert_encoding($response, 'UTF-8', 'ISO-8859-1');
    }
    return $response;
  }

  public function getidentifiers($params, $key_length)
  {
    $url = $this->wxis_url("getidentifiers.xis", $params, $key_length);
    return $this->wxis_document_post($url);
  }

  public function gettotal($params, $key_length)
  {
    $url = $this->wxis_url("gettotal.xis", $params, $key_length);
    return $this->wxis_document_post($url);
  }

  private function wxis_document_post($url)
  {
    $url_parts = parse_url($url);
    $query = $url_parts["query"] ?? '';

    parse_str($query, $arr_url);
    $postdata = http_build_query($arr_url);

    $opts = [
      'http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
      ]
    ];
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);

    return trim($result);
  }
}
