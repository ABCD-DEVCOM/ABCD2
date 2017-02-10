<?php
session_start();
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value)    echo "$var=$value<br>";
$path=$arrHttp["environment"];
$ix=strpos($path,'^b');
$path=substr($path,$ix+2);
$ix=strpos($path,"^p");
if ($ix>0)
	$path=substr($path,0,$ix-1);
if (substr($path,strrpos($path,'/'),1)!='/')
	$db_path=$path."/";
else
	$db_path=$path;
$_SESSION["DATABASE_DIR"]=$db_path;
include("../config.php");
$_SESSION["lang"]=$arrHttp["lang"];
$lang=$_SESSION["lang"];
include("../lang/prestamo.php");
if (isset($def["BG_WEB"]))
	$BG_web=" style=\"background:".$def["BG_WEB"]."\"";
else
	$BG_web=" ";
?>
<html>
<title><?php echo $msgstr["statment"]?></title>
<script src=../dataentry/js/lr_trim.js></script>
<Script>
function EnviarForma(){	if (Trim(document.reserva.usuario.value)==""){		alert("Debe suministrar su número de carnet")
		return	}
	document.reserva.submit()}
function PoliticaReserva(){	msgwin=window.open("politica_reserva.html","politica","width=500,height=400, resizable, scrollbars")
	msgwin.focus()}
</script>
<body <?php echo $BG_web; ?>>
<?PHP
if (isset($logo_opac))echo "<img src=".$logo_opac.">";

?>
<font face=arial size=2>
<form name=reserva action=opac_statment_ex.php method=post onsubmit="javascript:return false">
<?php

echo "<p><strong>".$msgstr["iah_usuario_ecta"]."</strong>";

echo "<p><input type=text name=usuario>\n";
echo "<input type=hidden name=DB_PATH value=$db_path>\n";
echo "<input type=hidden name=lang value=$lang>\n";
echo "<input type=hidden name=vienede value=ecta_web>\n";
echo " &nbsp; <input type=submit value='".$msgstr["continue"]."' onclick=javascript:EnviarForma()>";
if (isset($msgstr["iah_usuario_ecta_1"])) echo "<p>".$msgstr["iah_usuario_ecta_1"];
if (isset($msgstr["iah_usuario_ecta_2"])) echo "<p>".$msgstr["iah_usuario_ecta_2"];
?>
<p>
<input type=button value="<?php echo $msgstr["close"]?>" onclick=javascript:self.close()>
</form>
</font>
</html>

