<?php

if ( phpversion() < "4.1.1" )
{
	require("include406.php");
}
else
{
	require("include411.php");
}

function INCLUDE_removeXMLpi ( $xml )
{
	/* remove xml processing instruction */
	if ( strncasecmp($xml, "<?xml", 5) == 0 )
	{
		$pos = strpos($xml, "?>");
		if ( $pos > 0 )
		{
			$xml = substr_replace($xml,"",0,$pos + 2);
		}
	}
	
	return $xml;
}

function INCLUDE_getFile ( $fileName )
{
	$fp = fopen($fileName,"r");
	if ( $fp )
	{
		$content = fread($fp,"500000");
		fclose($fp);
	}
	
	return INCLUDE_removeXMLpi($content);
}

function INCLUDE_putFile ( $fileName, $content )
{
	$ret = false;
	
	$fp = fopen($fileName,"w"); 
	if ( $fp )
	{
		$ret = fwrite($fp,$content);
		fclose($fp);
	}
	
	return $ret;
}

function INCLUDE_optionalVar ( $testVar, $defaultValue )
{
	if ( $testVar == "" )
	{
		unset($testVar);
	}
	if ( isset($testVar) )
	{
		return $testVar;
	}
	else
	{
		return $defaultValue;
	}
}

function INCLUDE_listElements ( $list )
{
	reset($list);
	while ( list($key, $value) = each($list) )
	{
		$xml .= "<" . $key . ">" . $value . "</" . $key . ">\n";
	}
	return $xml;
}

function INCLUDE_wxisParameterList ( $list )
{
	$param = "<parameters>\n";
	if ( !$list["xml_header"] )
	{
		$list["xml_header"] = "no";
	}
	$param .= INCLUDE_listElements($list);
	$param .= "</parameters>\n";

	return $param;
}

?>
