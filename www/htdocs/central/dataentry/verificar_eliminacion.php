<?php
function VerificarEliminacion($archivo){
global $arrHttp,$db_path,$Wxis,$xWxis,$wxisUrl,$msgstr,$lang_db;

	$Formato=trim($archivo);
	$fp=file($archivo.".pft");
	$fp=trim(implode("",$fp));
	if (substr(trim($fp),0,1)=="@"){
		$archivo=$fp;
		$pft_file=$db_path.$arrHttp["base"]."/pfts/".substr($archivo,1);
		if (file_exists($pft_file)){
			$Formato="&Pft=@".$pft_file;
		}else{
			$pft_file=$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".substr($archivo,1);
			if (!file_exists($pft_file)) $pft_file=$db_path.$arrHttp["base"]."/pfts/".$lang_db."/".substr($archivo,1);
			$Formato="&Pft=@".$pft_file;
		}
	}else{
		$Formato="&Formato=".trim($archivo);
	}
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