<?php
/**
 * @desc Class with objective to prepare the access environment system
 * 	     Is necessary before call this class, set a constant INIFILE with path to ini file (ex: $ini = "/home/dic/dev/htdocs/common/ini")
 * @package [SECS-Web] SECS Online
 * @name iniFile
 * @version 0.1
 * @author  Domingos Teruel <webmaster@dteruel.com.br>
 * @since create 08 de junho de 2004
 * @since update 06 de agosto de 2007
 * @copyright  BIREME - SCI - 2004
 * @abstract 
 * @final
 */
class iniFile
{
	/**
	 * @desc path to ini File
	 * @var string
	 * access private;
	 */
	var $ini_path = ""; 
	/**
	 * @desc Content of ini file
	 * @var  blob
	 * @access private
	 */
	var $ini_content = null;
    	
	/**
	 * @desc Constructor
	 * @access protected
	 */
	function iniFile()
	{
		die("ver arquivo iniFile.class");
        //Set content of ini file
		$this->getContent();
	}
	/**
	 * @desc Method that defines path to archive INI
	 * @access private
	 */
	function setPath()
	{
		die("ver arquivo iniFile.class");
        $this->ini_path = INIFILE;
	}
	/**
	 * @desc search content of ini file
	 * @access private
	 */
	function getContent()
	{
		die("ver arquivo iniFile.class");
    //Check path of ini file
		if ($this->ini_path == "") {
		    $this->setPath();
		}
		//Read content of ini file
		$this->ini_content = parse_ini_file($this->ini_path,true);
	}
	/**
	 * @desc Check the content of $ini_content returns content from $ini_content or false
	 * @return $ini_content
	 * @access public
	 */
	function parse()
	{
		die("ver arquivo iniFile.class");
    if (!is_array($this->ini_content)) {
			return false;
		} else {
		    return $this->ini_content;
		}
	}
	
	function getXML() 
	{		
		die("ver arquivo iniFile.class");
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