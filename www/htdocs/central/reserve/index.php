<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
	<head>
		<title>ABCD</title>
		<meta http-equiv="Expires" content="-1" />
		<meta http-equiv="pragma" content="no-cache" />
		<META http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<meta http-equiv="Content-Language" content="pt-br" />
		<meta name="robots" content="all" />
		<meta http-equiv="keywords" content="" />
		<meta http-equiv="description" content="" />
<link rel="stylesheet" rev="stylesheet" href="common/css/styles.css" type="text/css" media="screen"/>
<script src=common/js/lr_trim.js></script>
<script languaje=javascript>

document.onkeypress =
	function (evt) {
			var c = document.layers ? evt.which
	       		: document.all ? event.keyCode
	       		: evt.keyCode;
			if (c==13) Enviar()
			return true;
	}

function UsuarioNoAutorizado(){
	alert("Usuario no autorizado")
}

function Enviar(){
	login=Trim(document.administra.login.value)
	password=Trim(document.administra.password.value)
	if (login=="" || password==""){
		alert("Debe especificar sus datos de identificación")
		return
	}else{
		document.administra.submit()
	}
}

</script>
</head>
<body>
<form name=administra onsubmit="javascript:return false" method=post action=admin/inicio.php>
<input type=hidden name=Opcion value=admin>
<input type=hidden name=cipar value=acces.par>

<table bgcolor=#649963 align=center cellpadding=10>
	<tr>
		<td class=td>Id. usuario</td>
		<td>
			<input type="text" name="login" id="user" value="" />
		</td>
	<tr>
		<td>Clave de acceso</td>
		<td>
			<input type="password" name="password" id="pwd" value="" />
         </td>>
	</table>
	<center><p><input type=submit onclick="javascript:Enviar()" value=Entrar>

</form>
	</body>
</html>
<?php
include("../common/get_post.php");
if (isset($arrHttp["error"])){	echo "<script>alert('Usuario inválido')</script>";}
?>

