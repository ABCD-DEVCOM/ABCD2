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
 	$query = "&base=".$arrHttp["base"]."&cipar=".$arrHttp["base"].".par&Opcion=".$arrHttp["Opcion"];
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
switch ($arrHttp["Opcion"]){	case "fullinv":
		echo "Generar lista invertida";
		break;
	case "unlockbd":
		echo "Desbloquear base de datos";
		break;
	case "unlock":
		echo "Desbloquear registros";
		break;
	case "inicializar":
		break;
	case "listar":
		echo "Listar registros bloqueados";
		break;}
echo ": ".$arrHttp["base"];
echo "<p><a href=inicio.php?Opcion=continuar class=boton>Volver al menú</a><p>";
switch ($arrHttp["Opcion"]) {
    case "inicializar":
    	$arrHttp["IsisScript"]="administrar.xis";
    	$contenido=VerStatus();
 		$ix=-1;
		foreach($contenido as $linea) {
//			echo $linea."<br>";
			$ix++;
			if ($ix>0) {
	   			$a=split(":",$linea);
	   			$tag[$a[0]]=$a[1];
			}
		}
		if (!isset($arrHttp["borrar"])){
			if (isset($tag["BD"]) and $tag["BD"]!="N"){
				echo "<center><br><span class=td><h4>".$arrHttp["base"]."<br><font color=red>Base de datos ya existe:</font><br>".$tag["MAXMFN"]." registros<BR>";
				echo "<script>
					if (confirm(\"Quiere eliminar todos los registros de la base de datos ??\")==true){
						borrarBd=true
					}else{
						borrarBd=false
					}
					if (borrarBd==true){
						if (confirm(\"Está seguro??\")==true){
							borrarBd=true
						}else{
							borrarBd=false
						}
					}
					if (borrarBd==true)
						self.location=\"administrar_ex.php?base=".$arrHttp["base"]."&cipar=".$arrHttp["base"]."par&Opcion=inicializar&borrar=true\"
					</script>";
			}else{

				$contenido=MostrarPft();
				foreach ($contenido as $linea){
				   	if (substr($linea,0,10)=='$$LASTMFN:'){
					     return $linea;
					}else{
			  			echo "$linea\n";
			  		}
			 	}
				$arrHttp["Opcion"]="unlockbd";
			}
		}else{
			$arrHttp["IsisScript"]="administrar.xis";
			$contenido=MostrarPft();
			foreach ($contenido as $linea){
			   	if (substr($linea,0,10)=='$$LASTMFN:'){
				     return $linea;
				}else{
		  			echo "$linea\n";
		  		}
		 	}
			$arrHttp["Opcion"]="unlockbd";
		}
		break;
	case "fullinv":

		$contenido=VerStatus();
		$arrHttp["IsisScript"]="fullinv.xis";
		$contenido=MostrarPft();
		foreach ($contenido as $linea){
		   	if (substr($linea,0,10)=='$$LASTMFN:'){
			     return $linea;
			}else{
	  			echo "$linea\n";
	  		}
	 	}
		break;
	case "listar":
		$contenido=VerStatus();
//		foreach ($contenido as $value) echo "<dd>$value<br>";
		echo "<table class=listTable>";
		echo "<th>Mfn</th><th>Locked by</th><th>Isis Status</th>";
		$arrHttp["IsisScript"]="administrar.xis";
		$contenido=MostrarPft();
		foreach ($contenido as $value) {			$t=explode('|',$value);
			if (trim($t[2])!="")
				echo '<tr><td>'.$t[0]."</td><td>".$t[1]."</td><td>".$t[2]."</td>\n";		}
		echo "</table>";
		break;
	case "unlockbd":
	   	$arrHttp["IsisScript"]="administrar.xis";
		$contenido=VerStatus();
		foreach ($contenido as $value) echo "$value<br>";
		echo "<p>".$msgstr["mnt_desb"];
		echo "<p>";
		$contenido=MostrarPft();
		foreach ($contenido as $value) echo "<dd>$value<br>";
		$contenido=VerStatus();
		foreach ($contenido as $value) echo "$value<br>";
		break;
	case "unlock":
		$contenido=VerStatus();
//		foreach ($contenido as $value) echo "$value<br>";
		echo "<p><table class=listTable>";
		echo "<th>Mfn</th><th>&nbsp;</th>";
		$arrHttp["IsisScript"]="administrar.xis";
		$contenido=MostrarPft();
		foreach ($contenido as $value) {
			$t=explode('|',$value);
			echo '<tr><td>'.$t[0]."</td><td>".$t[1]."</td>\n";
		}
		echo "</table>";
		break;


}

?>
