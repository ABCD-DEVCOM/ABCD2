<?php
session_start();
include("get_post.php");
$_SESSION["super_user"]=$_SESSION["permiso"];

// to see if a separate window is activate
if (isset($_SESSION["newindow"]))
	$lit="&newindow=s";
else
	$lit="";
header ("Location: ../common/inicio.php?reinicio=s$lit&modulo=".$arrHttp["modulo"]);
?>
