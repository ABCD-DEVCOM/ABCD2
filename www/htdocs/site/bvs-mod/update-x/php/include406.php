<?php

function INCLUDE_xml_xsl ( $xmlContent, $xslFile )
{
	$fp = fopen($xslFile,"r");
	if ( $fp )
	{
		$xsl = fread($fp,"500000");
		fclose($fp);
	}
	
	$p = xslt_create(void);
	$args = array("/_stylesheet", $xsl, "/_xmlinput", $xmlContent, "/_output", 0, 0);		
	$runFlag = xslt_run ($p, "arg:/_stylesheet", "arg:/_xmlinput", "arg:/_output", 0, $args);
	$result = xslt_fetch_result($p,"arg:/_output");
	xslt_free($p);
	
	return utf8_decode($result);
}

?>
