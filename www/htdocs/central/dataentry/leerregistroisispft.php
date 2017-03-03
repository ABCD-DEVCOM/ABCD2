<?php

$llamada="";
$maxmfn=0;
$valortag = Array();

function MostrarPft(){
global $arrHttp,$OS,$Wxis,$wxisUrl,$xWxis;
 	$IsisScript=$xWxis.$arrHttp["IsisScript"];
 	$tags=array_keys($arrHttp);
 	$query = "?xx=&";
 	foreach ($tags as $linea){
  		if ($linea!="IsisScript"){
   			$query.=$linea."=". $arrHttp[$linea]."&";
  		}
 	}
	include("wxis_leer.php");
	foreach ($contenido as $linea){
	   	if (substr($linea,0,10)=='$$LASTMFN:'){
		     return $linea;
		}else{
  			echo "$linea\n";
  		}
 	}
}


function LeerRegistro() {

// en la variable $arrHttp vienen los parámetros que se le van a pasar al script .xis
// el índice IsisScript contiene el nombre del script .xis que va a ser invocado

// la variable $llave permite retornar alguna marca que esté en el formato de salida
// identificada entre $$LLAVE= .....$$

 $llave_pft="";
 global $llamada, $valortag,$maxmfn,$arrHttp,$OS,$Bases,$xWxis,$Wxis,$Mfn,$db_path,$wxisUrl;
 $IsisScript=$xWxis.$arrHttp["IsisScript"];
 $tags=array_keys($arrHttp);
 $query = "";
 foreach ($tags as $linea){
  if ($linea!="IsisScript"){
  	if ($linea=="cipar")
  		$query.= $linea."=$db_path"."par/". $arrHttp[$linea]."&";
  	else
   		$query.=$linea."=". $arrHttp[$linea]."&";
  }
 }
 include("../common/wxis_llamar.php");
 $ic=-1;
    $tag= "";
 foreach ($contenido as $linea){
  if ($arrHttp["Opcion"]=="Identificacion"){
   if ($ic==-1){
    $ic=1;
    $pos=strpos($linea, '##LLAVE=');
    if (is_integer($pos)) {
     $llave_pft=substr($linea,$pos+8);
     $pos=strpos($llave_pft, '##');
     $llave_pft=substr($llave_pft,0,$pos);

				}
			}else{
				$linea=trim($linea);
				$pos=strpos($linea, " ");
				if (is_integer($pos)) {
					$tag=substr($linea,0,$pos);
//
//El formato ALL envía un <br> al final de cada línea y hay que quitarselo
//
					if ($tag==40) echo "$linea";
					if ($tag==100 or tag==40){						$linea=rtrim(substr($linea, $pos+2,strlen($linea)-($pos+2)-5));
						if ($valortag[$tag]!=""){
							$valortag[$tag].=$linea."\n";
						}else {
							$valortag[$tag]=$linea."\n";
						}
					}

				}
			}
		}else{
			if ($ic==-1){
				$ic=1;
			}else{
				$llave_pft=$linea;
			}
		}

	}
//	chdir($diractivo);
	return $llave_pft;
}

function LeerRegistroMfn($base,$cipar,$from,$maxmfn,$Opcion,$userid,$pathwxis,$IsisScript) {

global $valortag,$OS,$xWxis,$arrHttp,$db_path,$Wxis,$wxisUrl;
	if (!isset($arrHttp["Formato"]))  $arrHttp["Formato"]="";
	if (!isset($arrHttp["prologo"]))  $arrHttp["prologo"]="";
	if (!isset($arrHttp["epilogo"]))  $arrHttp["epilogo"]="";
	$IsisScript=$xWxis."ingreso.xis";
   	$query =  "&cipar=$db_path"."par/".$cipar. "&Mfn=" . $arrHttp["Mfn"] . "&to=" . $arrHttp["Mfn"]. "&Formato=" . $arrHttp["Formato"] . "&prologo=".$arrHttp["prologo"]."&epilogo=".$arrHttp["epilogo"]."&Opcion=".$Opcion."&base=" .$base."&userid=".$userid;
	include("../common/wxis_llamar.php");
   	$tag= "";
   	$ic=-1;
	foreach ($contenido as $linea){
		if ($ic==-1){
			$mfn=$linea;
			$ic=2;
		}else{
			$linea=trim($linea);

			if ($linea!=""){

				$pos=strpos($linea, " ");
				if (is_integer($pos)) {
					$tag=substr($linea,0,$pos);

//
//El formato ALL envía un <br> al final de cada línea y hay que quitarselo
//
					$linea=rtrim(substr($linea, $pos+2,strlen($linea)-($pos+2)-5));

					if (isset($valortag[$tag])){
						$valortag[$tag].=$linea."\n";
					}else {
						$valortag[$tag]=$linea."\n";
					}

				}
			}
		}
	}

	$tag="1002";
	if (isset($valortag["1002"])) $maxmfn=$valortag["1002"];

}

?>