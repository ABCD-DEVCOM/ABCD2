<?php

function INCLUDE_xml_xsl ( $xmlContent, $xslFile )
{
	$p = xslt_create(void);
	$args = array ( '/_xml' => $xmlContent );
	$result = xslt_process($p, 'arg:/_xml', $xslFile, NULL, $args);
	xslt_free($p);
	
	return utf8_decode($result);
}

?>
