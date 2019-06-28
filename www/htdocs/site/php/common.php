<?php


//==============================================================================
function getDoc ( $docURL, $timeout = 10 ){
    $docContent = "[open failure]";

    $fp = fopen ($docURL, "r");

    if ($fp)
    {
        $docContent = "";
        while (!feof ($fp)) {
            $buffer= fgets($fp, 8096);
            $docContent.= $buffer;
        }
        fclose ($fp);
    }

    return $docContent;
}

//==============================================================================
function getDeCSTree($tree_id = ''){
    $decsWs  = "http://decs.ws.bvsalud.org/";
    $request = "<decsws_request>" .
               "    <service>getTree</service>" .
               "    <parameters>" .
               "        <tree_id>" . $tree_id . "</tree_id>" .
                  "    </parameters>" .
               "</decsws_request>";
    $wsUrl = $decsWs . "main.php?decsws_parameters=" . $request;
    $response = postIt($wsUrl);

    return trim($response);
}


//==============================================================================
function getDeCSTreeVmx($tree_id = ''){
    global $checked;

    $server = "http://decs.bvs.br/";
    $service= "/cgi-bin/mx/cgi=@vmx/decs";
    $request = "?tree_id=" . $tree_id . "&lang=" . $checked["lang"];

    $decsWS = $server . $service . $request;
    $response = postIt($decsWS);

    return trim($response);
}



//==============================================================================
function postIt($url) {
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

//================================================================================================
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

//================================================================================================
function replace_accents($str) {
  $str = htmlentities($str);
  $str = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil);/','$1',$str);
  return html_entity_decode($str);
}

//================================================================================================
function getGoogleTotal($url){

    $googleResult = getDoc($url);

    if ( preg_match('/scholar\./', $url) ){
        $iniPos = strpos($googleResult,"Results <b>");
        $endPos = strpos($googleResult," for <b>");
        $totalInfo = substr($googleResult,$iniPos,200);

        preg_match_all("/<b>([0-9,]+)<\/b>/", $totalInfo, $totalPeaces);
        
        $total = $totalPeaces[1][2];            
    }else{
        $iniPos = strpos($googleResult,"About ");
        $endPos = strpos($googleResult," results (");
        $totalInfo = substr($googleResult,$iniPos,200);

        preg_match_all("/[0-9,]+/", $totalInfo, $totalPeaces);
        
        $total = $totalPeaces[0][0];
    }

    if ($total == "")
        $total = 0;

    return $total;
}

/**
 * Função recursiva para realizar copia de diretórios.
 * Assume-se que o $src seja um diretório válido e que
 * $dst seja um espaço livre para gravação.
 * 
 * @link http://br.php.net/manual/pt_BR/function.copy.php#91010
 * @param String $src diretório a ser copiado
 * @param String $dst diretório destino
 */
function recurse_copy($src,$dst) {
    $dir = opendir($src);

    if(!mkdir($dst)){
        closedir($dir);
        return false;
    }

    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

/**
 * Retorna uma String tratada para usar em XML
 *
 * Retorna uma string que contenha somente letras,
 * número e underscore, para ser usada no atributo
 * id de um nó XML
 *
 * @param String string
 * @return String
 */
function normalize_xml_id($string) {
        $string = ereg_replace("[áàãâäÁÀÃÂÄ]","a",$string);
        $string = ereg_replace("[éèêëÉÈÊË]","e",$string);
        $string = ereg_replace("[íìîïÍÌÎÏ]","i",$string);
        $string = ereg_replace("[óòõôöÓÒÕÔÖ]","o",$string);
        $string = ereg_replace("[úùûüÚÙÛÜ]","u",$string);
        $string = ereg_replace("[çÇ]","c",$string);
        $string = ereg_replace("[^a-zA-Z0-9_]+","_",$string);
        $string = strtolower($string);
        return $string;
}

?>
