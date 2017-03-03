<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {popup} function plugin
 *
 * Type:     function<br>
 * Name:     redirect_page<br>
 * Purpose:  Redirect page to destination after some time
 * @author   Domingos Teruel <domingos.teruel at bireme dot org>
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_redirect_page($params, &$smarty)
{	
		global $BVS_CONF;
		//sleep($params['time']);
		$urlDest = "http://{$_SERVER['HTTP_HOST']}{$BVS_CONF['install_dir']}";
		$hRequest = "";
		if(isset($_GET['m'])) {
			$hRequest .= "?m={$_GET['m']}"; 
		}
		if(isset($_GET['title'])) {
			$hRequest .= "&title={$_GET['title']}"; 
		}
		$urlDest .= $hRequest . "&tty=" . time();
		
		//echo "<script>document.location.href='$urlDest'</script>";	
		//echo $urlDest;
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1;URL=$urlDest\">";
	
} 

/* vim: set expandtab: */

?>
