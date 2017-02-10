<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../common/get_post.php");
$file ="../backup/".$arrHttp["backup"];
$text = file_get_contents($file);
header("Content-Disposition: attachment; filename=\"".$arrHttp["backup"]."\"");
echo $text;


?>