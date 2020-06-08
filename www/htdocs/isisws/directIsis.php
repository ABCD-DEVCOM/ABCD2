<?php

/*
 * This file substitute the isiswsdl, webservices using nuSOAP was abandon.
 * Now the ISIS database, is called directly by host using fsockopen.
 */

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

// --- Funciones privadas de ejecucion del webservice
$wxis_host = $_SERVER['HTTP_HOST'];
if (stripos($_SERVER["SERVER_SOFTWARE"],"Win")>0) {
$wxis_action = "/cgi-bin/ansi/wxis.exe";
include("/ABCD/www/htdocs/central/config.php");
}else{
$wxis_action = "/cgi-bin/ansi/wxis";
include("/opt/ABCD/www/htdocs/central/config.php");
}

/*
 * This function call through fsockopen function an host that return the xml
 * file with the data you ask.
 * @param $url is mounted by wxis_url function
 
 */
 function file_get_contents_mbs($filename)
    {
       $fh = fopen($filename,'r');
       
        clearstatcache();
        
            $data = '';
            while (!feof($fh)) {
                $data .= fread($fh, 8192);
            }
        

        fclose($fh);
        return $data;
    }
 function wxis_document_post( $url, $content = "" )
{
global $wxis_action, $db_path, $Wxis;
$tmp=explode("&gizmo",$url);
$url=$tmp[0];
if(strpos($url,"write.xis"))
{
//include("/opt/ABCD/www/htdocs/central/config.php");	
//include("/ABCD/www/htdocs/central/config.php");
$content_aux=str_replace("<field ","<field action=add ",$content);
$content_aux=str_replace("<occ>","",$content_aux);
$content_aux=str_replace("</occ>","",$content_aux);
$field=$_POST["field"];
//foreach($field as $key =>$value) {echo $key."->".$value."<br/>";}exit;
$db=strtolower ($field["dataBase"]);
if($db=="") $db=strtolower ($field["database"]);//in mask
if($db=="") $db=$_GET["m"];
if($db=="titleplus" || $db=="holdings" || $db=="facic")
{
	if($db=="titleplus") $db="titlePlus";
	session_start();
	$center=$_SESSION['libraryDir']."/";//selected library when user login
	$db=$center.$db;
}
$mfn=$_POST["mfn"];
if(!intval($mfn)){//user is creating new record
$str1="<IsisScript name=new>
<parm name=cipar><pft>'$db.*=".$db_path."secs-web/$db.*',/
'htm.pft=$db.pft'</pft></parm>
<do task=update>
<parm name=db>$db</parm>
<parm name=fst><pft>cat('$db.fst')</pft></parm>
<parm name=mfn>New</parm>
<field action=define tag=1102>Isis_Status</field>
<update>";
$str2="<write>Unlock</write>
<display>
<pft>if val(v1102) = 0 then '<b>Created!</b><hr>' fi </pft>
<pft>if val(v1102) = 1 then '<b>Sorry, no records created!</b><hr>' fi </pft>
</display>
</update>
</do>
</IsisScript>";

}
else if(intval($mfn))//editing
{
$str1="<IsisScript name=edit>
			<parm name=cipar><pft>'$db.*=".$db_path."secs-web/$db.*',/
'htm.pft=$db.pft'</pft></parm>
			<do task=update>
<parm name=db>".$db_path."secs-web/$db</parm>
<parm name=lockid>aswerty</parm>
<parm name=mfn>$mfn</parm>
<parm name=fst><pft>cat('".$db_path."secs-web/$db.fst')</pft></parm>
<field action=define tag=1101>Isis_Lock</field>
<field action=define tag=1102>Isis_Status</field>
<update>
<write>Lock</write>";
$itag=1;
$delete_tag="";
//while($itag<=9999)
//{
//	$delete_tag.="<field action=delete tag=$itag>all</field>";$itag++;
//}
$delete_tag.="<proc><pft>,'d*'</pft></proc>";
$content_aux=$delete_tag.$content_aux;
$str2="<write>Unlock</write>
<display><pft>if val(v1102)=0 then
'<b>Update successful!</b>' fi</pft></display>
</update>
</do>
</IsisScript>";	
}
$str=$str1.$content_aux.$str2;
$new_name="new_".time().".xis";
//$new_name="new.xis";

//echo "script=$db_path" , "secs-web/$new_name<BR>";
@ $fp = fopen($db_path."secs-web/$new_name", "w");
@  flock($fp, 2);
   fwrite($fp, $str);
   fclose($fp);
   $IsisScript=$Wxis." IsisScript=".$db_path."secs-web/$new_name";
   exec($IsisScript,$out,$b);
      $execScript=$IsisScript;
//error_log("execScript = $execScript --- $db_path\n\r",3,'\ABCD\www\bases\log\error.log');
//   unlink($db_path."secs-web/$new_name");
    return;
}
	$result=file_get_contents_mbs($url);
	
	
     return strstr($result,"<");
}

function wxis_document_post2( $url, $content = "" )
{

	$tmp=explode("&gizmo",$url);
$url=$tmp[0];
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
        print "Function fsockopen must be enabled in file PHP.INI, set allow_url_fopen = On\n";
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
	/*while ( list($key, $value) = each($paramSplited) )
	{
		if ( trim($value) != "" && substr($value,0,1) != "/" )
		{
			$request .= "&" . $value;
		}
	}*/
	foreach($paramSplited as $value)
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


?>
