<?php

class IniFile
{
	var $ini_content = null;
	
	public function __construct($ini)
	{
		$this->ini_content = parse_ini_file($ini, true);
	}
	function parse()
	{
		if (!is_array($this->ini_content))
		{
			return false;
		}
		return $this->ini_content;
	}
	
	function getXML() 
	{		
		if (!is_array($this->ini_content))
		{
			return false;
		}
		$xml = "<ini>\n";
		$xml .= $this->recursiveXML($this->ini_content);
		$xml .= "</ini>\n";
		return $xml;
	}
	
	function recursiveXML($arr)
	{
		$xml = "";
		while (list($key, $value) = each($arr))
		{
			if (is_array($value))
			{
				$xml .= "<" . $key . ">\n";
				$xml .= $this->recursiveXML($value);
				$xml .= "</" . $key . ">\n";
			}
			else
			{
				$xml .= "<" . $key . ">" . $value . "</" . $key . ">\n";
			}
		}
		return $xml;
	}
}
?>