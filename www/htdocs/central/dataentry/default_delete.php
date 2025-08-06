<?php
/* modifications
20250806 fho4abcd Improved html code
*/
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../config.php");
include("../lang/admin.php");
include("../common/header.php");
// This script runs always inside a frame: no institutional info
unset ($_SESSION["valdef"]);
echo "<br><br><center><h4>".$msgstr["valdef"]." ".$msgstr["eliminados"];



?>