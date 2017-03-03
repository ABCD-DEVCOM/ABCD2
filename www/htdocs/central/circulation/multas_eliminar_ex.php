<?php
session_start();
// ELIMINAR MULTAS
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["permiso"]["CENTRAL_ALL"]) and !isset($_SESSION["permiso"]["CIRC_CIRCALL"])  and (!isset($_SESSION["permiso"]["CIRC_DELSUS"])or !isset($_SESSION["permiso"]["CIRC_DELFINE"]))){	header("Location: ../common/error_page.php") ;
}

if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";die;
include("../config.php");

$lang=$_SESSION["lang"];

include("../lang/prestamo.php");

include("grabar_log.php");

function ProcesarRegistro($Accion,$Mfn,$trans){global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp;
	switch ($Accion){		case "P":   //PAGAR MULTA
			$Accion="2";
			$trans="L";    //Para el log de transacciones
			break;
		case "C":  //CANCELAR
			$Accion="1";
			switch ($trans){				case "M":
					$trans="K";   //Cancelación de multa
					break;
				case "S":
					$trans="O";   //Cancelación de suspensión
					break;
				case "N":
					$trans="O";   //Cancelación de la nota
					break;			}
			break;	}
	$ValorCapturado="d10<010 0>".$Accion."</10>";
	$ValorCapturado.="<110>".$_SESSION["login"]."^d".date("Ymd h:i A")."</110>";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."actualizar_registro.xis";
	$query = "&base=suspml&cipar=$db_path"."par/suspml.par&login=".$_SESSION["login"]."&Mfn=".$Mfn."&Opcion=actualizar&ValorCapturado=".$ValorCapturado;

	//SE GRABA EL LOG CON LA CANCELACIÓN DE LA MULTA O LA SUSPENSIÓN
	if (file_exists($db_path."logtrans/data/logtrans.mst")){
		$datos_trans["CODIGO_USUARIO"]=$arrHttp["usuario"];
		$ValorCapturado=GrabarLog($trans,$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path,"RETORNAR");
		if ($ValorCapturado!="") $query.="&logtrans=".$ValorCapturado;
	}
    include("../common/wxis_llamar.php");
}

function EliminarRegistro($Mfn,$trans){global $db_path,$Wxis,$xWxis,$wxisUrl;	$query = "&base=suspml&cipar=$db_path"."par/suspml.par&login=".$_SESSION["login"]."&Mfn=" . $Mfn."&Opcion=eliminar";
	$IsisScript=$xWxis."eliminarregistro.xis";
	//SE GRABA EL LOG CON LA CANCELACIÓN DE LA MULTA O LA SUSPENSIÓN
	if (file_exists($db_path."logtrans/data/logtrans.mst")){
		switch($trans){			case "M":
				$trans="R";
				break;
			case "S":
				$trans="O";
				break;
			case "N":
				$trans="N";
				break;		}
		$datos_trans["CODIGO_USUARIO"]=$arrHttp["usuario"];
		$ValorCapturado=GrabarLog($trans,$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path,"RETORNAR");
		if ($ValorCapturado!="") $query.="&logtrans=".$ValorCapturado;
	}
	include("../common/wxis_llamar.php");
}
//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";die;
$Mfn=explode('|',$arrHttp["Mfn"]);
foreach ($Mfn as $value) {	if (trim($value)!=""){
		switch ($arrHttp["Accion"]){			case "D":  //DELETE
				EliminarRegistro($value,$arrHttp["Tipo"]);
				break;
			case "C":  //CANCEL
				ProcesarRegistro("C",$value,$arrHttp["Tipo"]);
				break;
			case "P":   //PAY
				ProcesarRegistro("P",$value,$arrHttp["Tipo"]);
				break;		}


    }
}
if (isset($arrHttp["reserve"])){	$reserve="&reserve=s";}else{	$reserve="";}
header("Location: usuario_prestamos_presentar.php?base=users&usuario=".$arrHttp["usuario"].$reserve);
?>
