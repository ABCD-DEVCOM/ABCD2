<?php
//se puede borrar?
include("../common/get_post.php");
foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../config.php");
// SE DETERMINA LA SIGNATURA DEL OBJETO
if (!isset($arrHttp["cotaprestamos"]) or $arrHttp["cotaprestamos"]==""){
	$signatura=$arrHttp["cotalibros"];
}else{
	$signatura=$arrHttp["cotaprestamos"];
}
include("../common/header.php");
?>
    <script>
    	function Enviar(){    		Codigo=Trim(document.reserva.codigo.value)
    		if (Codigo==""){    			alert("Debe especificar su código de usuario")
    			return    		}
    		document.reserva.submit()    	}
    </script>
</head>
<body>
<br>
<table width=100%>
<td align=center>
<span class=titulo1>Solicitud de reserva</span><p>
<?php
//SE LEE EL REGISTRO BIBLIOGRÁFICO CON EL OBJETO SOLICITADO
$IsisScript=$xWxis."buscar.xis";
$query="&base=biblo&cipar=bibliosupers.par&Expresion=".$arrHttp["cotalibros"]."&Formato=@reserva_rb.pft";
putenv('REQUEST_METHOD=GET');
putenv('QUERY_STRING='."?xx=".$query);
$contenido="";
exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
$total_ej=0;
foreach ($contenido as $value) {	$value=trim($value);
	if (substr($value,0,13)=='$$EJEMPLARES:')
		$total_ej=trim(substr($value,13));
	else
		print "$value";}
if ($total_ej==0) $total_ej=1;
print "<P><table bgcolor=#cccccc>
<td class=td>Total ejemplares </td><td class=td>".$total_ej;
print "</td>";
//SE LOCALIZAN LOS EJEMPLARES PRESTADOS
$IsisScript=$xWxis."buscar.xis";
$query="&base=presta&cipar=bibliosupers.par&Expresion=".$signatura."&Formato=@prestados.pft";
putenv('REQUEST_METHOD=GET');
putenv('QUERY_STRING='."?xx=".$query);
$contenido="";
exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
$prestados=0;
foreach ($contenido as $value){	if ($prestados==0){		echo "<tr><td class=td>Prestados</td>";
	}
	$prestados++;
	echo "<td>$value</td>";}

//SE LEEN LAS RESERVAS
$IsisScript=$xWxis."buscar.xis";
$query="&base=reserva&cipar=bibliosupers.par&Expresion=".$signatura."&Formato=@reservados.pft";
putenv('REQUEST_METHOD=GET');
putenv('QUERY_STRING='."?xx=".$query);
$contenido="";
exec("\"".$Wxis."\" IsisScript=$IsisScript",$contenido);
$reservas=0;
foreach ($contenido as $value){	if ($reservas==0){
		echo "<tr><td class=td valign=top>Reservas</td><td>";
	}
	$reservas++;
	$r=explode('|',$value);
	$fecha=$r[2];
	echo substr($fecha,6,2)."-".substr($fecha,4,2)."-".substr($fecha,0,4)."<br>";
}
if ($reservas!=0) echo "</td>";
echo "<tr><td>Total reservas</td><td>$reservas</td>";
echo "<tr><td colspan=2>Solo se garantizan las reservas por un día</td>";
print "</table>";
if ($reservas < $total_ej){	echo "<p><span class=titulo1>Información del usuario</span>";
	echo "<form name=reserva action=reservar.php onsubmit='return false'>\n";
	echo "<table><td class=td>Código de usuario</td>\n";
	echo "<td><input type=password name=codigo> ";
	echo "<input type=hidden name=cotalibros value='".$arrHttp["cotalibros"]."'>";
	echo "<input type=hidden name=cotaprestamos value='".$arrHttp["cotaprestamos"]."'>";
	echo "<input type=submit onClick=javascript:Enviar() value='Reservar'>
	</td></table></form>";}else{	echo "<p>Los ejemplares disponibles ya se encuentran reservados";}
?>
</td>
</table>
</body>
</html>