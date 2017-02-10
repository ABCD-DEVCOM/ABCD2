<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
// se leen los prestamos pendientes para obtener el número del usuario
	$formato_obj=$db_path."trans/pfts/".$_SESSION["lang"]."/loans_display.pft";
    if (!isset($formato_obj)) $formato_obj=$db_path."trans/pfts/".$lang_db."/loans_display.pft";
   	$query = "&Expresion=TR_P_".$arrHttp["inventory"]."&base=trans&cipar=$db_path"."par/trans.par&Pft=v20";
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	$prestamos=array();
	$inicio="S";
	$usuario="";
	foreach ($contenido as $linea){
		if ($inicio=="S"){			$usuario=trim($linea);
			$inicio="N";
			break;		}
	}
	if ($usuario!=""){		header("Location: usuario_prestamos_presentar.php?base=users&usuario=".$usuario);	}else{		header("Location: loan_return_reserve.php?base=users&error=S&inventory=".$arrHttp["inventory"]);	}
?>