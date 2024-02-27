<?php

include("config.php");
//include("leer_bases.php");
//foreach ($_REQUEST as $key=>$value)    echo "$key=>".urldecode($value)."<br>";
//if   (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado" ) unset ($_REQUEST["base"]);
$mostrar_libre="N";
$titulo_pagina="N";
include("head.php");
$value=file_get_contents($_REQUEST["sitio"]);
echo $value;
include("views/footer.php");


?>
