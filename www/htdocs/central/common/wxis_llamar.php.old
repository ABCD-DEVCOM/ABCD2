<?php
//CHANGED
	if (isset($arrHttp["lock"]) and $arrHttp["lock"]=="S"){		$query.="&lock=S";	}
    $contenido="";
    $content="";
    $err_wxis="";

	if (isset($wxisUrl) and $wxisUrl!=""){
		$query.="&path_db=".$db_path;
		$url="$wxisUrl?IsisScript=$IsisScript$query&cttype=s";
		if (file_exists($db_path."par/syspar.par"))
        	$url.="&syspar=$db_path"."par/syspar.par";

		$url_parts = parse_url($url);
		$host = $url_parts["host"];
		$port = ($url_parts["port"]) ? $url_parts["port"] : 80;
		$path = $url_parts["path"];
		$query = $url_parts["query"];
		$timeout = 10;
		$contentLength = strlen($url_parts["query"]);
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
		//ECHO $host;
	    $result="";
		fputs( $fp, $ReqHeader );
        $inicio_content="";
		if ($fp) {
			while (!feof($fp)){
        	    $a=fgets($fp, 4096);
                //ECho "$a<br>";
                $content.=$a;
                if (trim($a)=="Content-Type: text/html"){                  	$inicio_content="SI";
                   	continue;                }
                if ($inicio_content=="SI"){                  	if (trim($a)!="")
						$result .=$a ;
				}
			}
		}

/*		$result=file_get_contents($url);*/        //ESTA FORMA DE LEER NO SE USA PORQUE DA MUCHOS PROBLEMAS CON EL URL
        $con=explode("\n",$result);
        $ix=0;
        $contenido=array();
        foreach ($con as $value) {
           	if (substr($value,0,4)=="WXIS"){           		$err_wxis.=$value."<br>";           	}           	//echo "***$value<br>";
        	$contenido[]=$value;
        }
       if ($err_wxis!="") echo "<font color=red size=+1>$err_wxis</font>";
  }else{

      	$query.="&path_db=".$db_path;
		putenv('REQUEST_METHOD=GET');
		$q=explode("&",$query);
		$query="";

		foreach ($q as $value){
			if (trim($value!="")){				$ix=strpos($value,"=");
				if ($ix>0){					$key=substr($value,0,$ix);
					$par=substr($value,$ix+1);
					if ($key=="cipar"){						if (!file_exists($par)){							$par="";						}					}
					if ($par!="")
						$query.="&".$key."=".$par;				}
			}		}
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
       if ($err_wxis!="") {       		echo "<font color=red size=+1>$err_wxis</font>";
       		//die;
       	}
 }
 //if (isset($log) and $log=="Y"){
 	if (is_dir($db_path."log") and isset($_SESSION['login'])){	 	$fp=fopen($db_path."log/log_".date("Ymd").".log","a");
		fwrite($fp,"**".date('l jS \of F Y h:i:s A')." Operador: ".$_SESSION['login']."\n");
		fwrite($fp,$_SERVER["PHP_SELF"]." ".$IsisScript." ".urldecode($query)."\n");
		fclose($fp);
	} //}
?>