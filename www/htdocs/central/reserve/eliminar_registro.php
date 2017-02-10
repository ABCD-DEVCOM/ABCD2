<?php
session_start();
if (!isset($_SESSION["login"])){
	echo "<center><br><br><h2>Ud. no tiene permiso para entrar a este módulo</h2>";
	die;
}
require_once("../config.php");

include("../common/get_post.php");
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";
//die;
$query = "&base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par&login=".$_SESSION["login"]."&Mfn=" . $arrHttp["Mfn"]."&Opcion=eliminar";
$IsisScript=$xWxis."eliminarregistro.xis";
include("../common/wxis_llamar.php");
$retorno="browse.php?";
header("Location:$retorno"."&base=".$arrHttp["base"]."&return=".$arrHttp["return"]."&from=".$arrHttp["from"]);

?>