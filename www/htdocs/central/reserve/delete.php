<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../common/get_post.php");
include("../config.php");
include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";



function CancelReserve($Mfn){global $db_path,$Wxis,$xWxis,$arrHttp;	$fecha_dev=date("Ymd");
	$hora_dev=date("H:i:s");
	$ValorCapturado="d1d130d131d132<1 0>1</1>";
	$ValorCapturado.="<130 0>$fecha_dev</130>";
	$ValorCapturado.="<131 0>$hora_dev</131>";
	$ValorCapturado.="<132 0>".$_SESSION["login"]."</132>";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."actualizar_registro.xis";
	$Formato="";
	$query = "&base=reserve&cipar=$db_path"."par/reserve.par&login=".$_SESSION["login"]."&Mfn=".$Mfn."&ValorCapturado=".$ValorCapturado;
	//include("../common/wxis_llamar.php");
	//foreach ($contenido as $value) echo "$value<br>";die;
}

function DeleteReserve($Mfn){
global $db_path,$Wxis,$xWxis,$arrHttp;	$query = "&base=reserve&cipar=$db_path"."par/reserve.par&login=".$_SESSION["login"]."&Mfn=" . $Mfn."&Opcion=eliminar";
	$IsisScript=$xWxis."eliminarregistro.xis";
	include("../common/wxis_llamar.php");}

function AssignReserve($Mfn){global $db_path,$Wxis,$xWxis,$arrHttp;	$fecha=date("Ymd");
	$hora=date("H:i:s");
	$ValorCapturado= "d1,<1 0>1</1>";
	$ValorCapturado.="<60 0>$fecha</60>";
	$ValorCapturado.="<132 0>".$_SESSION["login"]."</132>";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."actualizar_registro.xis";
	$Formato="";
	$query = "&base=reserve&cipar=$db_path"."par/reserve.par&login=".$_SESSION["login"]."&Mfn=".$Mfn."&ValorCapturado=".$ValorCapturado;
	include("../common/wxis_llamar.php");}


//---------------------------------------------------------------------------------
//---------------------------------------------------------------------------------

switch ($arrHttp["Accion"]){	case "delete":
		$res=DeleteReserve($arrHttp["Mfn_reserve"]);
		$msg=$msgstr["reserve_deleted"];
		break;
	case "cancel":
		CancelReserve($arrHttp["Mfn_reserve"]);
		break;
	case "assign":
		AssignReserve($arrHttp["Mfn_reserve"]);
		$msg=$msgstr["copy_assigned"];
		break;}

?>
<form name=enviar method=post action="<?php echo $arrHttp["retorno"]?>">;
<?php foreach ($arrHttp as $var=>$value){	echo "<input type=hidden name=$var value=\"$value\">\n";}
?>
<script>
document.enviar.submit()
</script>