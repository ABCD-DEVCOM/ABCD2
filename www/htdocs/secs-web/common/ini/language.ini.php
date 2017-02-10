<?php
/**
 * @desc        Language controller file
 * @package     [ABCD] SeCS-Web
 * @version     1.0
 * @author      Bruno Neofiti <bruno.neofiti@bireme.org>
 * @since       10 de janeiro 2009
 * @copyright   (c)BIREME - PFI - 2009
 * @public  
*/  

/*
 * First the system try to pick the language from the users session
 * witch is the language set whe the user is created
 * If it fails, the system pick the language set by the link
 * If it fails too, the system pick the language from the browser
 * 
 */
	if (isset($_REQUEST["lang"]))
	{
		$LANGCODE = $_REQUEST["lang"];
		$_SESSION["lang"] = $_REQUEST["lang"];

	}elseif(isset($_SESSION["lang"]))
	{
		$LANGCODE = $_SESSION["lang"];
	}else{
		
		switch (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2))
		{
			case "pt":
				$LANGCODE = "pt";
				break;
			case "en":
				$LANGCODE = "en";
				break;
			case "es":
				$LANGCODE = "es";
				break;
			case "fr":
				$LANGCODE = "fr";			
				break;
			default: $LANGCODE = "en";		
		}
	}

$BVS_LANG["LANGCODE"] 	= $LANGCODE;
require_once (BVS_LANG_DIR . "/{$LANGCODE}/language_{$LANGCODE}.php");
?>