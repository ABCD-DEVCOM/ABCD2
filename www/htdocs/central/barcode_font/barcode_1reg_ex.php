<?php
set_time_limit(0);
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");

function LeerRegistro($base,$cipar,$from,$to,$Opcion,$Formato) {
global $xWxis,$msgstr,$db_path,$Wxis,$wxisUrl,$lang_db;

 	if (file_exists($db_path.$base."/pfts/".$_SESSION["lang"]."/" .$Formato.".pft")){
 		$Formato=$db_path.$base."/pfts/".$_SESSION["lang"]."/" .$Formato;
 	}else{
 		$Formato=$db_path.$base."/pfts/".$lang_db."/" .$Formato;
    }

 	$IsisScript=$xWxis."leer_mfnrange.xis";
 	$query = "&base=$base&cipar=$db_path"."par/".$cipar. "&from=" . $from."&to=$to&Formato=$Formato";
	include("../common/wxis_llamar.php");
	return $contenido;
}

function MfnBarCode($base,$from,$to,$Formato){
global $db_path,$lang_db;
	$cipar=$base.".par";
	$Opcion="leer";
	$login="xx";
	$password="xx";
	$contenido=LeerRegistro($base,$cipar,$from,$to,$Opcion,$Formato);
	foreach ($contenido as $value){		$value=trim($value);
		if ($value!="") {			$v=explode('|',$value);
			foreach ($v as $linea)
				echo $linea."<br>";		}	}
}
$Formato="";
if (file_exists($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/barcode_label.tab")){
 		$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/barcode_label.tab");
 		foreach ($fp as $value){ 			$v=explode('=',$value);
 			if (trim($v[0])=="formato"){ 				$Formato=trim($v[1]);
 				break; 			} 		}
}else{
	echo "Debe configurar las etiquetas para el código de barras";
	die;
}
$ix=strpos($Formato,".pft");
if ($ix>0)  $Formato=substr($Formato,0,$ix);
MfnBarCode($arrHttp["base"],$arrHttp["desde"],$arrHttp["hasta"],$Formato);

?>
<script>
	document.close()
	self.print()

</script>