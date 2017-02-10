<?php
session_start();

if ( isset($_GET['clear']) ){
	unset( $_SESSION["terms"] );
	header("Location: " . $_SERVER["HTTP_REFERER"]);
	die();
}


if(!isset($_GET['productIdToRemove']))die("Not OK");	/* No product id sent as input to this file */

// Add your db queries here
$_SESSION["terms"][$_GET['productIdToRemove']] = NULL;
unset( $_SESSION["terms"][$_GET['productIdToRemove']] );

echo "OK";
?>
