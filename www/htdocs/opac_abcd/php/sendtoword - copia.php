<?php
$mostrar_menu="N";
include("config_opac.php");
//header('Content-Type: text/html; charset=".$charset."');
//foreach ($_REQUEST as $key=>$value) echo "$key=$value<br>";//DIE;

include("leer_bases.php");

$desde=1;
$count="";



function wxisLlamar($base,$query,$IsisScript){
	global $db_path,$Wxis,$xWxis;
	include("wxis_llamar.php");
	return $contenido;
}




if (isset($_REQUEST["sendto"]) and trim($_REQUEST["sendto"])!="")
	$_REQUEST["cookie"]=$_REQUEST["sendto"] ;
$list=explode("|",$_REQUEST["cookie"]);
$seleccion=array();
$primeravez="S";
foreach ($list as $value){	if (trim($value)!=""){
		$x=explode('_',$value);
		$archivo=$db_path.$x[1]."/loans/".$_REQUEST["lang"]."/loans_conf.tab";
       	//echo $archivo."<br>";
		$fp=file_exists($archivo);
		if ($fp){
			$fp=file($archivo);
			foreach ($fp as $value){
				$ix=strpos($value," ");
				$tag=trim(substr($value,0,$ix));
				switch($tag){
					case "IN": $prefix_in=substr($value,$ix);
						break;
					case "NC": $prefijo=trim(substr($value,$ix));
						break;
				}
			}
		}
		if (isset($seleccion[$x[1]]))
			$seleccion[$x[1]].=" or $prefijo".$x[2]."";
		else
		   	$seleccion[$x[1]]=$prefijo.$x[2];
	}
}



$filename="abcdOpac_word.doc";
header('Content-Type: application/msword; charset=$charset');
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");
$ix=0;
$contador=0;
if (isset($_REQUEST["Formato"]))
	$Formato="@".$_REQUEST["Formato"];
else
	$Formato="@opac_print";

$control_entrada=0;
foreach ($seleccion as $base=>$seleccionados){
	$query = "&base=".$base."&cipar=$db_path"."par/$base".".par&Expresion=$seleccionados&Formato=$Formato.pft&lang=".$_REQUEST["lang"];
	$resultado=wxisLlamar($base,$query,$xWxis."opac/buscar.xis");
	foreach($resultado as $value)  {		$value=trim($value);
		if (substr($value,0,8)=="[TOTAL:]") continue;
		echo "$value";	}
}

?>


