<?php
include("config_opac.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset?>" />
</head>
<body>
<?php
//foreach ($_REQUEST AS $var=>$value) echo "$var=>$value<br>";
function WxisLlamar($base,$query,$IsisScript){
global $db_path,$Wxis,$xWxis;
	include("wxis_llamar.php");
	return $contenido;
}if (isset($_REQUEST["db_path"]))
	$db_path=$_REQUEST["db_path"];
$query = "&cipar=$db_path"."par/".$_REQUEST["base"]. ".par&Expresion=".$_REQUEST["Expresion"]."&Opcion=buscar&base=".$_REQUEST["base"]."&Formato=".$_REQUEST["Formato"]."&lang=".$_REQUEST["lang"];
$IsisScript=$xWxis."opac/buscar.xis";
$contenido=WxisLLamar($_REQUEST["base"],$query,$IsisScript);
foreach($contenido as $linea) {	if (substr($linea,0,8)=='[TOTAL:]') continue;
	$linea=trim($linea,"\n") ;
	if ($linea!="")		echo $linea;
}
?>

</body>

</html>