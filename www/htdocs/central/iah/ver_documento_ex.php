<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
  <title>Solicitud de documento</title>
  <script>
  	  function PresentarDocumento(){  	  	msgwin=window.open("","PDFDOC","width=800,height=800,scrollbars,resizable")
  	  	msgwin.document.title="Pdf"  	  	document.solicitud.submit()

  	  	msgwin.focus()
  	  	self.close()  	  }
  </script>
</head>
<?php include('header.php');?>

<?php
function LeerUsuario($usuario,$prefix,$Pft,$db_path){global $xWxis,$wxisUrl,$Wxis;
	$IsisScript=$xWxis."buscar.xis";
	$formato=$Pft;
	$formato=urlencode($formato);
	$query = "&Expresion=".$prefix.trim($usuario)."&base=users&cipar=$db_path"."par/users.par&Pft=$formato";
	$contenido="";
	$IsisScript=$xWxis."cipres_usuario.xis";
	include("../common/wxis_llamar.php");
	return ($contenido);
}
include ("configure.php");
$error="";
$resultado=LeerUsuario($arrHttp["usuario"],$config["USER_SEARCH"],$config["USER_DISPLAY"],$config["DB_PATH"]);
if (count($resultado)==0 or trim($resultado[0])==""){
	$error="S";	echo "<font color=darkred><P>".$arrHttp["usuario"].": "."No está registrado como socio de la AEU ";
	echo "<p><a href=javascript:history.back()>Regresar</a>";
	die;}
echo "<form name=solicitud action=download.php method=post target=PDFDOC onsubmit=javascript:'return false'>";
foreach ($arrHttp as $var=>$value){
	echo "<input type=hidden name=$var value=\"$value\">\n";
}
if ($error=""){
	echo "<h4>".$resultado[0]."</h4>";
	$db_path=$config["DB_PATH"];
	$dbn=$arrHttp["base"];
	$IsisScript=$xWxis."leer_mfnrange.xis";
	$Pft=urlencode($config["DOCUMENT_DISPLAY"]);
	$query="&base=$dbn&cipar=".$db_path."par/$dbn.par&from=".$arrHttp["mfn"]."&to=".$arrHttp["mfn"]."&Pft=$Pft";
	include("../common/wxis_llamar.php");

	foreach ($contenido as $value) echo "<b>$value</b><br>";
}
?>
<p><a href=javascript:PresentarDocumento()>Ver el documento</a>
</form>
</body>
</html>

