<?php
$locales=array();
$ixmes=-1;
//Horario de la biblioteca, unidades de multa, moneda
$archivo=$db_path."circulation/def/".$_SESSION["lang"]."/locales.tab";
if (!file_exists($archivo)) $archivo=$db_path."circulation/def/".$lang_db."/locales.tab";
if (file_exists($archivo)){
	$locales = parse_ini_file($archivo,true);
}
?>