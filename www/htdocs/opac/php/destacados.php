<?php
include("config_opac.php");
$Formato="opac.pft";$salida="";
$Expresion=$_REQUEST["Expresion"];
$base=$_REQUEST["base"];if (trim($Expresion)!=""){	$query = "&base=$base&cipar=$db_path"."par/$base.par&Expresion=".urlencode($Expresion)."&count=1&from=1&Formato=$Formato";
	$resultado=wxisLlamar($base,$query,$xWxis."buscar.xis");
	foreach ($resultado as $value) {
		$value=trim($value);
		if (substr($value,0,8)=='[TOTAL:]'){
			continue;
		}else{
	       $salida.=$value;
		}	}
}
?>
