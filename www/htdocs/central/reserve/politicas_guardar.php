<?php
session_start();
if (!isset($_SESSION["login"])){	echo "Ud. no está autorizado para entrar a este módulo";
	die;}
include("../config.php");
include("../common/get_post.php");
$us=explode("\n",$arrHttp["ValorCapturado"]);
$fp=fopen($db_path."/reserva/tablas/politicas.tab","w");
foreach ($us as $linea){	$linea=trim($linea);
	if ($linea!="")
		fwrite($fp,$linea."\n");}
fclose($fp);
header ("Location: inicio.php?Opcion=continuar");


?>
