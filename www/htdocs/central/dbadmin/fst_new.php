<?php
session_start();
include("../common/get_post.php");

$_SESSION["FST"]=$arrHttp["ValorCapturado"];
header("Location:fst.php?Opcion=new&base=".$arrHttp["base"])
?>