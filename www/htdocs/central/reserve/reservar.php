<?php

include("../common/get_post.php");
foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../config.php");
// SE DETERMINA LA SIGNATURA DEL OBJETO
if (!isset($arrHttp["cotaprestamos"]) or $arrHttp["cotaprestamos"]==""){	$signatura=substr($arrHttp["cotalibros"],2);}else{	$signatura=substr($arrHttp["cotaprestamos"],2);}


//PROCESAR LA RESERVA
function Reservar($usuario,$signatura,$tipousuario){
global $xWxis,$wxisUrl,$Wxis;	echo "<p>Título solicitado: ".$signatura."<p>";
//SE DETERMINA SI EL USUARIO NO TIENE YA RESERVADO ESE OBJETO
	$IsisScript=$xWxis."buscar.xis";
	$query="&base=reserva&cipar=reserva.par&Expresion=CU_".$usuario."&Formato=@reservados.pft";
	putenv('REQUEST_METHOD=GET');
	putenv('QUERY_STRING='."?xx=".$query);
	$contenido="";
	exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
	$num_reservas=0;
	$yareservado="N";
	foreach ($contenido as $value) {		if ($num_reservas==0){			echo "<table bgcolor=#cccccc><td>Usuario</td><td>No.clasif.</td><td>Fecha reserva</td><td></td>";		}
		$value=trim($value);
		$num_reservas++;
		$r=explode('|',$value);
		echo "<tr>";
		$ixl=-1;
		foreach ($r as $linea) {			$ixl++;
			if ($ixl==2){				$linea=substr($linea,6,2)."-".substr($linea,4,2)."-".substr($linea,0,4);			}
			echo "<td>".$linea."</td>";		}
		if ($r[1]==$signatura){
			echo "<td><strong><font color=red>**</font></strong></td>";
			$yareservado="S";
	    }else{	    	echo "<td></td>";	    }
	}

	if ($num_reservas !=0) echo "</table>";
	if ($yareservado=="S"){
		echo "<strong><font color=red>** El título solicitado ya está reservado por ese usuario</font></strong>";
		"<p><a href=javascript:self.close>Cerrar</a>";
		return;
	}
	if ($num_reservas>=2){
		print "No se permiten más de 2 reservas";
		"<p><a href=javascript:self.close>Cerrar</a>";
		return;
	}
	$ValorCapturado="<10 0>".$usuario."</10><20 0>".$signatura."</20><30 0>".date('Ymd')."</30>";
	$IsisScript=$xWxis."actualizar.xis";
  	$query = "&base=reserva&cipar=reserva.par&login".$_SESSION["login"]."&Mfn=New&Opcion=crear&ValorCapturado=".$ValorCapturado;
	putenv('REQUEST_METHOD=GET');
	putenv('QUERY_STRING='."?xx=".$query);
	$contenido="";
	exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
	foreach ($contenido as $linea){
		if (substr($linea,0,4)=="MFN:") {
	    	$arrHttp["Mfn"]=trim(substr($linea,4));
		}else{
			if (trim($linea!="")) $salida.= $linea."\n";
		}
	}
	print "<span class=titulo1>Reserva realizada</span>";
}
?>
<html>
<head>
	<title>Reserva</title>
	<meta http-equiv="Expires" content="-1" />
	<meta http-equiv="pragma" content="no-cache" />
	<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<meta http-equiv="Content-Language" content="pt-br" />
	<meta name="robots" content="all" />
	<meta http-equiv="keywords" content="" />
	<meta http-equiv="description" content="" />
	<link rel="stylesheet" rev="stylesheet" href="../common/css/styles.css" type="text/css" media="screen"/>
    <script src=../common/js/lr_trim.js></script>

</head>
<body>
<br>
<table width=100%>
<td align=center>
<span class=titulo1>Solicitud de reserva</span><p>
<?php
//SE LEE EL CODIGO DEL USUARIO Y SE DETERMINA EL TIPO
$IsisScript=$xWxis."buscar.xis";
$found="N";
$query="&base=users&cipar=bibliosupers.par&Expresion=!C".$arrHttp["codigo"]."&Formato=@usuario.pft";
putenv('REQUEST_METHOD=GET');
putenv('QUERY_STRING='."?xx=".$query);
$contenido="";
exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
foreach ($contenido as $value) {
	$value=trim($value);	$found="S";
	if (substr($value,0,14)=='$$TIPOUSUARIO:')
		$tipousuario=substr($value,14);
	else		print "$value";}
if ($found=="N"){	print "Codigo de usuario inexistente";
	print "<p><a href=javascript:history.back()>Regresar</a>";
	die;}

//SE LOCALIZAN LOS PRÉSTAMOS PENDIENTES
$Formato="v800^n'|',v800^c'|',v800^t'|',v800^h/";
$IsisScript=$xWxis."buscar.xis";
$found="N";
$query="&base=presta&cipar=bibliosupers.par&Expresion=".$arrHttp["codigo"]."-P&Formato=$Formato";
putenv('REQUEST_METHOD=GET');
putenv('QUERY_STRING='."?xx=".$query);
$contenido="";
$vencidos=0;
exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
foreach ($contenido as $value) {	if ($found=="N"){		print "<p><span class=titulo2>Estado de cuenta</span><table bgcolor=#cccccc><th>No.inv</th><th>No.clasif</th><th>Título</th><th>Vencimiento</th>";		$found="S";
	}
	echo "<tr>";
	$t=explode('|',$value);
	$ix=0;
	$yaprestado="";
	foreach ($t as $prest){//PARA CADA PRESTAMO SE DETERMINA SI ESTÁ VENCIDO O SI YA TIENE UN EJEMPLAR DEL OBJETO		$ini="";
		$fin="";
		if ($ix==3) {			if (date("Ymd")>$prest){				$vencidos++;
				$ini="<font color=red>";
				$fin="</font>";			}			$prest=substr($prest,6,2)."-".substr($prest,4,2)."-".substr($prest,0,4);		}
		$ix++;
		print "<td>".$ini.$prest.$fin."</td>";
		if ($ix==1){			if ($signatura==$prest){				$yaprestado="S";			}		}
	}
	print "\n";
}
if ($found=="S") {	print "</table>\n";
	if ($vencidos>0){		print "<p><font color=darkred>Tiene ejemplares vencidos. No puede reservar</font>";
		"<p><a href=javascript:self.close>Cerrar</a>";
		die;	}
}
if ($yaprestado=="S"){	echo "Ya tiene prestado un ejemplar de ese título. No puede reservar";
	"<p><a href=javascript:self.close>Cerrar</a>";
}else{	Reservar($arrHttp["codigo"],$signatura,$tipousuario);}

?>
</body>
</html>