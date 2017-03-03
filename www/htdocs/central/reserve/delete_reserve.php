<?php
include ("../common/get_post.php");
if (!isset($arrHttp["desde"]) or isset($arrHttp["desde"]) and $arrHttp["desde"]=="reserva"){
	session_start();
	if (!isset($_SESSION["permiso"])){
		header("Location: ../common/error_page.php") ;
	}
}else{	$_SESSION["login"]="WEB";
	$_SESSION["lang"]=$arrHttp["lang"];}

include("../config.php");
include("../lang/prestamo.php");
//Calendario de días feriados
include("../circulation/calendario_read.php");
//Horario de la biblioteca, unidades de multa, moneda
include("../circulation/locales_read.php");
include ("../circulation/fecha_de_devolucion.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";die;



function CancelReserve($Mfn){global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp;	$fecha_dev=date("Ymd");
	$hora_dev=date("H:i:s");
	$ValorCapturado="d1d130d131d132<1 0>1</1>";
	$ValorCapturado.="<130 0>$fecha_dev</130>";
	$ValorCapturado.="<131 0>$hora_dev</131>";
	$ValorCapturado.="<132 0>".$_SESSION["login"]."</132>";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."actualizar_registro.xis";
	$Formato="";
	$query = "&base=reserve&cipar=$db_path"."par/reserve.par&login=".$_SESSION["login"]."&Mfn=".$Mfn."&ValorCapturado=".$ValorCapturado;
	include("../common/wxis_llamar.php");
	//echo $query."<br>";
	//foreach ($contenido as $value) echo "$value<br>";die;
}

function DeleteReserve($Mfn){
global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp;	$query = "&base=reserve&cipar=$db_path"."par/reserve.par&login=".$_SESSION["login"]."&Mfn=" . $Mfn."&Opcion=eliminar";
	$IsisScript=$xWxis."eliminarregistro.xis";
	include("../common/wxis_llamar.php");}

/* Verificar si esta función se puede eliminar. pienso que si
function AssignReserve($Mfn){global $db_path,$Wxis,$xWxis,$wxisUrl,$arrHttp;	$fecha=date("Ymd");
	$hora=date("H:i:s");
	$f_asignacion=$fecha;
	$lapso=2;
	$unidad="D";
	$fecha_anulacion=FechaDevolucion($lapso,$unidad,$f_asignacion);
	$fecha_anulacion=substr($fecha_anulacion,0,8);
	$ValorCapturado="d1d40d60d61d62<1 0>3</1>";
	$ValorCapturado.="<60 0>$f_asignacion</60><61 0>$hora</61><62 0>".$_SESSION["login"]"</62><40 0>$fecha_anulacion</40>";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."actualizar_registro.xis";
	$query = "&base=reserve&cipar=$db_path"."par/reserve.par&login=".$_SESSION["login"]."&Mfn=".$Mfn."&ValorCapturado=".$ValorCapturado;
	//echo $query;
	include("../common/wxis_llamar.php");
	//foreach ($contenido as $value) echo "$value<br>";  die;}
*/

//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------

switch ($arrHttp["Accion"]){	case "delete":
		$res=DeleteReserve($arrHttp["Mfn_reserve"]);
		$msg=$msgstr["reserve_deleted"];
		break;
	case "cancel":
		CancelReserve($arrHttp["Mfn_reserve"]);
		if (isset($arrHttp["base_reserve"]) and (!isset($arrHttp["desde"]) or (isset($arrHttp["desde"]) and $arrHttp["desde"]=="reserva")))
			$arrHttp["retorno"]="../output_circulation/rs01.php";

		break;
	case "assign":
		AssignReserve($arrHttp["Mfn_reserve"]);
		$msg=$msgstr["copy_assigned"];
		$arrHttp["code"]="assigned";
		break;}

?>
<form name=enviar method=post action="<?php echo $arrHttp["retorno"]?>">
<?php foreach ($arrHttp as $var=>$value){	echo "<input type=hidden name=$var value=\"$value\">\n";
	if (isset($arrHttp["base_reserve"]) and isset($arrHttp["ncontrol"]) and $arrHttp["code"]=="assigned"){		echo "<input type=hidden name=base_reserve value=".$arrHttp["base_reserve"].">\n";
		echo "<input type=hidden name=control value=".$arrHttp["ncontrol"].">\n";
		echo "<input type=hidden name=code value=reassign>\n";
	}}
?>
</form>
<script>
document.enviar.submit()
</script>