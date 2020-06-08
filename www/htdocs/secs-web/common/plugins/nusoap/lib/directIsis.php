<?php

/*
 * This file substitute the isiswsdl, webservices using nuSOAP was abandon.
 * Now the ISIS database, is called directly by host using fsockopen.
 */

// Define the method as a PHP function

// --- Funciones privadas de ejecucion del webservice
$wxis_host = $_SERVER['HTTP_HOST'];
if (stripos($_SERVER["SERVER_SOFTWARE"],"Win")>0) {
$wxis_action = "/cgi-bin/ansi/wxis.exe";
}else{
$wxis_action = "/cgi-bin/ansi/wxis";
}

function IsisWrite($parametros, $contenido)
{
	return wxis_write($parametros,utf8_decode($contenido));
}
function IsisIndex($parametros){

	return utf8_encode(wxis_index($parametros));
}
function IsisUpdate($parametros)
{

	return wxis_edit($parametros);
}

function IsisKeyrangeMfnrange($parametros) {
	return utf8_encode(wxis_keyrange_mfnrange($parametros));
}
// Define the method as a PHP function
function IsisMfnRange($parametros)
{
	return utf8_encode(wxis_list($parametros));
}

// Define the method as a PHP function
function IsisSearch($parametros)
{
        $key = utf8_decode($parametros);
	return utf8_encode(wxis_search($key));
}


function IsisCheckQuality($parametros)
{
	return utf8_encode(wxis_quality($parametros));
}


function IsisDelete($parametros)
{
	return utf8_encode(wxis_delete($parametros));
}

function IsisMultDelete($parametros)
{
	return utf8_encode(wxis_mult_delete($parametros));
}


function IsisObtainUniqueId($parametros)
{
	return utf8_encode(wxis_uniqueId($parametros));
}
function IsisSearchSort($parametros)
{
	return wxis_sort ( $parametros );
}


/*
 * This function call through fsockopen function an host that return the xml
 * file with the data you ask.
 * @param $url is mounted by wxis_url function
 */

function wxis_document_post( $url, $content = "" )
{
$result=file_get_contents($url);
     return strstr($result,"<");
}

function wxis_document_post2( $url, $content = "" )
{
    $content = str_replace("\\\"","\"",$content);
    $content = str_replace("\n","",$content);
    $content = str_replace("\r","",$content);
    $content = str_replace("\\\\","\\",$content);

    // Strip URL
    $url_parts = parse_url($url);
    $host = $url_parts["host"];
    $port = isset($url_parts["port"]) ? $url_parts["port"] : 80;
    $path = $url_parts["path"];
    $query = $url_parts["query"];
    if ( $content != "" )
    {
            $query .= "&content=" . urlencode($content);
    }
    $timeout = 10;
    $contentLength = strlen($query);

    // Generate the request header
    $ReqHeader = "POST $path HTTP/1.0\n".
      "Host: $host\n".
      "User-Agent: PostIt\n".
      "Content-Type: application/x-www-form-urlencoded\n".
      "Content-Length: $contentLength\n\n".
      "$query\n";

    // Open the connection to the host, using socket
    if(function_exists("fsockopen")){
        $fp = fsockopen($host, $port, $errno, $errstr, $timeout);
    }else{
        print "Function fsockopen must be enable in file PHP.INI, set allow_url_fopen = On\n";
    }
    // Open the connection to the host, using socket
    //$fp = fopen($url, "r");
    //var_dump($errno, $errstr);

    if (!$fp) {
        print "Could not connect to socket!\n $errstr ($errno)<br />\n";
    } else {
        if (!fwrite( $fp, $ReqHeader)) {
            throw new Exception("Writing File Error $file");
            return "No content";
        }
        $result="";
        while (!feof($fp)){
                $result .= fgets($fp, 4096);
        }
    }
    return strstr($result,"<");
}

/*
 * This function return the url, wich call the ISIS database.
 * If you put this url in a browser, it will call the ISIS database directly
 * and get as result an xml file.
 */
function wxis_url ( $IsisScript, $param )
{
	global $wxis_host;
	global $wxis_action;

	$request = "http://" . $wxis_host . $wxis_action . "?" . "IsisScript=wxis-modules/" . $IsisScript;

	$param = str_replace("<parameters>", "", $param);
	$param = str_replace("</parameters>", "", $param);
	$param = str_replace(">", "=", $param);
	$paramSplited = explode("<",$param);
	reset($paramSplited);
	foreach($paramSplited as $key=>$value )
	{
		if ( trim($value) != "" && substr($value,0,1) != "/" )
		{
			$request .= "&" . $value;
		}
	}
//echo "request=$request<BR>";
	return $request;
}

function wxis_list ( $param )
{
	return wxis_document_post(wxis_url("list.xis",$param));
}

function wxis_search ( $param )
{
        return wxis_document_post(wxis_url("search.xis",$param));
}

function wxis_index ( $param )
{
	return wxis_document_post(wxis_url("index.xis",$param));
}

function wxis_edit ( $param )
{
	return wxis_document_post(wxis_url("edit.xis",$param));
}

function wxis_write ( $param, $content )
{
        return wxis_document_post(wxis_url("write.xis",$param),$content);
}

function wxis_delete ( $param )
{
	return wxis_document_post(wxis_url("delete.xis",$param));
}

function wxis_mult_delete ( $param )
{
	return wxis_document_post(wxis_url("deleteRelatedTo.xis",$param));
}

function wxis_control ( $param )
{
	return wxis_document_post(wxis_url("control.xis",$param));
}


function wxis_quality ( $param )
{
	return wxis_document_post(wxis_url("checkquality.xis",$param));
}

function wxis_uniqueid ( $param )
{
	return wxis_document_post(wxis_url("obtainUniqueId.xis",$param));
}
function wxis_keyrange ( $param )
{
	return wxis_document_post(wxis_url("keyrange.xis",$param));
}

function wxis_keyrange_mfnrange ( $param )
{
	return wxis_document_post(wxis_url("keyrange_mfnrange.xis",$param));
}

function wxis_sort ( $param )
{
    return wxis_document_post(wxis_url("sort.xis",$param));
}


?>
