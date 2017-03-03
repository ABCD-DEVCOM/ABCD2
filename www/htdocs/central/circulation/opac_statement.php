<?php
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)    echo "$var=$value<br>";
$path=$arrHttp["environment"];
$ix=strpos($path,'^b');
$path=substr($path,$ix+2);
$ix=strpos($path,"^p");
$path=substr($path,0,$ix-1);
include("../config.php");
$db_path=$path."/";
$_SESSION["lang"]=$arrHttp["lang"];
$lang=$_SESSION["lang"];
include("../lang/prestamo.php");
?>
<html>
<title><?php echo $msgstr["statment"]?></title>
<script src=../dataentry/js/lr_trim.js></script>
<Script>
function EnviarForma(){
	if (Trim(document.reserva.usuario.value)==""){
		alert("ID ???")
		return
	}
	document.reserva.submit()
}
function PoliticaReserva(){
	msgwin=window.open("politica_reserva.html","politica","width=500,height=400, resizable, scrollbars")
	msgwin.focus()
}
</script>
<body>
<?PHP
if (isset($def["LOGO"]))echo "<img src=".$def["LOGO"].">";
?>
<font face=arial size=2>
<form name=reserva action=opac_statement_ex.php method=post onsubmit="javascript:return false">
<?php

echo "<p><strong>".$msgstr["iah_usuario_ecta"]."</strong>";

echo "<p><input type=text name=usuario>\n";
echo "<input type=hidden name=DB_PATH value=$db_path>\n";
echo "<input type=hidden name=lang value=$lang>\n";
echo "<input type=hidden name=vienede value=ecta_web>\n";
echo " &nbsp; <input type=submit value='".$msgstr["continue"]."' onclick=javascript:EnviarForma()>";
?>
</form>
</font>
</html>

