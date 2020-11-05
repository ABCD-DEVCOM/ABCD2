<?php

include("config_opac.php");
include("leer_bases.php");
//foreach ($_REQUEST as $key=>$value)    echo "$key=>".urldecode($value)."<br>";
$indice_alfa="n";
include("tope.php");
echo "<input type=button Value='Regresar' onclick=javascript:history.back()><br>";
foreach ($_REQUEST as $key=>$value) $_REQUEST[$key]=urldecode($value);
$Formato="@opac.pft";
$ex=explode('|',$_REQUEST["existencias"]);
$base=$ex[0];
$kardex=$ex[1];
$Expresion=$ex[2];
$Inventario=$ex[3];
$query = "&base=$base&cipar=$db_path"."par/$base.par&Expresion=".urlencode($Expresion)."&count=1&from=1&Formato=$Formato&Existencias=S";
echo $query;
$IsisScript="opac/buscar.xis";
$resultado=wxisLlamar($base,$query,$xWxis.$IsisScript);
foreach ($resultado as $value){
	if (substr($value,0,8)=='[TOTAL:]'){
		$total=trim(substr($value,8));
	}else{		echo "$value\n";	}
}
echo "<table id=existencias>";
$query = "&base=$kardex&cipar=$db_path"."par/$kardex.par&Expresion=$Inventario"."&Formato=@inven_detalle.pft";
$IsisScript="opac/buscar.xis";
$base="kardex";
$resultado=wxisLlamar($base,$query,$xWxis.$IsisScript);
foreach ($resultado as $value){
	if (substr($value,0,8)=='[TOTAL:]'){
		$total=trim(substr($value,8));
	}else{
		echo "$value\n";
	}
}
echo "</table>";
echo "<input type=button id=search-submit Value='Regresar' onclick=javascript:history.back()><br>";
if (isset($_REQUEST["prefijoindice"]) and $_REQUEST["prefijoindice"]!="") {
		echo "<p><input type=button id=search-submit value=\" &nbsp;Volver al índice&nbsp; \" onclick=javascript:document.indice.submit()>\n";
	}
echo "<form name=continuar action=buscar_integrada.php method=post>\n";
foreach ($_REQUEST as $key=>$value){	echo "<input type=hidden name=$key value=\"".urlencode($value)."\">\n";}
echo "</form>";
?>
<?php
include("footer.php");

?>
