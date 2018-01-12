<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../config.php");
include ("../common/get_post.php");
//$file ="../backup/".$arrHttp["backup"];
$file=$db_path."copies/DuplicateCopiesReport.txt";
//$file=$db_path."wrk/DuplicateCopiesReport.txt";
//echo "file=$file<BR>";die;
$text = file_get_contents($file);
header("Content-Disposition: attachment; filename=\"".$arrHttp["backup"]."\"");
echo $text;


?>