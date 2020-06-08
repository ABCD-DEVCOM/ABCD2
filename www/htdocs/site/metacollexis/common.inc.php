<?php
//   common.inc biblioteca do projeto metaiAH

//==============================================================================

function getElementValue ($xml, $element, $attributes = '') 
{
    if ($attributes == '') {
	     $start_string = "<" . $element . ">";
	} else {
    	 $start_string = "<" . $element . " " . $attributes . ">";
	}
	$end_string = "</" . $element . ">";

    return substr($xml, strpos($xml, $start_string) + strlen($start_string), strpos($xml, $end_string) - strpos($xml, $start_string) - strlen($start_string));
}


//==============================================================================

function readData($readFrom, $removeHeader = true)
{

	$e = error_reporting(); 
	error_reporting($e & (E_ALL-E_WARNING)); 
	
    if (preg_match("~swish~", $readFrom)) {
	
		$swishStr = explode("&",trim($readFrom));
		
		// indexa o vetor pelo valor que estiver antes do sinal de "="
		foreach($swishStr as $i){
			$i_split = explode("=",$i);
			$swishArg[$i_split[0]] = $i_split[1];
		}
		
		$swishArgCount = ($GLOBALS["browse-swish"] ?  "-1" :  $swishArg["count"]);
		
		$swish = new swishe2XML ($swishArg["path"], $swishArg["expression"], $swishArg["index"],"", "swish", $swishArgCount);
		$swish_result = $swish->search();
		
		// transforma as entidades html em caracteres para não gerar erro no XSL transformation 
		$translateEntities = get_html_translation_table (HTML_ENTITIES);
		$translateEntities = array_flip ($translateEntities);
		$translateEntities["&"] = "&amp;";

		$swish_result= strtr ($swish_result, $translateEntities);
	
		return $swish_result;
		
	}else{	
	
		$query = strstr($readFrom, "?");
		
		if ( strlen($query) > 250 ){	
			$str = PostIt($readFrom);
		}else{		
			$str = "";
			$buffer = "";
			
			$readUrl = encodeValues($readFrom);
			$fp = fopen($readUrl,"r");
		
			if ($fp)
			{
				while (!feof ($fp)) {
				    $buffer= fgets($fp, 8096);
					$str.= $buffer;
				}
				fclose ($fp);
			}	
		}	

        if ( $removeHeader )
        {
                /* remove xml processing instruction */
                if ( strncasecmp($str, "<?xml", 5) == 0 )
                {
                        $pos = strpos($str, "?>");
                        if ( $pos > 0 )
                        {
                                $str = substr_replace($str,"",0,$pos + 2);
                        }
                }
        }
		
		return $str;
	}
}


//==============================================================================
function PostIt($url) { 

	// Strip URL  
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
	
	fputs( $fp, $ReqHeader ); 
	if ($fp) {
		while (!feof($fp)){
			$result .= fgets($fp, 4096);
		}		
	}		
    
    return strstr($result,"<"); 
  } 

//==============================================================================
function encodeValues( $docURL )
{

	if (ereg("\?", $docURL)) {
		$splited1[0] = substr($docURL, 0, strpos($docURL,"?"));
		$splited1[1] = substr($docURL, strpos($docURL,"?")+1);
	}else{
		return $docURL;
	}	
	
	$splited2 = explode( "&", $splited1[1] );

	if ( count($splited2) < 2 )
	{
		return $docURL;
	}
	$docURL = $splited1[0] . "?";
	$fisrt = true;
	foreach ($splited2 as $value)
	{
		if ( $first )
		{
			$first = false;
		}
		else
		{
			$docURL .= "&";
		}
		$splited3 = explode("=",$value);

		$docURL .= $splited3[0];
		/*
		if ( count($splited3) > 1 ){
			$docURL .= "=" . urlencode($splited3[1]);
		}
		*/
		
		if ( count($splited3) > 1 ){		
			for ($i = 1; $i < count($splited3); $i++){
				$docURL .= "=" . urlencode($splited3[$i]);
			}
		}	
		
	}
	return $docURL;
}


//==============================================================================
function inprocess($label, $status = "run") {

	global $def;
	
	if ($status == "init"){
		?>		
		<script language='javaScript'>
			var state;			
			state = window.open('','inprocess','left=240,top=225,width=320,height=150,toolbar=no,resize=false,menubar=no');
		</script>
		<?
		
	}elseif ($status == "end"){
	
		?>
			<script language='javascript'>
				state.close();
			</script>
		<?
		
	}else {
	
		?>
			<script language="javaScript">
					state.document.open('text/html');
					s = state.document;			
					
					s.writeln('<html>');
					s.writeln('  <head>');
					s.writeln('    <title>meta-Collexis</title>');
					s.writeln('    <link rel="stylesheet" href="../css/public/skins/regional/style-<?php=$_POST["lang"];?>.css"/>');
					s.writeln('  </head>');
					s.writeln('  <body id="popUp">');
					s.writeln('  <table width="320" height="120">');
					s.writeln('   <tr valign="middle">');
					s.writeln('  	<td>Consultando <b><? echo $label ?></b> </td>');
					s.writeln('   </tr>');			
					s.writeln('  </table>');			
					s.writeln('  </body>');	
					s.writeln('</html>');
					s.close();					
			</script>
		<?
		flush();
	}
  return;	
}


//==============================================================================
function readEnvironment($HTTP_SERVER_VARS,$root) {

	$xmlString = "<$root>\n";	  
		$xmlString.= "<script>" . $HTTP_SERVER_VARS["PHP_SELF"] . "</script>\n";
		$xmlString.= "<path-data>" .str_replace("search.php","",$HTTP_SERVER_VARS["PATH_INFO"]) . "</path-data>\n";
	$xmlString.= "</$root>\n";

	return $xmlString;

}

//==============================================================================
function readCGI($HTTP_VARS, $root) {

      //$HTTP_VARS may be $HTTP_GET_VARS or $HTTP_POST_VARS
      $xmlString = "<$root>\n";	
	  
      reset($HTTP_VARS);
      $myKey =  key($HTTP_VARS);

      while ($myKey){
         if (count($HTTP_VARS[$myKey]) <= 1) {
            $xmlString .= "<" . preg_replace("[\(|\)]","_",$myKey) .">" . trim($HTTP_VARS[$myKey]) ."</" . preg_replace("[\(|\)]","_",$myKey) . ">\n";
         } else {
           for($i = 0; $i < count($HTTP_VARS[$myKey]); $i++) {
               $xmlString .= "<" . preg_replace("[\(|\)]","_",$myKey) .">" . trim($HTTP_VARS[$myKey][$i]) ."</" .preg_replace("[\(|\)]","_",$myKey) . ">\n";
            }
         }
 	     next ($HTTP_VARS);
    	  $myKey = key($HTTP_VARS);
      }
      $xmlString .= "</$root>\n";

      return $xmlString;
}


//==============================================================================
function extractXMLFragment($xmlString, $matchNode, $matchId = "") {

		$xml_obj = parseXMLstring($xmlString);

		$match_template = new treeNode($matchNode);
		if ($matchId){
			$match_template->attributes["id"] = $matchId;
		}	

		$xml_obj->extract($peace, $match_template);
		$peace_node = $peace["nodes"][0];
		
	    return $peace_node;

}

//================================================================================================
function insertDefaultConnector( $exp, $connector = "and"){

	if ($connector == '') $connector = "and";
	
	$str = strtolower( $exp );
	$str = str_replace('\"','"', $exp);	
	
	preg_match_all('("[^"]*")', $str, $quotedExpressions);
	
	// Substitui expressões dentro de aspas por %~~%
	if ( $quotedExpressions ) 
	{
		for ( $i = 0; $i < count($quotedExpressions[0]); $i++ )
		{
			$qexp = $quotedExpressions[0][$i];
			$pos  = strpos($str,$qexp);
			
			$str = substr($str,0,$pos) . "%~~%"  . substr($str, strlen($qexp) + $pos);
		}	
	}
	
	// versao do replace que usa o conector AND ou OR 
	$patterns = array( "/^\\s+/", "/\\s+$/", "/\\s+/", "/ " . $connector . " (AND|OR|NOT) " . $connector . " /i", "/^NOT " . $connector . " /i", "/ NOT " . $connector . " /i", "/ AND /", "/ OR /", "/^NOT /", "/ NOT /" );
	$replacements = array( "", "", " " . $connector . " ", " \$1 ", "not ", " not ", " and ", " or ", "not ", " not " );

	$str = preg_replace( $patterns, $replacements, $str );
	
	// Insere de volta a expressão dentro de aspas
	if ( $quotedExpressions ) 
	{
		for ($i = 0; $i < count($quotedExpressions[0]); $i++)
		{
			$str = preg_replace("/%~~%/", $quotedExpressions[0][$i], $str, 1);
		}	
	}

	return $str;
}

?>