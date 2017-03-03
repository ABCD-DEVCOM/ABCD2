<?php
session_start();
include("../common/get_post.php");
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>"; die;
$_SESSION["FDT"]=$arrHttp["ValorCapturado"];
if (isset($arrHttp["cisis"]))
	$_SESSION["CISIS"]=$arrHttp["cisis"];
else
	unset($_SESSION["CISIS"]);
if (isset($arrHttp["dcimport"]))
	$_SESSION["DCIMPORT"]=$arrHttp["dcimport"];
else
	unset($_SESSION["DCIMPORT"]);
if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";
header("Location:fst.php?Opcion=new&base=".$arrHttp["base"].$encabezado);
?>