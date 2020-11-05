<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../config.php");
if (isset($_REQUEST["archivo_c"])) {	$source=$_REQUEST["archivo_c"];}else{	$file=$_REQUEST["archivo"];
	$source=$db_path."wrk/$file";}


header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($source).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($source));
    readfile($source);


?>
