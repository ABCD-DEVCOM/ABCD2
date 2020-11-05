<?php
// Búsqueda libre
$path="../";
include("tope.php");

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
$OS="";
global $REQUEST_METHOD, $HTTP_POST_VARS, $HTTP_GET_VARS;

$arrHttp=Array();
$fdt = Array();
$URL="";
$nob=0;
global $nob;

function DibujarFormaBusqueda(){
global $arrHttp;
// Se carga la tabla con las opciones de búsqueda
	$nob=substr_count($arrHttp["base"],'|');
	if ($nob==0) {
    	$a="../bases/".trim(strtolower($arrHttp["base"]))."/www/busqueda.tab";
		$fp = fopen ($a, "r");
		$fp = file($a);
		foreach ($fp as $linea){
			$camposbusqueda[]= $linea;
			$tag=trim(substr($linea,11,10));
			$matriz_c[$tag]=$linea;
		}
	}else{
		$a= "camposbusqueda.tab";
		$fp = fopen ($a, "r");
		$fp = file($a);
		foreach ($fp as $linea){
			$camposbusqueda[]= $linea;
			$tag=trim(substr($linea,39,4));
			$matriz_c[$tag]=$linea;
		}
	}
	$a="";

// se lee la plantilla con la búsqueda libre y se ubica la etiqueta <CAMPOS>. En ese punto se
// inserta el Select con las opciones de búsqueda leídas de camposbusqueda.tab
	// include("menu.php");
	$fp=file("libre.html");
	foreach($fp as $linea){
		$a.=$linea;
	}
	$ixpos=0;
	$ixpos=strpos($a,"<CAMPOS>");
	if ($ixpos===false){
	}else{
		echo "<script>\n";
		echo "var dt= new Array()\n";
		echo "var nob= $nob\n";
		$ix=0;
		foreach ($camposbusqueda as $linea) {
			$ix++;
			echo "dt[".$ix."]=\"".rtrim($linea)."\"\n";
		}
		echo "</script>\n";
		echo substr($a,0,$ixpos)."\n";
		echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
		echo "<SELECT name=Campos size=1>";
		$asel="";
		echo "<OPTION value=\"---\">---";
		for ($i=0;$i<count($camposbusqueda);$i++){
			if ($nob==0) {
			    echo "<OPTION value=".trim(substr($camposbusqueda[$i],11,20)).$asel.">".trim(substr($camposbusqueda[$i],39));
			}else{
				echo "<OPTION value=".trim(substr($camposbusqueda[$i],39,4)).$asel.">".trim(substr($camposbusqueda[$i],0,39));
			}
		}
		echo "</SELECT>";

		$ixpos1=$ixpos+8;
		$a=substr($a,$ixpos1);
		echo $a."\n";
	}

}

///////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////

foreach ($_REQUEST as $var => $value) {
//	echo "$var = $value<br>";
	if (trim($value!="")) $arrHttp[$var]=$value;
}

include ("leerarchivoini.php");
DibujarFormaBusqueda();
?>