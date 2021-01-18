<?php
global $def_db,$server_url, $wxis_exec, $wxisUrl, $unicode,$MULTIPLE_DB_FORMATS,$charset,$cgibin_path,$postMethod,$mx_exec,$meta_encoding,$page_encoding,$def,$arrHttp,$charset;
//CHANGED
	if (isset($arrHttp["lock"]) and $arrHttp["lock"]=="S"){
		$query.="&lock=S";
	}
    unset($contenido);
    $content="";
    $err_wxis="";
    parse_str($query, $arr_query);
    $actual_db=$arr_query["base"];
    $charset_db="";
    //$MULTIPLE_DB_FORMATS="Y";
    if (isset($_SESSION["MULTIPLE_DB_FORMATS"]) and $_SESSION["MULTIPLE_DB_FORMATS"]=="Y" or isset($MULTIPLE_DB_FORMATS) and $MULTIPLE_DB_FORMATS=="Y"){

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
			//$meta_encoding="ISO-8859-1";
		} else {
			$unicode='utf8';
			$charset="UTF-8";
			//$meta_encoding="UTF-8";
		}
        //echo "<h1>$unicode</h1>";
		$cisis_path=$cgibin_path;

		if ($unicode!="") {
			$cisis_path.=$unicode;
		}
		if ($cisis_ver!="") {
			$cisis_ver.="/";
		}
		$cisis_path.=$cisis_ver;   // path to directory with correct CISIS-executables
		$mx_path=$cisis_path.$mx_exec;// path to mx-executable
		if ($postMethod == '1'){
			$wxisUrl=$server_url."/cgi-bin/";
			if ($unicode!="")
				$wxisUrl.="$unicode/";
            if ($cisis_ver!=""){
               	$wxisUrl.=$cisis_ver.$wxis_exec;
            }else{
               	$wxisUrl.="".$wxis_exec;
            }
				  // POST method used
			$Wxis="";
		}else{
 			$wxisUrl="";
 			$Wxis=$cgibin_path;
 			if ($unicode!="") $Wxis.="$unicode/";
 			if ($cisis_ver!="") $Wxis.=$cisis_ver."/";
 			$Wxis.=$wxis_exec;   //GET method is used
		}

   		//echo "<p>$postMethod - ".$wxisUrl."  ".$Wxis. " $IsisScript";die;
   	}

/*// next line to make sure password is checked with ANSI-database acces
IF ($actual_db == "acces" ) //OR $actual_db== "loanobjects" OR $actual_db= "trans")
{
	$wxisUrl=$server_url."/cgi-bin/ansi/".$wxis_exec;
	$cisis_ver="";
}
*/
	if (isset($wxisUrl) and $wxisUrl!=""){
        $query.="&path_db=".$db_path;
        $url="IsisScript=$IsisScript$query&cttype=s";
		if (file_exists($db_path."par/syspar.par"))
        	$url.="&syspar=$db_path"."par/syspar.par";

        parse_str($url, $arr_url);
		$postdata = http_build_query($arr_url);
		$opts = array('http' =>
    				array(
        					'method'  => 'POST',
        					'header'  => 'Content-type: application/x-www-form-urlencoded',
        					'content' => $postdata

    				     )
					);
		$context = stream_context_create($opts);
// MAIN POST CONNECTION in following line
		unset($result);
		unset($contenido);
		unset($con);
        $result=file_get_contents($wxisUrl,false, $context);
        //$result=file_get_contents('php://input',false, $context);
        $con=explode("\n",$result);
        $ix=0;
        $contenido=array();
        foreach ($con as $value) {
           	if (substr($value,0,4)=="WXIS"){
           		$err_wxis.=$value."<br>";
           	}
        	$contenido[]=$value;
        }
        $contenido=$con;
       if ($err_wxis!="") echo "<font color=red size=+1>$err_wxis</font>";
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
	 	$err_wxis="";
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
 //if (isset($log) and $log=="Y"){
 	if (is_dir($db_path."log") and isset($_SESSION['login'])){

	 	$fp=fopen($db_path."log/log_".date("Ymd").".log","a");
	 	$out=date('Ymd h:i:s A')."\t".$_SESSION['login']."\t".$_SERVER["PHP_SELF"]."\t".$IsisScript."\t".str_replace("\n"," ",urldecode($query))."\n";
		fwrite($fp,$out);
		fclose($fp);
	}
 //}
?>