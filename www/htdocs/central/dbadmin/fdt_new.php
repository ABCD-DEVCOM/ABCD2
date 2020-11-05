<?php
session_start();
include("../common/get_post.php");
$_SESSION["FDT"]=$arrHttp["ValorCapturado"];
if (isset($arrHttp["CISIS_VERSION"]))
	$_SESSION["CISIS_VERSION"]=$arrHttp["CISIS_VERSION"];
if (isset($arrHttp["UNICODE"]))
	$_SESSION["UNICODE"]=$arrHttp["UNICODE"];

if (isset($arrHttp["dcimport"]))
	$_SESSION["DCIMPORT"]=$arrHttp["dcimport"];

if (isset($arrHttp["encabezado"]))
	$encabezado="&encabezado=S";
else
	$encabezado="";
header("Location:fst.php?Opcion=new&base=".$arrHttp["base"].$encabezado);
?>