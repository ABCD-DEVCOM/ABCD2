<?php
function VerificarEliminacion($archivo){
global $arrHttp,$db_path,$Wxis,$xWxis,$wxisUrl,$msgstr,$lang_db;
    $Formato=$archivo;
	$IsisScript=$xWxis."leer_mfnrange.xis";
	$query="&base=".$arrHttp["base"]."&cipar=$db_path"."par/".$arrHttp["base"].".par"."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"]."&Formato=$Formato";
	include("../common/wxis_llamar.php");
	$res=implode("",$contenido);
	$salida="";
	$res=trim($res);
	while ($res!=""){
		$ixpos=0;
		$ix1=strpos($res,'$$MSGUSR:');
		if ($ix1===false){
			$salida.=substr($res,0,strlen($res));
			$res="";
		}else{
			$salida.=substr($res,0,$ix1);
			$msgcode=substr($res,$ix1+8+1,3);
			$salida.=$msgstr[$msgcode];
			$res=substr($res,$ix1+12);
		}

	}
	return $salida;
}
?>