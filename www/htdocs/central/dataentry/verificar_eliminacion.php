<?php
/*
20220715 fho4abcd Use $actparfolder as location for .par files + return wxis error
*/
function VerificarEliminacion($archivo){
global $arrHttp,$db_path,$Wxis,$xWxis,$wxisUrl,$msgstr,$lang_db,$actparfolder;
    $Formato=$archivo;
	$IsisScript=$xWxis."leer_mfnrange.xis";
	$query="&base=".$arrHttp["base"]."&cipar=$db_path".$actparfolder.$arrHttp["base"].".par"."&from=".$arrHttp["Mfn"]."&to=".$arrHttp["Mfn"]."&Formato=$Formato";
	include("../common/wxis_llamar.php");
    if ($err_wxis!="") return $_SERVER['PHP_SELF']." :<br><br>".$err_wxis;
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