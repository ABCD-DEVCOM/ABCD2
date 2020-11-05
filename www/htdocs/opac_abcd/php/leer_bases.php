<?php
require_once("validar_request.php");
if (!is_dir($db_path."opac_conf/".$_REQUEST["lang"])){	echo "<h3>"."opac_conf/".$_REQUEST["lang"]." ".$msgstr["missing_folder"]."</h3>";
	die;}
if (!file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat")){
	echo "<h3>opac_conf/".$_REQUEST["lang"]." bases.dat ".$msgstr["dne"]."</h3>";
	die;
}
$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat");

$bd_list=array();
$seq_bases=array();
$ixb=-1;
foreach ($fp as $value){	$val=trim($value);
	if ($val!=""){
		$v=explode('|',$val);
		$bd_list[$v[0]]["nombre"]=$v[0];
		$bd_list[$v[0]]["titulo"]=$v[1];
		$ixb=$ixb+1;
		$seq_bases[$ixb]=$v[0];
		$desc_bd="";
		$fr_01=file($db_path."opac_conf/".$_REQUEST["lang"]."/".$v[0].".def");
		foreach ($fr_01 as $bd_text){
			if (trim($bd_text)!=""){
				$desc_bd.=$bd_text;
			}
		}
		$bd_list[$v[0]]["descripcion"]=$desc_bd;
	}
}
//SI BASES.DAT TIENE UNA SOLA BASE DE DATOS SE DESACTIVA EL MODO INTEGRADO
if (count($bd_list)==1){
	$_REQUEST["base"]=$bd_list[$v[0]]["nombre"]=$v[0];
	$_REQUEST["modo"] ="1B";
}
?>