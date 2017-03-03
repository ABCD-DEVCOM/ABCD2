<?php

define("NL", "\n<br>");

require_once("wxis.php");

class DB_ISIS
{
	function DB_ISIS() {}
	
	function getParameterList($list)
	{
		$param = "<parameters>\n";
		$param .= "   <xml_header>no</xml_header>\n";
		reset($list);
		while (list($key, $value) = each($list))
		{
			if ($value != "")
			{
				$param .= "   <" . $key . ">" . $value . "</" . $key . ">\n";
			}
		}
		$param .= "</parameters>\n";
		return $param;
	}
	
	function doList($param)
	{
		return wxis_list($this->getParameterList($param));
	}
	
	function search($param)
	{
		return wxis_search($this->getParameterList($param));
	}
	
	function index($param)
	{
		return wxis_index($this->getParameterList($param));
	}
	
	function edit($param)
	{
		return wxis_edit($this->getParameterList($param));
	}
	
	function write($param , $content)
	{
		return wxis_write($this->getParameterList($param), $content);
	}
	
	function delete($param)
	{
		return wxis_delete($this->getParameterList($param));
	}
	function mult_delete($param)
	{
		return wxis_mult_delete($this->getParameterList($param));
	}

	function control($param)
	{
		return wxis_control($this->getParameterList($param));
	}
	function  keyrange_mfnrange ( $param ) 
	{		
		return wxis_keyrange_mfnrange ( $param );
	}
	function keyrange ( $param ) 
	{
		return wxis_keyrange ( $param );	
	}
}

?>
