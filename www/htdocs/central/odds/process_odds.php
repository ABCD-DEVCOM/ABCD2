<?php
session_start();
	
// venimos del formulario?	
$reload = true;	
if (!isset($_SESSION["verifica"])) {
		$reload = false;
		$_SESSION["verifica"] = true;  
} 	
	
	// build back link	
	$parameters = "" ;		
	$parameters .= isset($_POST['tag630']) ? "&id=".trim($_POST['tag630']) : "";
	$parameters .= isset($_POST['tag510']) ? "&name=".trim($_POST['tag510']) : "";
	$parameters .= isset($_POST['tag528']) ? "&email=".trim($_POST['tag528']) : "";		
	$parameters .= isset($_POST['email_apoderado_chk']) ? "&email_apoderado_chk=".trim($_POST['email_apoderado_chk']) : "";
	$parameters .= isset($_POST['tag828']) ? "&email_apoderado=".trim($_POST['tag828']) : "";
	$parameters .= isset($_POST['tag512']) ? "&phone=".trim($_POST['tag512']) : "";
	//$parameters .= isset($_POST['tag006']) ? "&level=".trim($_POST['tag006']) : ""; 	
	$parameters .= isset($_POST['tag520']) ? "&category=".trim($_POST['tag520']) : "";
	$parameters .= isset($_POST['tag520_other']) ? "&category_other=".trim($_POST['tag520_other']) : "";	
	$parameters .= isset($_POST['js']) ? "&js=".trim($_POST['js']): "";	

	include_once("../../central/config.php");	
	
	$message_error = false;	
	if (isset($_POST['tag094']) == false) {
		$message_error = true;
	}	

	if (isset ($_GET['lang'])) {
		if ($_GET['lang'] != "") {
			$lang_param = $_GET['lang'];
		}
	} else if (isset ($_POST['lang'])) {
		if ($_POST['lang'] != "") {
			$lang_param = $_POST['lang'];

		}	
	} else {
		$lang_param = '';
	}	
	if ($lang_param != "") {
		// carga el lang desde la configuración
		$lang = $lang_param;
	}	

	include_once("lib/library.php");
	$requests = load_request_message($lang_param);	
	if ($message_error) {
		$message = $requests['notice_error'];	
	} else {
		if ($reload === false) {
			// get configs 
			$base  = "odds";
			$cipar = "odds.par";
			$mfn = "new";	
			/*
			$cn = get_cn($base, $db_path);
	 		if ($cn == "" or $cn == false){
				$fatal_cn = "Could not generate the control number";
	 		} */
	 		//other in source field			
			//if ($_POST["tag900"] == "others") {
	 		if (substr( $_POST["tag900"], 0, 7  )  == "others_") {		
				if (isset($_POST["tag900_other"])) {					
					if (trim($_POST["tag900_other"]) != "") {					
						$_POST["tag900"] = trim($_POST["tag900_other"]);
					}
				}
			}
			unset($_POST["tag900_other"]);
	 		//other in category field
			if ($_POST["tag520"] == "XX") {				
				if (isset($_POST["tag520_other"])) {					
					if (trim($_POST["tag520_other"]) != "") {					
						$_POST["tag520"] = trim($_POST["tag520_other"]);
					}
				}
			}
			unset($_POST["tag520_other"]);
			
			$tags = _flattenPOST($_POST, $cn);
			
			if ($tags != "") {
				$contenido = _saveData($xWxis, $tags, $db_path, $base, $cipar, $mfn, $Wxis, $wxisUrl);
			} else {
				die("error flatten");
			}
			if (empty($contenido)) {
				$message = $requests['notice_success'];
			} else {
				$message = $requests['notice_error']."<hr>";	
				var_dump($contenido);
			}	
		// RELOAD (el usuario recargó la página)
		} else {
			$message = $requests['notice_reload'];
		}
	}
	$with_close = false;
	if (isset($_POST['referer'])) {
		if ($_POST['referer']!="") {
			//var_dump($_POST); die();
			$parameters.="&referer=yes";
			if ($_POST['referer']=='sar') {
				//$message .= "<br/><br/><a href='form_odds.php?lang=$lang&sa=sa".$parameters."'>".$requests['notice_back']."</a><br><br>";
				$message .= "<br/><br/><a href='form_odds.php?lang=$lang".$parameters."'>".$requests['notice_back']."</a><br><br>";
			} else {
				//var_dump($_POST); die();
				$message .= "<br/><br/><a href='form_odds.php?lang=$lang".$parameters."'>".$requests['notice_back']."</a><br><br>";
				//$message .= "<br/><br/><a href='form_odds.php?lang=$lang&referer=yes".$parameters."'>".$requests['notice_back']."</a><br><br>";
			}
			$with_close = true;
		}
	}
	if (!$with_close) {
		$message .= "<br/><br/><a href='form_odds.php?lang=$lang".$parameters."'>".$requests['notice_back']."</a><br><br>";
	}
	if (isset($_POST['js'])) {
		if ($_POST['js'] == "yes") {
			$message.= '<input onclick="javascript:onClick=self.close()" type="button" class="send-button" value="'.$requests['cancel_button'].'"  />';
		}
	}

	/********************************************************************/

	function _execute_local($query, $db_path, $Wxis, $xwxis) {
		/* LOCKS !?
		if (isset($arrHttp["lock"]) and $arrHttp["lock"]=="S"){
			$query.="&lock=S";
		}		
	 	*/
        include_once("../../central/config.php");
        $IsisScript=$xwxis."actualizar.xis";
        //var_dump($IsisScript);
        //die;        
        //$ValorCapturado=urlencode("<630>ernesto</630>");
        /* test ::
        $query2 = "&base=odds&cipar=/abcd/www/bases/par/odds.par&Mfn=New&Opcion=crear&ValorCapturado=$ValorCapturado";
        echo($query2);
        */        

        //echo($query);
        
	 	include("../common/wxis_llamar.php");
		// logs
		if (is_dir($db_path."log")){
			$fp=fopen($db_path."log/log_".date("Ymd").".log","a");
			//TODO: Si es Linux, \n para salto de linea! 
			fwrite($fp,"**".date('l jS \of F Y h:i:s A')."\r\n");
			fwrite($fp,$_SERVER["PHP_SELF"]." ".$IsisScript." ".urldecode($query)."\r\n");
			fclose($fp);
		}
		return $result;
	} // fin execute()

	function _execute_remote($query, $db_path, $Wxis, $xwxis, $wxisUrl, $tags) {
		$query =  $xwxis."actualizar.xis".$query.urlencode($tags);		
		//include("../common/wxis_llamar.php");
		$url = $wxisUrl."?IsisScript=".$query."&cttype=Y&path_db=".$db_path;
		// ODON: $query = "/bvs/odonabcd/htdocs/central/dataentry/wxis/actualizar.xis&base=odds&cipar=/bvs/odonabcd/bases/par/odds.par&Mfn=New&Opcion=crear&ValorCapturado=".urlencode($valor_capturado);
		// ODON: $wxisUrl  = "http://www.bvsodon.org.uy:82/cgi-bin/wxis.exe";
		include("../common/wxis_llamar.php");
	} 
	
	function _saveData($xWxis, $tags, $db_path, $base, $cipar, $mfn, $wxis, $wxisUrl) {		
		if ($wxisUrl == '') {							
			$query = "&base=".$base ."&cipar=".$db_path."par/".$cipar."&Mfn=New&Opcion=crear&ValorCapturado=".$tags;
			$contenido = _execute_local($query, $db_path, $wxis, $xWxis);
		} else {
			$query = "&base=".$base ."&cipar=".$db_path."par/".$cipar."&Mfn=New&Opcion=crear&ValorCapturado=";
			$contenido = _execute_remote($query, $db_path, $wxis, $xWxis, $wxisUrl, $tags);
		}
		return $contenido;
	}
	
	function _flattenPOST($post, $cn) {

		if (!isset($post['email_apoderado_chk'])) {
			unset($post['tag828']);
		} else {
			if (is_null($post['tag828'])) {
				unset($post['tag828']);
			}
		}		

		$ValorCapturado = "";		
		$post["tag100"] = date("Ymd");		
		$processed_tags = array();
		foreach ($post as $key => $line) {	
			if (substr($key, 0, 3) == "tag") {
				$key=trim(substr($key,3));
				$lin=stripslashes($line);
				if (strpos($key, "_additional") !== false) {					
					$key = str_replace("_additional", "", $key);
				}
				if (strlen($key)==1) $key="000".$key;
				if (strlen($key)==2) $key="00".$key;
				if (strlen($key)==3) $key="0".$key;

				// repetibles
				if (isset($processed_tags[$key])) {
					$new_line = $processed_tags[$key] . "\n" .  $line;
					$processed_tags[$key] = $new_line;
				} else {
					$processed_tags[$key] = $line;
					// repetible para el mail, tag 528
					/*
					if ($key == "0528") {
						if (strpos($line, ", ") !== FALSE) {
							$a = explode (", ", $line);
							$processed_tags[$key] = trim($a[0]). "\n" .trim($a[1]);
						} else {
							$processed_tags[$key] = $line;	
						}
					}
					else {
					 	$processed_tags[$key] = $line;
					 }
					 */
				}				
			}
		}
		// cn en v001
		$processed_tags['0001'] = $cn;

		// tipo de literatura (v005)		
		if ($processed_tags['0006'] == 'as') {
			$processed_tags['0005'] = "S";
		} else if ($processed_tags['0006'] == 'am' || $processed_tags['0006'] == 'amc' ) {
			$processed_tags['0005'] = "M";
		} else if ($processed_tags['0006'] == 'at') {
			$processed_tags['0005'] = "T";
		} else if ($processed_tags['0006'] == 'al' || $processed_tags['0006'] == 'ad' || $processed_tags['0006'] == 'ar' || $processed_tags['0006'] == 'cj' || $processed_tags['0006'] == 'aj') {
			$processed_tags['0005'] = "L";
		}
		
		foreach ($processed_tags as $key => $line) {			
			$value = explode("\n", $line);			
			foreach ($value as $v) {				
				$ValorCapturado.='<'.$key.'>'.urlencode(trim($v)).'</'.$key.'>';
			}			
		}		
		return $ValorCapturado;
	}	
?>
 
<html>
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">			
    <title>ODDS data</title>      
    <link href="../css/odds.css" rel="stylesheet" type="text/css">	 

<body>	
<?php		
	
	include("lib/header.php");	
?>	

<div class="middle homepage">
	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
		<div class="boxTop">
			<div class="btLeft">&#160;</div>
			<div class="btRight">&#160;</div>
		</div>
		<div class="boxContent toolSection ">
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" > 
  <tbody>
  <tr>
    <td valign="top" class="cuerpoCuad">&nbsp;</td>
    <td colspan="2" valign="top" class="cuerpoText1">       
    <table width="780" border="0" cellspacing="0" cellpadding="1" bordercolor="#cccccc" class="textNove">
      <tbody>
      <tr>
	    <td height="12">
		<!-- SUBTITULO -->
		<?php
			echo $message;
		?>

		</td>
	  </tr>
	  </tbody>	  
	</table>
	</td>
  </tr>
  </tbody>
</table>

</div>	
<div class="spacer">&nbsp;</div>
<div class="boxBottom">
<div class="bbLeft">&#160;</div>
<div class="bbRight">&#160;</div>
</div>
</div>	
</div>	
<?php
include("../common/footer.php");		
	//include("lib/footer.php");
?>	
</body></html>
