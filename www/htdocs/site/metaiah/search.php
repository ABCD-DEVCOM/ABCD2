<?php
$DirNameLocal=dirname(__FILE__).'/';


require ("common.inc.php");
require ("engine.inc.php");
require ("xml2tree.inc.php");
require ("../php/include.php");

$xslRoot = "xsl/public/";
$lang = $checked['lang'];
$topic = $_REQUEST['topic'];
$expression = stripslashes($_REQUEST['expression']);
$connector = $_REQUEST['connector'];
$group = $_REQUEST['group'];
$engine = $def['ENGINE'];
$form = $_REQUEST['form'];
$selected_sources = $_POST['selected_sources'];
$searchType = $_REQUEST['search_type'];

if ($topic || $expression){
    $xsl = $xslRoot . "metaiah/result.xsl";
    $mode = "search";
}else{
    $xsl = $xslRoot . "metaiah/form.xsl";
    $mode = "form";
}

/* search DeCS/MeSH field */
if ($searchType == 'decs'){
    $expression = '[MH]'. $expression;
}

$CGI_VARS = ($_GET ? $_GET : $_POST);

$defineXml = file_get_contents( $localPath['xml'] . "/metaiah.xml" );


if ( strncasecmp($defineXml, "<?xml", 5) == 0 ) {
    $pos = strpos($defineXml, "?>");
	
    if ( $pos > 0 ) {
        $defineXml = substr_replace($defineXml,"",0,$pos + 2);
    }
}

if ($defineXml == '')
    die("Meta search source definition is empty");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <?php include($DirNameLocal."../php/head.php"); ?>

<?php



if ( $engine == 'server' && $mode != "form" && $form != 'advanced'){
	
    $metaServerUrl = "http://" . $def['SERVER'] . "/metaiahServer/search?bvs=". $def['SERVERNAME'] . "&lang=" . $lang . "&timeout=" . $def['TIMEOUT'];
    if ($topic != ''){
        $metaServerUrl .= "&topic=" . $topic;
    }else{
        $boolean = insertDefaultConnector($expression, $connector);
        $metaServerUrl .= "&expression=" . $boolean;
    }

    $xml = postIt($metaServerUrl);
}else{

      inprocess('','init');//init progress window
	 
   
    /* extrai nó do topico selecionado ou search na estrutura treeNode */
    if ($topic){
        $target_node = extractXMLFragment($defineXml, "topic", $topic);
    }else{
        $boolean = insertDefaultConnector($expression, $connector);
        $target_node = extractXMLFragment($defineXml, "search");
    }
	
	

    /* Adiciona nó do search ou topico selecionado no xml final */
    $target_node->printOut($nodeXmlStr);

    /* extrai nó sourceList na estrutura treeNode */
    $sourceListNode = extractXMLFragment($defineXml, "sourceList");
    $sourceListNode->printOut($nodeSource);

    /* Monta o XML  */
    $xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n" .
              "\n<metaiah>\n";
    $start = time();
    $xml.= readCGI($CGI_VARS,"cgi");
    $xml.= readEnvironment($_SERVER,"environment");

    /* lista de fontes de pesquisa */
    $xml.= $nodeSource;

    /* Adiciona nó do search ou topico selecionado no xml final */
    $xml.= $nodeXmlStr;

    if ($topic || $expression){
        $xml.= GoSearch($target_node, $sourceListNode, $boolean);
    }

    $xml.= "<elapsed time=\"" .  (time() - $start) . "sec. \"/>\n";
    $xml.= "\n</metaiah>\n";
    /*
        $xml = str_replace("&amp;","&",$xml);
        $xml = str_replace("&","&amp;",$xml);
    */

    /* End Monta XML */

}

inprocess('','end');        // close progress window
?>
    </head>
    <body>
        <div class="container">
            <div class="level2">
                <?php include( $localPath['html'] . "/bvs.html"); ?>
                <div class="middle">
                    <?php

                    $VARS["source"] = $_GET["source"];

                    if ($debug == "xml")
                        print ("<textarea cols=\"180\" rows=\"30\">");

                    require($DirNameLocal . '../php/xmlRoot.php');

                    if ($debug == "xml")
                        print ("</textarea>");

                    ?>
                </div>
            </div>
        </div>
        <div class="copyright">
            Metaiah &copy; <a href="http://www.bireme.br/" target="_blank">BIREME/OPS/OMS</a>
        </div>
    </body>
</html>