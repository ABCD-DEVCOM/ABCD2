<?php

class ISISDb{

  var $dbname;
  var $wxis_host;
  var $wxis_action;


  function ISISDb($dbname) {
    global $CONFIG, $DATABASES;
    $this->wxis_host = $_SERVER['HTTP_HOST'];
    $this->dbname = $dbname;
    $this->dbpath = $DATABASES[$dbname]['path'];
    $this->wxis_action = $CONFIG['ENVIRONMENT']['CGI-BIN_DIRECTORY'] . 
     $DATABASES[$dbname]['cisis_version'] . 'wxis' . $CONFIG['ENVIRONMENT']['EXE_EXTENSION'] . '/wxis/';
    $this->app_path = APPLICATION_PATH;
    $this->wxis_action=$wxis_action.$this->app_path;
  }
  
 function __construct($dbname) {
  $this->dbname = $dbname;
  self:: ISISDb($this->dbname);
 }

  function get_list($params){
    return wxis_list($params);
  }
  
  function getrecord($params, $key_length){
    return utf8_encode ($this->wxis_document_get( $this->wxis_url("getrecord.xis", $params, $key_length) ));
  }

  function getidentifiers($params, $key_length){
    return $this->wxis_document_post( $this->wxis_url("getidentifiers.xis",$params, $key_length) );
  }

  function gettotal($params, $key_length){
    return $this->wxis_document_post( $this->wxis_url("gettotal.xis",$params, $key_length) );
  }
  
  function index($params){
    return wxis_index($params);
  }
  
  function wxis_document_get($url){
    return file_get_contents($url);
  }

  function wxis_url ( $IsisScript, $params, $key_length ) {
  global $CONFIG;
     if ($key_length <> '') $key_length .= '/';
     $wxis_action = "/cgi-bin/" . $key_length . "wxis" . $exe_extension . $CONFIG['ENVIRONMENT']['EXE_EXTENSION'];
    $request = "http://" . $this->wxis_host . $wxis_action . "?" . "IsisScript=" . $this->app_path . "/wxis/" . $IsisScript   ;
    foreach ($params as $key => $value){
        $request .= "&" . $key . "=" . $value;
    }
    return $request;
 }


  function wxis_document_post( $url, $content = "" ) {

    $content = str_replace("\\\"","\"",$content);
    $content = str_replace("\n","",$content);
    $content = str_replace("\r","",$content);
    $content = str_replace("\\\\","\\",$content);

    // Strip URL  
    $url_parts = parse_url($url);
    $host = $url_parts["host"];
    $port = ($url_parts["port"]) ? $url_parts["port"] : 80;
    $path= $url_parts["path"];
    $query = $url_parts["query"];
    if ( $content != "" )
    {
      $query .= "&content=" . urlencode($content);
    }
    $timeout = 10;
    $contentLength = strlen($query);
                 parse_str($query, $arr_url);
		$postdata = http_build_query($arr_url);
		$opts = array('http' =>
    				array(
        					'method'  => 'POST',
        					'header'  => 'Content-type: application/x-www-form-urlencoded',
        					'content' => $postdata
    				     )
					);
		$context = stream_context_create($opts);
    $result=file_get_contents($url, false, $context);
#error_log("url=$url\n\r", 3 , "/ABCD/www/bases/log/OAIError.log");
    $response = trim($result);
    return $response;
  }

}

?>