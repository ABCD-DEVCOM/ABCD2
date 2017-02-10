<?php

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);


// Manejar el diccionario de términos de la base de datos
session_start();
if (!isset($_SESSION['permiso'])) die;
include("../common/get_post.php");
include("../config.php");

include("../lang/admin.php");



// Para presentar el diccionario de términos

function PresentarDiccionario(){
global $arrHttp,$terBd,$xWxis,$wxisUrl,$db_path,$Wxis;


	if ($arrHttp["Opcion"]=="ir_a"){
		$arrHttp["LastKey"]=$arrHttp["prefijo"].$arrHttp["IrA"];
	}
	$arrHttp["Opcion"]="diccionario";
	$Prefijo=$arrHttp["prefijo"];
	$IsisScript= $xWxis."ifp.xis";
	$arrHttp["Formato"]="";
	$query = "&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["cipar"]."&Formato=".$arrHttp["Formato"]."&Opcion=".$arrHttp["Opcion"]."&prefijo=".$arrHttp["prefijo"]."&campo=".$arrHttp["campo"]."&Diccio=".$arrHttp["Diccio"]."&prologo=".$arrHttp["prologo"]."&LastKey=".$arrHttp["LastKey"];
	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
		$pre=trim(substr($linea,0,strlen($arrHttp["prefijo"])));
		if ($pre==$arrHttp["prefijo"]){
			$ter=substr($linea,strlen($arrHttp["prefijo"]));
			$tt=explode('|',$ter);
			$ll=explode('|',$linea);
			echo "<option value='".$ll[0]."'>".$tt[0]." (".$tt[1].")"."\n";
			$mayorclave=$linea;
		}
	}

	$arrHttp["LastKey"]=$mayorclave;
	$arrHttp["Opcion"]="epilogo";

}




// ------------------------------------------------------
// INICIO DEL PROGRAMA
// ------------------------------------------------------


//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";


include("ifpro.php");

switch ($arrHttp["Opcion"]){
	case "diccionario":
		$arrHttp["IsisScript"]="ifp.xis";
		PresentarDiccionario();
		break;
	case "mas_terminos":
		$arrHttp["IsisScript"]="ifp.xis";
		PresentarDiccionario();
		break;
	case "ir_a":
		PresentarDiccionario();
		break;
}

include("ifepil.php");

?>