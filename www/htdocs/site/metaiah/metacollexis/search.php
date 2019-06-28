<?php
$DirNameLocal=dirname(__FILE__).'/';

require ("common.inc.php");
require ("engine.inc.php");
require ("xml2tree.inc.php");

require ("../php/include.php");
require ("../bvs-lib/common/scripts/php/xslt.php");

$xslRoot = "xsl/public/";
$lang = $checked['lang'];
$topic = $_REQUEST['topic'];
$expression = $_REQUEST['expression'];
$connector = $_REQUEST['connector'];
$group = $_REQUEST['group'];

if ($topic || $expression){
	$xsl = $xslRoot . "metacollexis/result.xsl";
}else{
	$xsl = $xslRoot . "metacollexis/form.xsl";
}

$CGI_VARS = ($_GET ? $_GET : $_POST);
$defineXml = readData( $localPath['xml'] .  "/metacollexis.xml");

if ($defineXml == '')
	die("Meta search source definition is empty");

?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<?php include($DirNameLocal."../php/head.php"); ?>
	
<?php

/* extrai nó do topico selecionado ou search na estrutura treeNode */
if ($topic){
	$target_node = extractXMLFragment($defineXml, "topic", $topic);
}else{
	$boolean = $expression;	
	$target_node = extractXMLFragment($defineXml, "search");
}	

/* Adiciona nó do search ou topico selecionado no xml final */
$target_node->printOut($nodeXmlStr);

/* extrai nó sourceList na estrutura treeNode */
$sourceList_node = extractXMLFragment($defineXml, "sourceList");
$sourceList_node->printOut($nodeSource);

/* Monta o XML  */
$xml = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n" . 
		  "\n<metaiah>\n";
$start = time();		  
$xml.= readCGI($CGI_VARS,"cgi");
$xml.= readEnvironment($HTTP_SERVER_VARS,"environment");

/* lista de fontes de pesquisa */
$xml.= $nodeSource;

/* Adiciona nó do search ou topico selecionado no xml final */
$xml.= $nodeXmlStr;

if ($topic || $expression){
	$xml.= GoSearch($target_node, $sourceList_node, $boolean);
}	

$xml.= "<elapsed time=\"" .  (time() - $start) . "sec. \"/>\n";
$xml.= "\n</metaiah>\n";

$xml = str_replace("&amp;","&",$xml);
$xml = str_replace("&","&amp;",$xml);

/* End Monta XML */
if ( $debug == "xml" ){
    header("Content-type: text/xml");
    die( trim($xml) );
}
if ( $debug == "xsl" )
	die($xsl);

if ( $debug == "php" )
	die(phpinfo());


inprocess('','end');
?>
	</head>
	<body>
		<div class="container">
			<div class="level2">
				<?php include( $localPath['html'] . "/bvs.html"); ?>
				<div class="middle">
					<?php

					$VARS["source"] = $_GET["source"];

					require($DirNameLocal . '../php/xmlRoot.php');

					?>
				</div>							
			</div>			
		</div>
		<div class="copyright">
			meta-Collexis &copy; <a href="http://www.bireme.br/" target="_blank">BIREME/OPS/OMS</a> 
		</div>
	</body>
</html>