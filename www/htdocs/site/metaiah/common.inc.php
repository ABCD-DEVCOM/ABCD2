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

function readData($readFrom, $removeHeader = true) {
    if (preg_match("/swish/i", $readFrom)) {

        $swishStr = explode("&",trim($readFrom));

        // indexa o vetor pelo valor que estiver antes do sinal de "="
        foreach($swishStr as $i) {
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

    }else {

        //check request url for method=POST parameter, if not default GET
        if ( preg_match('/method=POST/',$readFrom) ) {
            $str = PostIt($readUrl);
        }else{
            $readUrl = encodeValues($readFrom);        
            $str = GetIt($readUrl);
        }

        $sxe = simplexml_load_string($str);

        if($sxe){
            if ( $removeHeader ) {
                /* remove xml processing instruction */
                if ( strncasecmp($str, "<?xml", 5) == 0 ) {
                    $pos = strpos($str, "?>");
                    if ( $pos > 0 ) {
                        $str = substr_replace($str,"",0,$pos + 2);
                    }
                }
            }
            return $str;
        }

        return '<error type="invalid xml"/>';
    }
}

function display_xml_error($error, $xml)
{
    $return  = $xml[$error->line - 1] . "\n";
    $return .= str_repeat('-', $error->column) . "^\n";

    switch ($error->level) {
        case LIBXML_ERR_WARNING:
            $return .= "Warning $error->code: ";
            break;
         case LIBXML_ERR_ERROR:
            $return .= "Error $error->code: ";
            break;
        case LIBXML_ERR_FATAL:
            $return .= "Fatal Error $error->code: ";
            break;
    }

    $return .= trim($error->message) .
               "\n  Line: $error->line" .
               "\n  Column: $error->column";

    if ($error->file) {
        $return .= "\n  File: $error->file";
    }

    return "$return\n\n--------------------------------------------\n\n";
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
//      "Content-Type: application/x-www-form-urlencoded; charset=iso-8859-1\n".
      "Content-Type: application/x-www-form-urlencoded; charset=utf-8\n".
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
    fclose($fp);

    $result_body = substr($result, strpos($result, "\r\n\r\n") + 4);

    return $result_body;
  }

//==============================================================================
function GetIt($url) {
    $headers = array(
                'http'=>array(
                        'method'=>"GET",
                        'header'=>"Connection: close\r\n"
                    )
                );

    $context = stream_context_create($headers);
    $body = file_get_contents($url, false, $context);

    return $body;

}

//==============================================================================
function encodeValues( $docURL )
{
    if (preg_match("/\?/", $docURL)) {
        $splited1[0] = substr($docURL, 0, strpos($docURL,"?"));
        $splited1[1] = substr($docURL, strpos($docURL,"?")+1);
    }else{
        return $docURL;
    }

    // explode( "&", "lang=en&q=saude") => array("lang=en", "q=saude")
    // explode( "&", "lang=en&q=saude & doença") => array("lang=en", "q=saude ", " doença")
    $splited2 = explode( "&", $splited1[1] );

    if ( count($splited2) < 2 ){
        return $docURL;
    }
    $docURL = $splited1[0];
    $op = '?';
    foreach ($splited2 as $value)
    {
        $splited3 = explode('=', $value);

        if ( count($splited3) > 1 ){
            $docURL .= $op.$splited3[0];
            for ($i = 1; $i < count($splited3); $i++){
                $docURL .= '=' . urlencode($splited3[$i]);
            }
        } else {
            // %26 == '&'
            $docURL .= '%26' . urlencode($splited3[0]);
        }
        $op = '&';
    }
    return $docURL;
}


//==============================================================================
function inprocess($source, $status = "loading") {

    global $def, $lang;

    $messages["pt"]["wait"] = "Aguarde, consultando fontes";
    $messages["es"]["wait"] = "Aguarde, consultando fuentes";
    $messages["en"]["wait"] = "Searching ...";
    $messages["fr"]["wait"] = "Recherche en cours...";
    if ($status == "init"){
        echo "<script type=\"text/javascript\">\n";
        echo "    var state = null;\n ";
        echo "    state = window.open('','inprocess','left=420,top=225,width=320,height=150,toolbar=no,resize=false,menubar=no');\n ";
        echo "</script>\n    ";
    }elseif ($status == "end"){

        echo "<script type=\"text/javascript\">\n";
        echo "        state.close() ";
        echo "    </script>";

    }elseif ($status == "loading"){
        echo "<script type=\"text/javascript\">\n";
        echo "        state.document.open('text/html');\n ";
        echo "        s = state.document;\n ";

        echo "        s.writeln('<html>');\n ";
        echo "        s.writeln('  <head>');\n ";
        echo "        s.writeln('    <title>meta-iAH</title>');\n ";
        echo "        s.writeln('    <link rel=\"stylesheet\" href=\"../css/public/skins/classic/style-" . $_POST["lang"] . ".css\"/>');\n ";
        echo "        s.writeln('  </head>');\n ";
        echo "        s.writeln('  <body id=\"popUp\">');\n ";
        echo "        s.writeln('  <table width=\"320\" height=\"120\">');\n ";
        echo "        s.writeln('   <tr valign=\"middle\">');\n ";
        echo "        s.writeln('      <td align=\"center\">');\n ";
        echo "        s.writeln('         " . $messages[$lang]["wait"] . " <br/>');\n ";
        if ( $source != '') {
            echo "  s.writeln('          " . $source . "  <br/>');\n ";
        }
        echo "        s.writeln('          <img src=\"../image/common/loading.gif\"/> ');\n ";
        echo "        s.writeln('       </td>');\n ";
        echo "        s.writeln('   </tr>');\n ";
        echo "        s.writeln('  </table>');\n ";
        echo "        s.writeln('  </body>');\n ";
        echo "        s.writeln('</html>');\n ";
        echo "        s.close();\n ";
        echo "</script>";
        ob_flush();
        flush();
        sleep(1);

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
            $xmlString .= "<" . preg_replace("[\(|\)]","_",$myKey) .">" . htmlspecialchars(trim($HTTP_VARS[$myKey])) ."</" . preg_replace("[\(|\)]","_",$myKey) . ">\n";
         } else {
           for($i = 0; $i < count($HTTP_VARS[$myKey]); $i++) {
               $xmlString .= "<" . preg_replace("[\(|\)]","_",$myKey) .">" . htmlspecialchars(trim($HTTP_VARS[$myKey][$i])) ."</" .preg_replace("[\(|\)]","_",$myKey) . ">\n";
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

    if ( substr($str,0,4) == '[MH]' ){
        $str = str_replace('EX ','EX+', $exp);        //nï¿½o realizar replace por operador booleno quando a expressao usar prefixo de EXPLODE
    }

    preg_match_all('("[^"]*")', $str, $quotedExpressions);

    // Substitui expressï¿½es dentro de aspas por %~~%
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

    // Insere de volta a expressï¿½o dentro de aspas
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
