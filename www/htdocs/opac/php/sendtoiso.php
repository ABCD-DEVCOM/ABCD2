<?php
$mostrar_menu="N";
include("config_opac.php");

//foreach ($_REQUEST as $key=>$value) echo "$key=$value<br>";//die;

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


$filename="abcdOpac.iso";
header('Content-Type: text/text; charset=".$charset."');
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=$filename");
$ix=0;
$contador=0;
$control_entrada=0;
foreach ($list as $value){
	$value=trim($value);
	if ($value!="")	{
		$x=explode('_',$value);
		$seleccion[$x[1]][]=$x[2];
	}
}

foreach ($seleccion as $base=>$value){
	$lista_mfn="";
	foreach ($value as $mfn){
		if ($lista_mfn=="")
			$lista_mfn="'$mfn'";
		else
			$lista_mfn.="/,'$mfn'";
	}
	//$lista_mfn.="/,";
	$query = "&base=".$base."&cipar=$db_path"."par/$base".".par&Seleccionados=$lista_mfn&Opcion=seleccionados&lang=".$_REQUEST["lang"];
	//echo $query;//die;
	$resultado=wxisLlamar($base,$query,$xWxis."opac/export_txt.xis");

	foreach($resultado as $value)  {		$value=trim($value);
		echo str_replace('&','&amp;',$value."\n");	}
	//echo "</record>\n";
}

?>


