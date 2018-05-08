<?php

// Pull in the NuSOAP code
require_once('nusoap.php');

// Agregado por Emiliano de acuerdo a 
// http://sourceforge.net/mailarchive/message.php?msg_name=472AC8DF.9030703%40campusactivism.org
// bajo la idea de reducir la cantidad de memoria, mejorar performance

nusoap_base::setGlobalDebugLevel(0);

// Create the server instance
$server = new soap_server();
// Initialize WSDL support
$server->configureWSDL('wisismarc', 'urn:wisismarc');
// Register the method to expose
$server->register('IsisWrite',                // method name
    array('xmlparameters' => 'xsd:string','xmlcontent' => 'xsd:string'),        // input parameters
    array('return' => 'xsd:string'),      // output parameters
    'urn:wisis',                      // namespace
    'urn:wisis#IsisWrite',                // soapaction
    'rpc',                                // style
    'encoded',                            // use
    'Realiza la escritura de un registro'            // documentation
);


$server->register('IsisSearch',                // method name
    array('xmlparameters' => 'xsd:string'),        // input parameters
    array('return' => 'xsd:string'),      // output parameters
    'urn:wisis',                      // namespace
    'urn:wisis#IsisSearch',                // soapaction
    'rpc',                                // style
    'encoded',                            // use
    'Realiza la busqueda de un registro'            // documentation
);


$server->register('IsisMfnRange',                // method name
    array('xmlparameters' => 'xsd:string'),        // input parameters
    array('return' => 'xsd:string'),      // output parameters
    'urn:wisis',                      // namespace
    'urn:wisis#IsisSearch',                // soapaction
    'rpc',                                // style
    'encoded',                            // use
    'Recorre una base de datos'            // documentation
);

/*$server->register('IsisMfnRange',                // method name
    array('xmlparameters' => 'xsd:string'),        // input parameters
    array('return' => 'xsd:string'),      // output parameters
    'urn:wisis',                      // namespace
    'urn:wisis#IsisSearch',                // soapaction
    'rpc',                                // style
    'encoded',                            // use
    'Recorre una base de datos'            // documentation
);*/

$server->register('IsisSearchSort',                // method name
    array('xmlparameters' => 'xsd:string'),        // input parameters
    array('return' => 'xsd:string'),      // output parameters
    'urn:wisis',                      // namespace
    'urn:wisis#IsisSearchSort',                // soapaction
    'rpc',                                // style
    'encoded',                            // use
    'pesquisa numa base com sort por campo'            // documentation
);

$server->register('IsisSearchMask',                // method name
    array('xmlparameters' => 'xsd:string'),        // input parameters
    array('return' => 'xsd:string'),      // output parameters
    'urn:wisis',                      // namespace
    'urn:wisis#IsisSearchMask',                // soapaction
    'rpc',                                // style
    'encoded',                            // use
    'Controla un registro basado en otra bdd que contiene pfts de control'            // documentation
);
//Added by Domingos 07/02/2008 v0.1
$server->register("IsisIndex",
		array("xmlparameters" => "xsd:string"),
		array("return" => "xsd:string"),
		"urn:wisis",
		"urn:wisis#IsisIndex",
		"rpc",
		"encoded",
		"Retorna os Indices de Pesquisa da Base de dados"
		);

$server->register('IsisDelete',                // method name
    array('xmlparameters' => 'xsd:string'),        // input parameters
    array('return' => 'xsd:string'),      // output parameters
    'urn:wisis',                      // namespace
    'urn:wisis#IsisSearch',                // soapaction
    'rpc',                                // style
    'encoded',                            // use
    'Controla un registro basado en otra bdd que contiene pfts de control'            // documentation
);

$server->register('IsisMultDelete',                // method name
    array('xmlparameters' => 'xsd:string'),        // input parameters
    array('return' => 'xsd:string'),      // output parameters
    'urn:wisis',                      // namespace
    'urn:wisis#IsisSearch',                // soapaction
    'rpc',                                // style
    'encoded',                            // use
    'Controla un registro basado en otra bdd que contiene pfts de control'            // documentation
);


$server->register('IsisKeyrangeMfnrange',                // method name
    array('xmlparameters' => 'xsd:string'),        // input parameters
    array('return' => 'xsd:string'),      // output parameters
    'urn:wisis',                      // namespace
    'urn:wisis#IsisKeyrangeMfnrange',                // soapaction
    'rpc',                                // style
    'encoded',                            // use
    'Lista os registros nao pelo MFN mas usando uma expressao'            // documentation
);



// Define the method as a PHP function

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
	return utf8_encode(wxis_search($parametros));        
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



// --- Funciones privadas de ejecuci�n del webservice

$wxis_host = $_SERVER['HTTP_HOST'];
$wxis_action = "/cgi-bin/ansi/wxis.exe";

function wxis_document_post( $url, $content = "" )
{ 
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
    //echo $host;
    //echo $port;
    //die;
    
	$fp = fsockopen($host, $port, &$errno, &$errstr, $timeout);
	
	fputs( $fp, $ReqHeader ); 
	if ($fp) {
		while (!feof($fp)){
			$result .= fgets($fp, 4096);
		}
	}
	
	
    
    //echo "Esta seria la respuesta:".strstr($result,"<");
    //die;
    return strstr($result,"<"); 
}

function wxis_url ( $IsisScript, $param )
{
	global $wxis_host;
	global $wxis_action;

	$request = "http://" . $wxis_host . $wxis_action . "?" . "IsisScript=wxis-modules/" . $IsisScript;

	$param = str_replace("<parameters>", "", $param);
	$param = str_replace("</parameters>", "", $param);
	$param = str_replace(">", "=", $param);
	$paramSplited = split("<",$param);
	reset($paramSplited);
	foreach($paramSplited as $key=>$value )
	{
		if ( trim($value) != "" && substr($value,0,1) != "/" )
		{
			$request .= "&" . $value;
		}
	}	
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

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>