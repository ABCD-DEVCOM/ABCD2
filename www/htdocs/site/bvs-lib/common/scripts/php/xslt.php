<?php
    $DirName=dirname(__FILE__).'/';
    $version = split ("\.", phpversion());
	if ( $version[0] > 4 || ($version[0] == 4 && $version[1] >= 1) ) { 
		include_once($DirName . "../../classes/php/xslt-4.1.php");    
	} else {        
		include_once($DirName . "../../classes/php/xslt-4.0.php");    
	}
?>
