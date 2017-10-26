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
     $DATABASES[$dbname]['isis_key_length'] . 'wxis' . $CONFIG['ENVIRONMENT']['EXE_EXTENSION'] . '/wxis/';
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
#$paramsstr = implode($params,'#');
#error_log("params = $paramsstr \n\r",3,'/opt/ABCD/www/bases/log/error.log');
#      $wxis_action = str_replace('wxis', $key_length . 'wxis' . $exe_extension , $this->wxis_action);
     if ($key_length <> '') $key_length .= '/';
     $wxis_action = "/cgi-bin/" . $key_length . "wxis" . $exe_extension;
#error_log("wxis_action in wxis_url = $wxis_action \n\r",3,'/opt/ABCD/www/bases/log/error.log');
    $request = "http://" . $this->wxis_host . $wxis_action . "?" . "IsisScript=" . $this->app_path . "/wxis/" . $IsisScript   ;
//    . "&app_path=" . $this->app_path ;
    foreach ($params as $key => $value){
        $request .= "&" . $key . "=" . $value;
    }
#error_log("request = $request \n\r",3,'/opt/ABCD/www/bases/log/error.log');
    return $request;
 }


  function wxis_document_post( $url, $content = "" ) {

#error_log("url_init = $url \n\r",3,'/opt/ABCD/www/bases/log/error.log');
#error_log("content1 = $content \n\r",3,'/opt/ABCD/www/bases/log/error.log');
    $content = str_replace("\\\"","\"",$content);
    $content = str_replace("\n","",$content);
    $content = str_replace("\r","",$content);
    $content = str_replace("\\\\","\\",$content);

    // Strip URL  
    $url_parts = parse_url($url);
    $host = $url_parts["host"];
    $port = ($url_parts["port"]) ? $url_parts["port"] : 80;
//    $path = $url_parts["path"];
    $path="/cgi-bin/ansi/isis-oai-provider/wxis?";
    $query = $url_parts["query"];
//    error_log("query = $query \n\r",3,'/opt/ABCD/www/bases/log/error.log');
//var_dump($url_parts2);die;
//    $url_parts2 = parse_url(urlencode($query));
//    $isisscript = $url_parts2["IsisScript"];
//    $setSpec = $url_parts2["setSpec"];
//    error_log("url1 = $url \n\r",3,'/opt/ABCD/www/bases/log/error.log');
//    error_log("isisscript = $isisscript \n\r",3,'/opt/ABCD/www/bases/log/error.log');
//    error_log("setSpec = $setSpec \n\r",3,'/opt/ABCD/www/bases/log/error.log');
//   error_log("host = $host \n\r",3,'/opt/ABCD/www/bases/log/error.log');
//   error_log("port = $port \n\r",3,'/opt/ABCD/www/bases/log/error.log');
//   error_log("path = $path \n\r",3,'/opt/ABCD/www/bases/log/error.log');
//   $url = "http://$host:$port$path";
#$gi='getidentifiers.xis';
#$kl='ansi';
#    $url_New = wxis_url($gi, $query, $kl);
#   error_log("url_New = $url_New \n\r",3,'/opt/ABCD/www/bases/log/error.log');

    if ( $content != "" )
    {
      $query .= "&content=" . urlencode($content);
    }
    $timeout = 10;
    $contentLength = strlen($query);
                 parse_str($query, $arr_url);
		$postdata = http_build_query($arr_url);
//   error_log("postdata = $postdata \n\r",3,'/opt/ABCD/www/bases/log/error.log');
//$debug = '1';
//if ($debug == '1') {
//$url.='\n\r';
      //$debug_result =
#      $var_pass =  'postdata';
#      echo "before debugresult"; //die;
#      $debug_result = debug_log2();
#      echo "past debugresult"; die;
//      var_dump($url);
//}
//echo "postdata2=$postdata<BR>"; die;
		$opts = array('http' =>
    				array(
        					'method'  => 'POST',
        					'header'  => 'Content-type: application/x-www-form-urlencoded',
        					'content' => $postdata
    				     )
					);
		$context = stream_context_create($opts);
//                $url=$url.$postdata;
error_log("url = $url \n\r",3,'/opt/ABCD/www/bases/log/error.log');
//   error_log("context = $context \n\r",3,'/opt/ABCD/www/bases/log/error.log');
    $result=file_get_contents('http://127.0.0.1:9090/cgi-bin/ansi/wxis?', false, $context);
#    $result=file_get_contents($url, false, $context);
//   error_log("result = $result \n\r",3,'/opt/ABCD/www/bases/log/error.log');
#    $response = strstr($result,"\n\r");
    $response = trim($result);
//   error_log("response = $response \n\r",3,'/opt/ABCD/www/bases/log/error.log');
    return $response;
  }

    function debug_log( $var_Name ) {
//global $debug;
//echo "debug=$debug<BR>";  die;
echo "now debugging " . $var_Name . "<BR>";
die;
//	 	$fp=fopen("/var/opt/ABCD/bases/log/debug_".date("Ymd").".log","a");
//	 	$out=date('Ymd h:i:s A') . "\t" . $var_Name . " = ". $$var_Name . "\n";
//		fwrite($fp,$out);
//		fclose($fp);
   error_log("$var_Name = $$var_Name\n\r",3,'/opt/ABCD/www/bases/log/error.log');

//                $debug_result='OK';
                return $var_Name;
}
  function debug_log2(){
  echo 'debugging !';
  //die;
  return date('Ymd h:i:s A');
  }


}

?>