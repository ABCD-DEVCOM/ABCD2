<?php
/* Modifications
20210311 fho4abcd Add workaround in error message WXIS|execution error|file|tmpnam| Error detected on Windows
20210315 fho4abcd Small textual corrections + removed unused code for mx
20210315 fho4abcd Display better error message and set $err_wxis in that case too.
20210402 fho4abcd Code added to allow self-signed certificates for internal server calls
20210507 fho4abcd Improved logging:show login (without password), show cisisver, show wxis_error, time in 24 hour format
20210507 fho4abcd Activated workaround to cope with mixed cisis versions
20210610 fho4abcd Removed workaround
20210813 fho4abcd Improve include path
20220128 fho4abcd remove MULTIPLE_DB_FORMAT
20220313 fho4abcd Show alert in case of login errors
*/
global $def_db,$server_url, $wxis_exec, $wxisUrl, $unicode,$MULTIPLE_DB_FORMATS,$charset,$cgibin_path,$postMethod,$mx_exec,$meta_encoding,$page_encoding,$def,$arrHttp,$charset;
global $ABCD_scripts_path,$app_path;
unset($contenido);  // This array will get the text of the result
$err_wxis="";       // An empty variable indicates that no error occurred

if (isset($arrHttp["lock"]) and $arrHttp["lock"]=="S"){
    $query.="&lock=S";
}

parse_str($query, $arr_query);
$actual_db=$arr_query["base"];
$charset_db="";

// Always read dr_path.def
if (file_exists($db_path.$actual_db."/dr_path.def")){
    $def_db = parse_ini_file($db_path.$actual_db."/dr_path.def");
}
If (!isset($def_db["CISIS_VERSION"]))$def_db["CISIS_VERSION"]="";
if (!isset($def_db["UNICODE"]))	     $def_db["UNICODE"]=$def["UNICODE"];
$cisis_ver="";
if (isset($def_db["CISIS_VERSION"]) and $def_db["CISIS_VERSION"]!="16-60" )
    $cisis_ver=$def_db["CISIS_VERSION"];
if ( !isset($def_db["UNICODE"]) or $def_db["UNICODE"] == "ansi" || $def_db["UNICODE"] == '0' ) {
    $unicode='ansi';
    $charset="ISO-8859-1";
} else {
    $unicode='utf8';
    $charset="UTF-8";
}

if ($cisis_ver!="") {
    $cisis_ver.="/";
}

if ($postMethod == '1'){
    $wxisUrl=$server_url."/cgi-bin/";
    if ($unicode!="")
        $wxisUrl.="$unicode/";
    if ($cisis_ver!=""){
        $wxisUrl.=$cisis_ver.$wxis_exec;
    }else{
        $wxisUrl.="".$wxis_exec;
    }	  
    $Wxis=""; // POST method used
}else{
    $wxisUrl="";
    $Wxis=$cgibin_path;
    if ($unicode!="") $Wxis.="$unicode/";
    if ($cisis_ver!="") $Wxis.=$cisis_ver."/";
    $Wxis.=$wxis_exec;   //GET method is used
}


if (isset($wxisUrl) and $wxisUrl!=""){  //POST method 
    $query.="&path_db=".$db_path;
    $url="IsisScript=$IsisScript$query&cttype=s";
    if (file_exists($db_path."par/syspar.par"))
        $url.="&syspar=$db_path"."par/syspar.par";

    parse_str($url, $arr_url);
    $postdata = http_build_query($arr_url);
    include $ABCD_scripts_path.$app_path."/common/inc_setup-stream-context.php";
    unset($result);
    unset($con);
    // MAIN POST CONNECTION in following line
    $result=@file_get_contents($wxisUrl,false, $context);
    if ($result === false ) {
        $file_get_contents_error= error_get_last();
        $err_wxis="Error &rarr; ".$file_get_contents_error["message"];
        $err_wxis.="<br> in &rarr; ".$file_get_contents_error["file"];
        $contenido[] = ""; // do not break code that does not check correct
    } else {
        $con=explode("\n",$result);
        $ix=0;
        $contenido=array();
        foreach ($con as $value) {
            if (substr($value,0,4)=="WXIS"){
                $err_wxis.=$value."<br>";
            }
            //echo "<div>wxisll ".$value."</div>";
            $contenido[]=$value;
            if (substr($value,0,4)=="WXIS" && strpos($value,"|tmpnam|")>0 ) {
                $contenido[]="<br><br><div style='color:blue'>The default temporary folder could not be used for some reason.<br>";
                $contenido[]="Possible workaround: consider explicit definition of a temporary folder by adding a line like:<br>";
                $contenido[]="<strong>&nbsp;&nbsp;&nbsp;ci_tempdir=%path_database%wrk</strong><br>";
                $contenido[]="to file <b>par/syspar.par</b> or file <b>par/&lt;dbname&gt;.par</b>.</div>";
            }
        }
    }
    if ($err_wxis!="") {
        echo "<font color=red size=+1>$err_wxis</font>";
        // In case of a login show the problem to the user with an alert
        // Without alert the login screen overwrites the error message.
        // Not translated as more things can be wrong in this stage
        // Do not die to enable login with the emergency login
        if ($actual_db=="acces" && strpos($query,"login=")>0) {
            ?>
            <script>type="text/javascript">
            alert("Hint: Unicode encoding and/or CISIS version might not match with database acces")
            </script>
            <?php
        }
    }
}else{                      // GET-method used
    $query.="&path_db=".$db_path;
    putenv('REQUEST_METHOD=GET');
    $q=explode("&",$query);
    $query="";

    foreach ($q as $value){
        if (trim($value!="")){
            $ix=strpos($value,"=");
            if ($ix>0){
                $key=substr($value,0,$ix);
                $par=substr($value,$ix+1);
                if ($key=="cipar"){
                    if (!file_exists($par)){
                        $par="";
                    }
                }
                if ($par!="")
                    $query.="&".$key."=".$par;
            }
        }
    }
    if (file_exists($db_path."par/syspar.par"))
        $query.="&syspar=$db_path"."par/syspar.par";
    putenv('QUERY_STRING='."?xx=".$query);
    exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
    foreach ($contenido as $value) {
        if (substr($value,0,4)=="WXIS"){
            $err_wxis.=$value."<br>";
        }
    }
    if ($err_wxis!="") {
        echo "<font color=red size=+1>$err_wxis</font>";
    }
}

$cset=strtoupper($meta_encoding);
//echo $page_encoding." ".$cset." $unicode<P>";
unset($cont_cnv);
if ($cset=="UTF-8" and strtoupper($unicode)=="ANSI"){
    foreach ($contenido as $value){
        $cont_cnv[]=utf8_encode($value);
    }
    if (isset($cont_cnv))$contenido=$cont_cnv;
}
// Write a line for this action to the log file
if (is_writable($db_path."log") && is_dir($db_path."log")){
    $fp=fopen($db_path."log/log_".date("Ymd").".log","a");
    $out=date('Ymd h:i:s')."\t";
    if( isset($_SESSION['login'])) {
        // this is the logged in name
        $out.=$_SESSION['login']."\t";
    } else if (isset($arrHttp["login"])) {
        // this is the name before login is granted, shows also unauthorized tries
        $out.=$arrHttp["login"]."(ini)"."\t";
    }
    $out.=$_SERVER["PHP_SELF"]."\t";
    $out.=$IsisScript."\t";
    if ( strpos($IsisScript,"login.xis")==false) { 
        // dump query string of not used by login.xis
        $out.=str_replace("\n"," ",urldecode($query))."\t";
    } else {
        // do not dump credentials info for login.xis
        $out.="credentials_hidden_in_log\t";
    }
    if (isset($cisis_ver) ){
        $out.="cisis_ver=".$cisis_ver;
    } else {
        $out.="cisis_ver=not_set";
    }
    if ($err_wxis!="" ) { // Show wxis error reduced to single line
        $out_err_wxis=str_replace("<br>",".",$err_wxis);
        $out_err_wxis=str_replace("\r","",$out_err_wxis);
        $out_err_wxis=str_replace("\n","",$out_err_wxis);
        $out.="\tERROR:".$out_err_wxis;
    }
    $out.="\n";
    fwrite($fp,$out);
    fclose($fp);
}
?>