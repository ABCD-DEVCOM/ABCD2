<?php
session_start();
include("../common/get_post.php");
include("../config.php");

foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
die;

include("fecha_de_devolucion.php");

//función para calcular la diferencia de tiempo entre dos fecha
function dateDiff($dformat, $endDate, $beginDate)
{

	$date_parts1=explode($dformat, $beginDate);
	$date_parts2=explode($dformat, $endDate);
	$start_date=gregoriantojd($date_parts1[0], $date_parts1[1], $date_parts1[2]);
	$end_date=gregoriantojd($date_parts2[0], $date_parts2[1], $date_parts2[2]);
	return $end_date - $start_date;
}

//Se ubica el ejemplar prestado en la base de datos de transacciones
$inventario="TR_P_".trim($arrHttp["searchExpr"]);
if (!isset($arrHttp["base"])) $arrHttp["base"]="trans";
$Formato="v10'|'v12'|'v15'|'v20'|'v30'|'v35'|'v40'|'v45'|'v70'|'v80'|'v90'|'v95'|'v98'|'v100/";
$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&count=1&Expresion=".$inventario."&Pft=$Formato";
$contenido="";
$IsisScript=$xWxis."buscar_ingreso.xis";
include("../common/wxis_llamar.php");
$Total=0;
foreach ($contenido as $linea){	$linea=trim($linea);
	if ($linea!="") {
		$l=explode('|',$linea);
		if (substr($linea,0,6)=="[MFN:]"){			$Mfn=trim(substr($linea,6));		}else{			if (substr($linea,0,8)=="[TOTAL:]"){				$Total=trim(substr($linea,8));			}else{				$prestamo=$linea;			}
		}
	}
}
$error="";
//echo "Mfn=$Mfn<p>" ;
if ($Total==0){
	$error="&error=Ejemplar no está prestado";
	Regresar($error);
	die;
}

// se extrae la información del ejemplar a devolver
	$p=explode('|',$prestamo);
	$cod_usuario=$p[1];
	$inventario=$p[0];
	$fecha_p=$p[2];
	$hora_p=$p[3];
	$fecha_d=$p[4];
	$hora_d=$p[5];
	$tipo_usuario=$p[6];
	$tipo_objeto=$p[7];
	$referencia=$p[8];

	// se lee la política de préstamos
	include("loanobjects_read.php");
	// se lee el calendario
	include("calendario_read.php");
	// se lee la configuración local
	include("locales_read.php");

	// se incluye la rutina para calcular la fecha de devolucion


	//se determina la política a aplicar
	$politica=$politica[$tipo_objeto][$tipo_usuario];
	$p=explode('|',$politica);
	$lapso=$p[3];
	$unidad=$p[5];
//	echo "<p>Fecha de devolución programada: ".substr($fecha_d,6,2)."/".substr($fecha_d,4,2)."/".substr($fecha_d,0,4)." ".$hora_d."<br>";
	//Se calcula la fecha de devolución real en base a la política
	$df=explode('/',$config_date_format);
	$newdate = date($df[0]."/".$df[1]."/".$df[2]." h:i:s A");

//	echo "<p>Fecha de devolucion real= $newdate<p>$lapso";

	// se calcula la diferencia entre la fecha programada y la fecha real de devolución
	$newdate=date("m/d/Y h:i:s A");
	//echo "----$newdate---";
	$unidad="D";
	switch ($unidad){		case "H":
			$date1 = time();
			$tt=explode(' ',$hora_d);
			$date2 = mktime(0,0,0, substr($fecha_d,4,2),substr($fecha_d,6,2),substr($fecha_d,0,4));
			$newdate=date("m/d/Y h:i:s A");
	//	    $fecha_d= ."/".."/".." ".$hora_p;
	//		$atraso=dateDiff("/", $newdate, $fecha_d);
			break;
		case "D":
			$newdate=date("m/d/Y");
			$fecha_d=  substr($fecha_d,4,2)."/".substr($fecha_d,6,2)."/".substr($fecha_d,0,4);
			$atraso=dateDiff("/", $newdate, $fecha_d);
			break;	}
    if ($atraso>0){    	$error="&error=Está atrasado. No se puede renovar";
    	Regresar($error);
    	die;    }
// Se pasa la fecha de préstamo y devolución anteriores al campo 200
	$f_ant="^a".$fecha_p."^b".$hora_p."^c".$fecha_d."^d".$hora_p;
//se calcula la nueva fecha de devolución
	$fecha_dev=FechaDevolucion($lapso,$unidad,"");
	$fecha_pres=date("Ymd h:i:s A");
	$ixp=strpos($fecha_dev," ");
	$fecha_d=trim(substr($fecha_dev,0,$ixp));
	$hora_d=trim(substr($fecha_dev,$ixp));
	$ixp=strpos($fecha_pres," ");
	$fecha_p=trim(substr($fecha_pres,0,$ixp));
	$hora_d=trim(substr($fecha_pres,$ixp));

	$ValorCapturado="d30,d35,d40,d45,";
	$ValorCapturado.="<30 0>".$fecha_p."</30>";
	$ValorCapturado.="<35 0>".$hora_p."</35>";
	$ValorCapturado.="<40 0>".$fecha_d."</40>";
	$ValorCapturado.="<45 0>".$hora_d."</45>";
	$ValorCapturado.="<200 0>".$f_ant."</200>";
	$ValorCapturado=urlencode($ValorCapturado);
	$IsisScript=$xWxis."actualizar_registro.xis";
	$Formato="";
	$query = "&base=trans&cipar=$db_path"."par/trans.par&login=".$_SESSION["login"]."&Mfn=".$Mfn."&ValorCapturado=".$ValorCapturado;
	include("../common/wxis_llamar.php");
    Regresar("");
die;

function Regresar($error){global $arrHttp,$cod_usuario;	$cu="";
	if (isset($arrHttp["usuario"]) and !isset($cod_usuario))
		$cu="&usuario=".$arrHttp["usuario"];
	else
		$cu="&usuario=$cod_usuario";
	if (isset($arrHttp["vienede"])){
		header("Location: usuario_prestamos_presentar.php?encabezado=s$error$cu");
	}else{
		header("Location: renovar.php?encabezado=s$error$cu");
	}
	die;}





?>