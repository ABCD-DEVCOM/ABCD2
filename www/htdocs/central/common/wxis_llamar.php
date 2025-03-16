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
20220321 fho4abcd Remove syspar addition in url (can be done by default par file)
20220710 fho4abcd Remove rubbish+clean error for POST+improve GET+no exception for dump by login+better pop-up text
20220716 fho4abcd Add IsisScript value to errormessage
20221028 fho4abcd Log stamp in 24 hour format
20250310 fho4abcd Write log controlled by $log (set in abcd.def parameter REG_LOG)
*/
global $def_db,$server_url, $wxis_exec, $wxisUrl, $unicode,$charset,$cgibin_path,$postMethod,$meta_encoding,$def,$arrHttp;
global $ABCD_scripts_path,$app_path, $log;
unset($contenido);  // This array will get the text of the result
$err_wxis="";       // An empty variable indicates that no error occurred

if (isset($arrHttp["lock"]) and $arrHttp["lock"]=="S"){
    $query.="&lock=S";
}

parse_str($query, $arr_query);
$actual_db=$arr_query["base"];

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

// Run using POST method 
if (isset($wxisUrl) and $wxisUrl!=""){
    $query.="&path_db=".$db_path;
    $url="IsisScript=$IsisScript$query&cttype=s";
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
        $contenido=array();
        foreach ($con as $value) {
            $contenido[]=$value;
            if (substr($value,0,4)=="WXIS"){
                $err_wxis.=$value."<br>";
                $err_hint="&rarr; Multiple causes may exist. Suggested hints:<br>&rarr; ";
                if ( strpos($value,"|tmpnam|")>0 ) {
                    $err_wxis.=$err_hint."The default temporary folder could not be used.<br>";
                    $contenido[]="<br><br><div style='color:blue'>The default temporary folder could not be used for some reason.<br>";
                    $contenido[]="Possible workaround: consider explicit definition of a temporary folder by adding a line like:<br>";
                    $contenido[]="<strong>&nbsp;&nbsp;&nbsp;ci_tempdir=%path_database%wrk</strong><br>";
                    $contenido[]="to file <b>&lt;dbname&gt;.par</b>.</div>";
                }
                if ( strpos($value,"|Invalid operand class")>0 ) $err_wxis.=$err_hint."Check the existence and protection of the ".$actual_db.".par file<br>";
                if ( strpos($value,"|dbxopen:")>0 ) {
                    $err_wxis.=$err_hint."Check location of the ".$actual_db." folder and its content<br>";
                    $err_wxis.="&rarr; "."Check the content of the ".$actual_db.".par file<br>";
                }
                $err_wxis.="IsisScript=".$IsisScript."<br>";
                $err_wxis.="query=".$query."<br>";
            }
        }
    }
    if ($err_wxis!="") {
        echo "<font color=red size=+1>$err_wxis</font>";
        // In case of a login show the problem to the user with an alert
        // Without alert the login screen overwrites the error message.
        // Not translated as more things can be wrong in this stage
        // Do not die to enable login with the emergency login
        if (strpos($query,"login=")>0) {
            ?>
            <script>type="text/javascript">
            alert("Hint: Use central/test/wxis.php to debug problems with the database containing login information (<?php echo $actual_db;?>)")
            </script>
            <?php
        }
    }
}else{ // Run using GET method 
    $query.="&path_db=".$db_path;
    putenv('REQUEST_METHOD=GET');
    $q=explode("&",$query);
    $query="";
    /*
    ** Cleanup the query string
    ** Remove leading/trailing white space
    ** Ensure that the first parameter gets an &
    */
    foreach ($q as $value){
        if (trim($value!="")){
            $ix=strpos($value,"=");
            if ($ix>0){
                $key=substr($value,0,$ix);
                $par=substr($value,$ix+1);
                $query.="&".$key."=".$par;
            }
        }
    }
    putenv('QUERY_STRING='."?xx=".$query);
    exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
    foreach ($contenido as $value) {
        if (substr($value,0,4)=="WXIS"){
            $err_wxis.=$value."<br>";
        }
    }
    if ($err_wxis!="") {
        echo "<font color=red size=+1>$err_wxis</font>";
        // In case of a login show the problem to the user with an alert
        // Without alert the login screen overwrites the error message.
        // Not translated as more things can be wrong in this stage
        // Do not die to enable login with the emergency login
        if (strpos($query,"login=")>0) {
            ?>
            <script>type="text/javascript">
            alert("Hint: Use central/test/wxis.php to debug problems with the database containing login information (<?php echo $actual_db;?>)")
            </script>
            <?php
        }
    }
}
// Convert to UTF-8 if necessary
$cset=strtoupper($meta_encoding);
unset($cont_cnv);
if ($cset=="UTF-8" and strtoupper($unicode)=="ANSI"){
    foreach ($contenido as $value){
        $cont_cnv[]=mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1');
    }
    if (isset($cont_cnv))$contenido=$cont_cnv;
}
/////////// logging /////////
// Write a line for this action to the log file
// Controlled by the global $log setting and the existence of the log folder
if (isset($log) && $log=="Y" && is_writable($db_path."log") && is_dir($db_path."log")){
    $fp=fopen($db_path."log/log_".date("Ymd").".log","a");
    $out=date('Ymd H:i:s')."\t";
    if( isset($_SESSION['login'])) {
        // this is the logged in name
        $out.=$_SESSION['login']."\t";
    } else if (isset($arrHttp["login"])) {
        // this is the name before login is granted, shows also unauthorized tries
        $out.=$arrHttp["login"]."(ini)"."\t";
    }
    $out.=$_SERVER["PHP_SELF"]."\t";
    $out.=$IsisScript."\t";
    // dump query string
    $out.=str_replace("\n"," ",urldecode($query))."\t";
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