<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
session_start();

if(!isset($_REQUEST['productId']))exit;    /* No product id sent as input to this file */

$_SESSION["terms"][$_REQUEST["productId"]] = $_REQUEST["productId"] . "|||" . $_REQUEST["productName"] . "|||" . $_REQUEST["productOptions"];

echo $_REQUEST["productId"] . "|||" . urlencode($_REQUEST["productName"]) ."|||" . $_REQUEST["productOptions"];
?>