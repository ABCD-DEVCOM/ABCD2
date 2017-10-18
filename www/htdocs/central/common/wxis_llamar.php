<?php
global $server_url, $wxis_exec, $wxisUrl, $unicode;
//CHANGED
	if (isset($arrHttp["lock"]) and $arrHttp["lock"]=="S"){
		$query.="&lock=S";
	}
    $contenido="";
    $content="";
    $err_wxis="";
    if (isset($_SESSION["MULTIPLE_DB_FORMATS"]) and $_SESSION["MULTIPLE_DB_FORMATS"]=="Y"){
    	$actual_db="";
    	if (isset($_SESSION["PREV_DB"]))
    		$prev_db=$_SESSION["PREV_DB"];
    	else
    		$prev_db="";
    	$parms=explode('&',$query);
    	foreach ($parms as $pp){
    		if (substr($pp,0,5)=='base='){
    			$actual_db=trim(substr($pp,5));
    			break;
    		}
    	}
    	if ($actual_db!=$prev_db){
    		$_SESSION["PREV_DB"]=$actual_db;
    		if (file_exists($db_path.$actual_db."/dr_path.def")){
    			$drb=file($db_path.$actual_db."/dr_path.def");
    			foreach ($drb as $value){
    				$value=trim($value);
    				if (trim($value)!=""){
    					if (substr($value,0,9)=="wxis_get="){
    						$Wxis=trim(substr($value,9));
    					}
    					if (substr($value,0,10)=="wxis_post="){
    						$wxisUrl=trim(substr($value,10));
    					}
    				}
    			}
    		}
    	}
    }
	
// next line to make sure password is checked with ANSI-database acces
if ($actual_db == "acces") {$wxisUrl=$server_url."/cgi-bin/ansi/".$wxis_exec; }

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
		$result=file_get_contents($wxisUrl,false, $context);
        $con=explode("\n",$result);
        $ix=0;
        $contenido=array();
        foreach ($con as $value) {
           	if (substr($value,0,4)=="WXIS"){
           		$err_wxis.=$value."<br>";
           	}
          // 	echo "***$value<br>";
        	$contenido[]=$value;
        }
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
           	//echo "***$value<br>";

        }
       if ($err_wxis!="") {
       		echo "<font color=red size=+1>$err_wxis</font>";
       		//die;
       	}
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