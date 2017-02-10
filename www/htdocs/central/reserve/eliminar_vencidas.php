<?php
session_start();
if (!isset($_SESSION["login"])){
	echo "<center><br><br><h2>Ud. no tiene permiso para entrar a este módulo</h2>";
	die;
}
// Globales.
set_time_limit (0);
include ("../config.php");

function MostrarPft(){
global $arrHttp,$xWxis,$Wxis,$db_path,$wxisUrl;

	$IsisScript=$xWxis.$arrHttp["IsisScript"];
 	$query = "&base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par&Opcion=".$arrHttp["Opcion"]."&Formato=tbreserva&from=1";
  	include("../common/wxis_llamar.php");
    return $contenido;

}

function VerStatus(){
	global $arrHttp,$xWxis,$OS,$Wxis,$db_path,$wxisUrl;
	$IsisScript=$xWxis."administrar.xis";
	$query = "&base=".$arrHttp["base"] . "&cipar=".$arrHttp["base"].".par&Opcion=status";
 	include("../common/wxis_llamar.php");
	return $contenido;
}

include("../common/get_post.php");
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../common/header.php");
echo "<body>";
echo "Eliminar reservas vencidas ";
echo "<p><a href=inicio.php?Opcion=continuar class=boton>Volver al menú</a><p>";
$contenido=VerStatus();
$ix=-1;
foreach($contenido as $linea) {
	$ix++;
	if ($ix>0) {
  			$a=split(":",$linea);
  			$tag[$a[0]]=$a[1];
	}
}
$MaxMfn=$tag["MAXMFN"];
echo "<p><table class=listTable>";
echo "<th>Usuario</th><th>No.Clasificación</th><th>Fecha reserva</th><th>Eliminada</th>";
$arrHttp["IsisScript"]="leer_mfnrange.xis";

$contenido=MostrarPft();
foreach ($contenido as $value) {
	$t=explode('|',$value);
	echo '<tr><td>'.$t[4]."</td><td>".$t[5]."</td><td>".substr($t[6],6,2)."-".substr($t[6],4,2)."-".substr($t[6],0,4)."</td><td>";
	if (date("Ymd")>$t[6]){
		$query = "&base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par&login=".$_SESSION["login"]."&Mfn=" . $t[0]."&Opcion=eliminar";
		$IsisScript=$xWxis."eliminarregistro.xis";
		include("../common/wxis_llamar.php");
		echo "<img src=../images/delete.png>";
	}
	echo "</td>";
}
echo "</table>";



?>
