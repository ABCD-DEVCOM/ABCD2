<?php
///////////////////////////////////////////////////////////////
// Update sanctions in database
//////////////////////////////////////////////////////////////
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
include("../config_loans.php");
$lang=$_SESSION["lang"];
include("../lang/prestamo.php");

//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";
//die;
// se leen los valores locales para convertir la fecha a ISO
include("locales_read.php");
// Se lee el calendario de días hábiles
include("calendario_read.php");

include("fecha_de_devolucion.php");

$FechaP=$arrHttp["date"];
$df=explode('/',$config_date_format);
switch ($df[0]){
	case "DD":
		$dia=substr($FechaP,0,2);
		break;
	case "MM":
		$mes=substr($FechaP,0,2);
		break;
}
switch ($df[1]){
	case "DD":
		$dia=substr($FechaP,3,2);
		break;
	case "MM":
		$mes=substr($FechaP,3,2);
		break;
}
$year=substr($FechaP,6,4);
$fecha_desde= $year.$mes.$dia;

// se calcula la fecha de vencimiento de la sanción sumando los días de suspensión
if ($arrHttp["type"]=="S"){
}
switch ($arrHttp["type"]){
	case "N":
		$tipor="N";
		$cod_trans="W";                                     		//v1
		$status="0";	                                  		//v10
		$cod_usuario=$arrHttp["usuario"];                  		//v20
 		$concepto=$arrHttp["reason"];    						//v40
    	$fecha=$fecha_desde;	              					//v30
      	$ValorCapturado="<1 0>".$tipor."</1><10 0>".$status."</10><20 0>".$cod_usuario."</20><30 0>".$fecha."</30><40 0>".$concepto."</40>";
      	if (isset($arrHttp["comments"])) $ValorCapturado.="<100 0>".$arrHttp["comments"]."</100>";
		break;
	case "M":
		$tipor="M";
		$cod_trans="J";                                     		//v1
		$status="0";	                                  		//v10
		$cod_usuario=$arrHttp["usuario"];                  		//v20
 		$concepto=$arrHttp["reason"];    						//v40
    	$fecha=$fecha_desde;	              					//v30
      	$monto=$arrHttp["units"]*$locales["fine"];              //v50
      	$unidades_multa=$arrHttp["units"];
      	$ValorCapturado="<1 0>".$tipor."</1><10 0>".$status."</10><20 0>".$cod_usuario."</20><30 0>".$fecha."</30><40 0>".$concepto."</40><50 0>".$monto."</50>";
      	if (isset($arrHttp["comments"])) $ValorCapturado.="<100 0>".$arrHttp["comments"]."</100>";
      	break;
	case "S":
	// se calcula la fecha en que vence la suspensión
		$fecha_v=FechaDevolucion($arrHttp["units"],"D",$arrHttp["date"]);
        $cod_trans="N";
		$tipor="S";                      						//v1
		$status="0";	                 						//v10
		$cod_usuario=$arrHttp["usuario"]; 						//v20
 		$concepto=$arrHttp["reason"];    						//v40
    	$fecha=$fecha_desde;	          						//v30
    	$fecha_v=substr($fecha_v,0,8);
    	$unidades_suspension=$arrHttp["units"];  				//v60
    	$ValorCapturado="<1 0>".$tipor."</1><10 0>".$status."</10><20 0>".$cod_usuario."</20><30 0>".$fecha."</30><40 0>".$concepto."</40><60 0>".$fecha_v."</60>";
    	if (isset($arrHttp["comments"])) $ValorCapturado.="<100 0>".$arrHttp["comments"]."</100>";
		break;
}
$ValorCapturado.="<120>".$_SESSION["login"]."^d".date("Ymd h:i A")."</120>";
$ValorCapturado=urlencode($ValorCapturado);
$IsisScript=$xWxis."crear_registro.xis";
$query = "&base=suspml&cipar=$db_path"."par/suspml.par&login=".$_SESSION["login"]."&Mfn=New&Opcion=crear&ValorCapturado=".$ValorCapturado;

if (file_exists($db_path."logtrans/data/logtrans.mst")){
	require_once("../circulation/grabar_log.php");
	$datos_trans["CODIGO_USUARIO"]=$cod_usuario;
	if (isset($fecha_v))
		$datos_trans["FECHA_PROGRAMADA"]=$fecha_v;
	if (isset($unidades_multa))
		$datos_trans["U_MULTA"]=$unidades_multa;
	if (isset($monto))
		$datos_trans["MONTO_MULTA"]=$monto;
	if (isset($unidades_suspension))
		$datos_trans["DIAS_SUSPENSION"]=$unidades_suspension;
	$ValorCapturado=GrabarLog($cod_trans,$datos_trans,$Wxis,$xWxis,$wxisUrl,$db_path,"RETORNAR");
    if ($ValorCapturado!="") $query.="&logtrans=".$ValorCapturado;
}
include("../common/wxis_llamar.php");
header("Location: usuario_prestamos_presentar.php?base=users&usuario=".$arrHttp["usuario"]);
?>
