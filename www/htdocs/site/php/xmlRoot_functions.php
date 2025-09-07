<?php

function check_parameters()
{
    global $checked, $xml, $xsl, $xslSave, $xmlSave, $page, $lang;

    if (isset($_GET['xml']) && !preg_match("/^[a-z][a-z\/]+.xml$/", $_GET['xml'])) {
        die("invalid parameter 1");
    } else {
        $checked['xml'] = $xml;
    }

    if (isset($xsl) && !preg_match("/^[a-z][a-zA-Z\/\_\-]+.xsl$/", $xsl)) {
        die("invalid parameter 2");
    } else {
        $checked['xsl'] = $xsl;
    }

    if (isset($xmlSave) && !preg_match("/.xml$/", $xmlSave)) {
        die("invalid parameter 3: $xmlSave");
    } else {
        $checked['xmlSave'] = $xmlSave;
    }

    if (isset($xslSave) && !preg_match("/.xsl$/", $xslSave)) {
        die("invalid parameter 4");
    } else {
        $checked['xslSave'] = $xslSave;
    }

    if (isset($page) && !preg_match("/^[a-zA-Z\_\-]+$/", $page)) {
        die("invalid parameter 5");
    } else {
        $checked['page'] = $page;
    }

    if (isset($lang) && !preg_match('/^[a-z][a-z](-[a-z][a-z])?$/', $lang)) {
        die("invalid lang parameter 6");
    } else {
        $checked['lang'] = $lang;
    }
}

function cgiValue($key, $value)
{
    return $key . "=" . $value . "<br/>";
}

function debugCGI($httpVars)
{
    $returnVars = "";
    foreach ($httpVars as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $item) {
                $returnVars .= cgiValue($key, $item);
            }
        } else {
            $returnVars .= cgiValue($key, $value);
        }
    }
    print($returnVars);
}

function debug($debug)
{
    global $xmlContent;

    $debug = strtoupper($debug);
    if ($debug == "VERSION") {
        echo "1.6";
    }
    if ($debug == "CGI") {
        debugCGI($_GET);
        debugCGI($_POST);
    }
    if ($debug == "XML") {
        echo $xmlContent;
    }

    die();
}

function xmlKeyValue($key, $value)
{

    // --- ETAPA 1: Sanitizar a CHAVE ($key) para ser um nome de tag XML válido ---

    // Remove qualquer caracter que NÃO seja letra, número, hífen ou underscore.
    $safe_key = preg_replace('/[^a-zA-Z0-9_-]/', '_', $key);

    // Garante que a tag não comece com um número ou hífen, o que é inválido em XML.
    // Se começar, adicionamos um underscore na frente.
    if (isset($safe_key[0]) && (is_numeric($safe_key[0]) || $safe_key[0] === '-')) {
        $safe_key = '_' . $safe_key;
    }

    // --- ETAPA 2: Sanitizar o VALOR ($value) como antes ---
    $safe_value = htmlspecialchars((string)$value, ENT_QUOTES, 'ISO-8859-1');


    // --- ETAPA 3: Construir a tag com a chave e o valor seguros ---
    return "         <" . $safe_key . ">" . $safe_value . "</" . $safe_key . ">\n";
}

function xmlHttpVars($mainElement, $httpVars)
{
    $xmlVars = "";
    // CORREÇÃO: Usar empty() para verificar com segurança se a variável é nula ou um array vazio
    if (empty($httpVars)) {
        return $xmlVars;
    }

    $xmlVars = "      <" . $mainElement . ">\n";

    // CORREÇÃO: Substituir o while...each() por foreach()
    foreach ($httpVars as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $item) {
                $xmlVars .= xmlKeyValue($key, $item);
            }
        } else {
            $xmlVars .= xmlKeyValue($key, $value);
        }
    }

    $xmlVars .= "      </" . $mainElement . ">\n";

    return $xmlVars;
}

function xmlHttpInfo($mainElement)
{
    global $VARS;

    $xmlCgi = "   <" . $mainElement . ">\n";
    $xmlCgi .= xmlHttpVars("server", $_SERVER);
    $xmlCgi .= xmlHttpVars("cgi", $_GET);
    $xmlCgi .= xmlHttpVars("cgi", $_POST);
    if (isset($_SESSION)) {
        $xmlCgi .= xmlHttpVars("session", $_SESSION);
    }
    $xmlCgi .= xmlHttpVars("VARS", $VARS);
    $xmlCgi .= "   </" . $mainElement . ">\n";

    return $xmlCgi;
}

function xmlDefineInfo($mainElement)
{
    global $def;

    $xml = "   <" . $mainElement . ">\n";
    if (is_array($def)) {
        foreach ($def as $param => $value) {
            $param = str_replace(' ', '_', $param);
            $xml .= "   <" . $param . ">" . $value . "</" . $param . ">\n";
        }
    }
    $xml .= "   </" . $mainElement . ">\n";

    return $xml;
}


function normalizeDocURL($docURL)
{
    global $def;

    $parsedURL = parse_url($docURL);

    if (empty($parsedURL['scheme'])) {
        if (substr($parsedURL['path'], 0, 1) != "/") {
            $docURL = DATABASE_PATH . "/" . $docURL;
        }
    }

    $docURL = str_replace("|", "&", $docURL);
    return $docURL;
}

function getXmlDoc($docURL, $removeHeader)
{
    global $def, $xmlBuffer;
    $docContent = "";

    //$docURL = normalizeDocURL($docURL);
    $docURL = DATABASE_PATH . ($docURL);

    if (file_exists($docURL)) {
        $fp = fopen($docURL, "r");
        $docContent = "";
        if ($fp) {
            while (!feof($fp)) {
                $buffer = fgets($fp, 8096);
                $docContent .= $buffer;
            }
            fclose($fp);
        }
    }


    if ($removeHeader) {
        $docContent = xmlRemoveHeader($docContent);
    }

    return $docContent;
}


function xmlRemoveHeader($xml)
{
    /* remove xml processing instruction */
    $xml = trim($xml);
    if (strncasecmp($xml, "<?xml", 5) == 0) {
        $pos = strpos($xml, "?>");
        if ($pos > 0) {
            $xml = substr_replace($xml, "", 0, $pos + 2);
        }
    }
    return $xml;
}


function BVSDocXml($rootElement, $xml)
{
    $content = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n";
    $content .= "<" . $rootElement . ">\n";
    $content .= xmlHttpInfo("http-info");
    $content .= xmlDefineInfo("define");
    if (isset($xml)) {
        //verifica se a variavel é um xml ou arquivo
        if (strncasecmp($xml, "<?xml", 5) == 0) {
            $content .= xmlRemoveHeader($xml);
        } else {
            $content .= getXmlDoc($xml, true);
        }
    }
    $content .= "</" . $rootElement . ">\n";

    return $content;
}

function processTransformation($xml, $xsl, $params = 0) {

    global $def;
    $domXml = new DOMDocument("1.0", "utf-8");
    if (empty(trim($xml)) || !$domXml->loadXML($xml)) {
        return false;
    }

    $domXsl = new DOMDocument("1.0", "utf-8");

    // AQUI ESTÁ A CORREÇÃO: Adicionamos a constante LIBXML_NOENT ao carregar o XSL.
    // Isso permite que o processador carregue arquivos externos referenciados no XSL.
    if (!file_exists($xsl) || !$domXsl->load($xsl, LIBXML_NOENT)) {
        return "Error: XSL file not found or failed to load at " . htmlspecialchars($xsl);
    }

    $proc = new XSLTProcessor();
    $proc->importStylesheet($domXsl);
    if (isset($def['DATABASE_PATH'])) {
        $proc->setParameter('', 'xml-path', $def['DATABASE_PATH'] . "xml/");
    }

    if ($params) {
        foreach ($params as $key => $value) {
            $proc->setParameter('', $key, $value);
        }
    }

    // A transformação agora é chamada diretamente, sem as funções obsoletas.
    $result = $proc->transformToXML($domXml);

    return $result;
}

function putDoc($docURL, $docContent)
{
    $ret = false;

    $tracking = ini_set('track_errors', true);

    $fp = @fopen($docURL, "w");

    $tracking = ini_set('track_errors', $tracking);

    if (isset($php_errormsg) && $php_errormsg != "") {
        throw new Exception($php_errormsg);
    }

    if ($fp) {
        $ret = fwrite($fp, $docContent, strlen($docContent));
        fclose($fp);
    }

    return $ret;
}

function xmlWrite($xmlContent, $xsl, $xml, $xsl_params = null)
{
    global $debug;
    $sucessWriteXml = "";

    $text = processTransformation($xmlContent, $xsl, $xsl_params);
    $find = array("UTF-8", "&amp;lt;", "&amp;gt;", "&amp;#160;", "&amp;nbsp;", "&amp;#9001;");
    $replace = array("ISO-8859-1", "&lt;", "&gt;", "&#160;", "&#160;", "&amp;lang");

    $text = str_replace($find, $replace, $text);
    //$text = str_replace("UTF-8","ISO-8859-1",$text);

    if (trim($text) == "") {
        print("warning:transformation error generated empty content");
    } else {
        if (isset($debug) && $debug == "XMLSAVE") {
            die($text);
        }

        $xmlDoc = DATABASE_PATH . $xml;
        if (preg_match('/users\.xml$/', $xml))
            $xmlDoc = DEFAULT_DATA_PATH . $xml;

        if (!putDoc($xmlDoc, $text)) {
            print("putDoc error: " . $xmlDoc . "<br/>\n");
        } else {
            $sucessWriteXml = $text;
        }
    }
    return $sucessWriteXml;
}

function htmlWrite($xml, $xsl_params = null)
{
    global $debug, $xmlSave;
    $sucess = false;

    $xsl = SITE_PATH . "xsl/adm/xml-html.xsl";
    $html = str_replace("xml", "html", $xmlSave);

    //print "xsl=" . $xsl . " html=" . $html . "<br>";

    $text = processTransformation($xml, $xsl, $xsl_params);
    $text = xmlRemoveHeader($text);
    $text = macroReplace($text);

    if (trim($text) == "") {
        print("warning:transformation error generated empty content");
    } else {

        $htmlFile = DATABASE_PATH . $html;

        if (!putDoc($htmlFile, $text)) {
            print("putDoc error: " . $htmlFile . "<br/>\n");
        } else {
            $sucess = true;
        }
    }
    return $sucess;
}

function iniWrite($xml, $xsl_params = null)
{
    global $debug, $xmlSave;
    $sucess = false;

    $xsl = "../xsl/adm/xml-ini.xsl";
    $ini = str_replace(array("xml/", ".xml"), array("ini/", ".ini"), $xmlSave);

    //print "\n xsl=" . $xsl . " ini=" . $ini . "<br>";

    $text = processTransformation($xml, $xsl, $xsl_params);
    $text = xmlRemoveHeader($text);
    $text = trim($text);

    if ($text == "subpages not present in this component") {
        return $sucess;
    } else {
        if ($text == "") {
            print("warning:transformation error generated empty content");
        } else {
            //$iniFile = normalizeDocURL($ini);
            $iniFile = DATABASE_PATH . $ini;
            if (!putDoc($iniFile, $text)) {
                print("putDoc error: " . $iniFile . "<br/>\n");
            } else {
                $sucess = true;
            }
        }
    }
    return $sucess;
}

function defineMetaIAHWrite($xsl_params = null)
{
    global $lang;
    $sucess = false;

    $xml = DATABASE_PATH . "xml/" . $lang . "/bvs.xml";
    if (file_exists($xml)) {
        $xml = file_get_contents($xml);
    } else {
        $xml = "";
    }


    $xsl = SITE_PATH . "xsl/metaiah/define-metaiah.xsl";
    $define = DATABASE_PATH . "xml/" . $lang . "/metaiah.xml";

    //print "\n xsl=" . $xsl . " ini=" . $ini . "<br>";


    $text = processTransformation($xml, $xsl, $xsl_params);

    // CORREÇÃO: Adicionar delimitadores ao preg_match
    if (preg_match('/%HOST%/', $text)) {
        $thisHOST = $_SERVER['HTTP_HOST'];
        $text = str_replace("%HOST%", $thisHOST, $text);
    }

    if ($text == "") {
        print("warning ocurred in " . __FUNCTION__ . ": transformation error generated empty content");
    } else {
        if (!putDoc($define, $text)) {
            print("putDoc error: " . $define . "<br/>\n");
        } else {
            $sucess = true;
        }
    }
    return $sucess;
}


function xmlCDATA($str)
{

    $cdataElement[] = "portal";
    $cdataElement[] = "description";

    foreach ($cdataElement as $element) {
        $find[] = "<" . $element . ">";
        $find[] = "</" . $element . ">";
        $replace[] = "<" . $element . "><![CDATA[";
        $replace[] = "]]></" . $element . ">";
    }

    $str = str_replace($find, $replace, $str);
    return $str;
}


function macroReplace($str)
{
    global $lang, $def;

    $find = array("(%SKIN_IMAGE_DIR%)", "/&lt;\?/", "/\?&gt;/");
    $replace = array("../image/public/skins/" . $def['SKIN_NAME'] . "/" . $lang . "/", "<?", "?>");

    $changedStr = preg_replace($find, $replace, $str);

    return $changedStr;
}
