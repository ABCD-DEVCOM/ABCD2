<?php
$locales=array();
$ixmes=-1;
//Horario de la biblioteca, unidades de multa, moneda

$archivo_global=$db_path."circulation/def/".$_SESSION["lang"]."/locales.tab";
$archivo_policy=$db_path."circulation/def/".$_SESSION["lang"]."/typeofitems.tab";

if (!file_exists($archivo_global)) $archivo_global=$db_path."circulation/def/".$lang_db."/locales.tab";
if (file_exists($archivo_global)) $locales = parse_ini_file($archivo_global,true);



if (!file_exists($archivo_policy)) $archivo_policy=$db_path."circulation/def/".$lang_db."/typeofitems.tab";
if (file_exists($archivo_policy)) $fp_policy=file($archivo_policy);

$ix=0;
$total_prestamos_politica=0;
$can_reserve=array();
foreach ($fp_policy as $value) {
	if (trim($value)!=""){
		//echo $value.'<br>';
		$Ti=explode('|',$value);
		$objeto=strtoupper($Ti[0]);
		$usr=strtoupper($Ti[1]);
		$politica[$objeto][$usr]=trim($value);
		if ($Ti[11]=="Y"){
			$can_reserve[$objeto]=$Ti[11];
		} else {
			$can_reserve[$objeto]="N";
		}
  	}
}

?>