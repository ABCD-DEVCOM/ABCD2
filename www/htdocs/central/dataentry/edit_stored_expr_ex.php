<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
include("../common/get_post.php");
include ('../config.php');
include("../lang/admin.php");
include("../lang/dbadmin.php");
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!(isset($_SESSION["permiso"]["db_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or  isset($_SESSION["permiso"][$arrHttp["base"]."_CENTRAL_ALL"])  or  isset($_SESSION["permiso"][$arrHttp["base"]."_EDITSTOREDEXPR"]))){	echo "<h1>".$msgstr["invalidright"]."</h1>";
	die;
}
$fp=fopen($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/search_expr.tab","w");
foreach ($arrHttp as $key=>$value){	if (substr($key,0,5)=="name_"){		$ix=substr($key,5,1);
		$valor=$arrHttp["expr_$ix"];
		$res=fwrite($fp,$value.'|'.$valor."\n\n");
	}}
fclose($fp);
header("Location: edit_stored_expr.php?base=".$arrHttp["base"])
?>

