<?php
	$redirect = "./php/index_fr.php";
	if ($_REQUEST['lang'])
		$redirect .= "?lang=" . $_REQUEST['lang']; 
	
	header("Location: " . $redirect);
?>
