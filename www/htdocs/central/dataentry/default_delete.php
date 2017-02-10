<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../config.php");
include("../lang/admin.php");
echo "<html><title>Test FDT</title>
<script language=javascript src=js/popcalendar.js></script>\n";
unset ($_SESSION["valdef"]);
echo "<br><br><center><h4>".$msgstr["valdef"]." ".$msgstr["eliminados"];



?>