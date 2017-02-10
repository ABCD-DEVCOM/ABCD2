<html>
<title>Reservar</title>
<script src=../dataentry/js/lr_trim.js></script>
<Script>
function EnviarForma(){	if (Trim(document.reserva.usuario.value)==""){		alert("Debe suministrar su número de carnet")
		return	}
	document.reserva.submit()}
function PoliticaReserva(){	msgwin=window.open("politica_reserva.html","politica","width=500,height=400, resizable, scrollbars")
	msgwin.focus()}
</script>
<body>
<font face=arial size=2>
<form name=reserva action=reservar_lee_usuario.php onsubmit="javascript:return false">
<?php
include("../common/get_post.php");
if (isset($arrHttp["inven"])){
	echo "<input type=hidden name=inventory value=".$arrHttp["inven"].">\n";
	echo "<input type=hidden name=ctrl_num value=".$arrHttp["ctrl"].">\n";
	echo "<input type=hidden name=vienede value=ecta_web>\n";
	echo "<strong>Reservar un ejemplar</strong>";
	echo "<p>Por favor, suministre su número de carnet";
	echo "<p><input type=text name=usuario>";
	echo " &nbsp; <input type=submit value=reservar onclick=javascript:EnviarForma()>";
	echo "<p><A HREF=javascript:PoliticaReserva()>Ver política de reserva</a>";
}


?>
</form>
</font>
</html>
