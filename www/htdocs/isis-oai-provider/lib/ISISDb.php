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
      $CONFIG['ENVIRONMENT']['DIRECTORY'] . 'wxis.exe/'  . $CONFIG['ENVIRONMENT']['DIRECTORY'] . 'wxis/';
    $this->app_path = APPLICATION_PATH;

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

  function wxis_url ( $IsisScript, $params, $key_length = '1030' ) {
    if ($key_length != '1030'){
      $wxis_action = str_replace('wxis.exe', 'wxis'.$key_length .'.exe', $this->wxis_action);
    }else{
      $wxis_action = $this->wxis_action;
    }

    $request = "http://" . $this->wxis_host . $wxis_action . "?" . "IsisScript=" . $IsisScript . "&app_path=" . $this->app_path;
    

    foreach ($params as $key => $value){
        $request .= "&" . $key . "=" . $value;
    }
    return $request;
 
 }

  function wxis_document_post( $url, $content = "" ){ 
    $content = str_replace("\\\"","\"",$content);
    $content = str_replace("\n","",$content);
    $content = str_replace("\r","",$content);
    $content = str_replace("\\\\","\\",$content);

    // Strip URL  
    $url_parts = parse_url($url);
    $host = $url_parts["host"];
    $port = ($url_parts["port"]) ? $url_parts["port"] : 80;
    $path = $url_parts["path"];
    $query = $url_parts["query"];
    if ( $content != "" )
    {
      $query .= "&content=" . urlencode($content);
    }
    $timeout = 10;
    $contentLength = strlen($query);
    
    // Generate the request header 
      $ReqHeader =  
        "POST $path HTTP/1.0\n". 
        "Host: $host\n". 
        "User-Agent: PostIt\n". 
        "Content-Type: application/x-www-form-urlencoded\n". 
        "Content-Length: $contentLength\n\n". 
        "$query\n"; 
    
    // Open the connection to the host 
    $fp = fsockopen($host, $port, $errno, $errstr, $timeout);
    
    fputs( $fp, $ReqHeader ); 
    if ($fp) {
      while (!feof($fp)){
        $result .= fgets($fp, 4096);
      }
    }
    
    $response = strstr($result,"\n\r");
    $response = trim($response);

    return $response; 
  }

}

?>