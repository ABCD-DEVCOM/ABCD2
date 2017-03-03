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

include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/soporte.php");

include ("configure.php");
if (!isset($arrHttp["output"])) $arrHttp["output"]="display";
switch($arrHttp["output"]){
	case "doc":
		$filename="barcode_".$arrHttp["base"].".doc";
		header('Content-Type: application/msword; charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");

		#echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
		#echo '   xmlns:w="urn:schemas-microsoft-com:office:word"' . "\n";
		#echo '   xmlns="http://www.w3.org/TR/REC-html40">' . "\n";
		break;
	case "xls":

		break;
	case "calc":
	   	$filename="barcode_".$arrHttp["base"].".ods";
		header('Content-Type: application/vnd.oasis.opendocument.spreadsheet;  charset=windows-1252');
		header("Content-Disposition: inline; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
   		break;
	case "odt":
		$filename="barcode_".$arrHttp["base"].".odt";
		header('Content-Type: application/vnd.oasis.opendocument.text;  charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
   		break;
	case "csv":
		$filename="barcode_".$arrHttp["base"].".csv";
		header('Content-Type: text/plain;  charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
    	break;
    case "txt":
    	$filename="barcode_".$arrHttp["base"].".txt";
    	header('Content-Type: text/plain;  charset=windows-1252');
		header("Content-Disposition: attachment; filename=\"$filename\"");
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
   		break;	default:
		break;}

function ImprimirBarCode($clasificacion,$codigo,$output){	switch ($output){
		case "display":
			echo $clasificacion."<span  style=\"font-family:'Arial' ; font-size:15px\">".$codigo."</span><br>";
		    break;
		case "odt":
			echo $clasificacion."\tab <span  style=\"font-family:'Arial' ; font-size:15px\">".$codigo."</span><p>";
		    break;
		case "txt":
			$codigo=strip_tags($codigo);
			echo $clasificacion."|".$codigo."\n";
			break;
		case "csv":
			$codigo=strip_tags($codigo);
	    	echo '"'.$clasificacion.'","'.$codigo.'"'."\n";
	    	break;
	  	case "calc":
	  		$codigo=strip_tags($codigo);
			echo $clasificacion."\t ".$codigo."\n";
			break;
	}}

function LeerRegistro($base,$cipar,$from,$to,$Opcion,$Formato,$copies) {
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

function BuscarClasificacion($number,$Formato,$Prefijo,$base,$cipar){global $xWxis,$msgstr,$db_path,$Wxis,$wxisUrl,$lang_db;
    $Formato="signatura";
	if (file_exists($db_path.$base."/pfts/".$_SESSION["lang"]."/" .$Formato.".pft")){
 		$Formato=$db_path.$base."/pfts/".$_SESSION["lang"]."/" .$Formato;
 	}else{
 		$Formato=$db_path.$base."/pfts/".$lang_db."/" .$Formato;
    }
    //$Formato="@".$Formato;
    $Expresion=$Prefijo.$number;
    $IsisScript=$xWxis."buscar.xis";
    $query = "&Opcion=buscar&base=$base&cipar=$db_path"."par/".$cipar. "&count=1&Formato=$Formato&Expresion=".$Expresion."&prologo=NNN&epilogo=NNN";
	include("../common/wxis_llamar.php");
	return $contenido;}

function InventarioBarCode($base,$from,$to,$fe_control,$copies,$pref_control,$output){
global $db_path,$lang_db,$xWxis,$Wxis,$fe_classification;
	$base=$base;
	$cipar=$base.".par";
	$IsisScript= $xWxis."ifp.xis";
	$ver="";
	//while (strlen($from)<7) $from="0".$from;
	//while (strlen($to)<7) $to="0".$to;
	$from="INS_".$from;
	$to="INS_".$to."Z";
	$Formato="barcode.pft";
	if (file_exists($db_path."copies/pfts/".$_SESSION["lang"]."/" .$Formato)){
 		$Formato=$db_path."copies/pfts/".$_SESSION["lang"]."/" .$Formato;
 	}else{
 		$Formato=$db_path."copies/pfts/".$lang_db."/" .$Formato;
    }
    $formato="@".$Formato;
   // echo $Formato;
	$query = "&base=copies&cipar=$db_path"."par/copies.par&count=99999&Opcion=autoridades"."&prefijo=$from&to=$to"."&formato_e=$formato";
	$contenido=array();
	include("../common/wxis_llamar.php");
	$nc=$contenido;
	foreach ($nc as $value){		//echo "$value<br>";
		$v=explode('|',$value);
		$Prefijo="CN_";
		$base=trim($v[0]);
		$cipar=$base.".par";
		$contenido=BuscarClasificacion($v[0],$fe_classification,$Prefijo,$v[1],$v[1].".par");
    	foreach ($contenido as $code){    		ImprimirBarCode($code,$v[2],$output);
		}


	}
}

function DateBarCode($base,$from,$to,$fe_date,$copies,$pref_date,$output){
global $db_path,$lang_db,$xWxis,$Wxis,$fe_classification;
	$base=$base;
	$cipar=$base.".par";
	$IsisScript= $xWxis."ifp.xis";
	$ver="";
	$from=$pref_date.$from;
	$to=$pref_date.$to."Z";
	$Formato="barcode.pft";
	if (file_exists($db_path."copies/pfts/".$_SESSION["lang"]."/" .$Formato)){
 		$Formato=$db_path."copies/pfts/".$_SESSION["lang"]."/" .$Formato;
 	}else{
 		$Formato=$db_path."copies/pfts/".$lang_db."/" .$Formato;
    }
    $formato="@".$Formato;
	$query = "&base=copies&cipar=$db_path"."par/copies.par&count=99999&Opcion=autoridades"."&prefijo=$from&to=$to"."&formato_e=$formato";
	$contenido=array();
	include("../common/wxis_llamar.php");
	$nc=$contenido;
	foreach ($nc as $value){
		$v=explode('|',$value);
		$Prefijo="CN_";
		$base=trim($v[0]);
		$cipar=$base.".par";
		$contenido=BuscarClasificacion($v[0],$fe_classification,$Prefijo,$v[1],$v[1].".par");
    	foreach ($contenido as $code){
    		ImprimirBarCode($code,$v[2],$output);
		}


	}
}


function ControlBarCode($base,$from,$to,$fe_control,$copies,$pref_control,$output){
global $db_path,$lang_db,$xWxis,$Wxis,$fe_classification;
	$base=$base;
	$cipar=$base.".par";
	$IsisScript= $xWxis."ifp.xis";
	$ver="";
	//while (strlen($from)<7) $from="0".$from;
	//while (strlen($to)<7) $to="0".$to;
	$from="CNS_".$base."_".$from;
	$to="CNS_".$base."_".$to."ZZZZZ";
	$Formato="barcode.pft";
	if (file_exists($db_path."copies/pfts/".$_SESSION["lang"]."/" .$Formato)){
 		$Formato=$db_path."copies/pfts/".$_SESSION["lang"]."/" .$Formato;
 	}else{
 		$Formato=$db_path."copies/pfts/".$lang_db."/" .$Formato;
    }
    $formato="@".$Formato;
	$query = "&base=copies&cipar=$db_path"."par/copies.par&count=99999&Opcion=autoridades"."&prefijo=$from&to=$to"." "."&formato_e=$formato";
	$contenido=array();
	include("../common/wxis_llamar.php");
	$nc=$contenido;
	foreach ($nc as $value){		$v=explode('|',$value);
		$Prefijo="CN_";
		$base=trim($v[0]);
		$cipar=$base.".par";
		$contenido=BuscarClasificacion($v[0],$fe_classification,$Prefijo,$v[1],$v[1].".par");
    	foreach ($contenido as $code){
    		ImprimirBarCode($code,$v[2],$output);
    	}
	}
}


function ClasificacionBarCode($base,$from,$to,$fe_classification,$copies,$pref_control,$output){
global $db_path,$lang_db,$xWxis,$Wxis;
	$base=$base;
	$cipar=$base.".par";
	$IsisScript= $xWxis."ifp.xis";
	$ver="";
	if (substr($fe_classification,0,1)=="@")
		$Formato=substr($fe_classification,1);
	else
		$Formato=$fe_classification;
	if (file_exists($db_path.$base."/pfts/".$_SESSION["lang"]."/" .$Formato)){
 		$Formato=$db_path.$base."/pfts/".$_SESSION["lang"]."/" .$Formato;
 	}else{
 		$Formato=$db_path.$base."/pfts/".$lang_db."/" .$Formato;
    }
    $fe=file($Formato);
    $fe=implode("\n",$fe);
	$formato=urlencode(trim($fe).'`|`v2/' );
	$query = "&base=".$base."&cipar=$db_path"."par/".$cipar."&Formato="."&count=99999&Opcion=autoridades"."&prefijo=ST_".$from."&to=ST_".$to."zzzzz"."&formato_e=$formato";
	$contenido=array();
	include("../common/wxis_llamar.php");
	$nc=$contenido;
	$IsisScript=$xWxis."buscar.xis";
   	if (file_exists($db_path."copies/pfts/".$_SESSION["lang"]."/barcode.pft")){
			$Formato=$db_path."copies/pfts/".$_SESSION["lang"]."/barcode";
 	}else{
 		$Formato=$db_path."copies/pfts/".$lang_db."/barcode";
    }
    foreach ($nc as $value){
		$v=explode('|',$value);
		$Expresion="CN_".$base."_".$v[1];
	    $query = "&Opcion=buscar&base=copies&cipar=$db_path"."par/copies.par&count=99999&Formato=$Formato&Expresion=".$Expresion."&prologo=NNN&epilogo=NNN";
		include("../common/wxis_llamar.php");
		foreach ($contenido as $barcode){			$bar=explode('|',$barcode);
			ImprimirBarCode($v[0],$bar[2],$output);
		}

	}
}


function MfnBarCode($base,$from,$to,$fe_classification,$copies,$pref_control,$output){
global $db_path,$lang_db;
	$base_bib=$base;
	$cipar_bib=$base.".par";
	if ($copies=="Y"){		$base="copies";
		$cipar="copies.par";	}else{		$cipar=$base.".par";	}	$Opcion="leer";
	$login="xx";
	$password="xx";
	$Formato="barcode";
	$contenido=LeerRegistro($base,$cipar,$from,$to,$Opcion,$Formato,$copies,$pref_control);
	foreach ($contenido as $value){		$value=trim($value);
		if ($value!="") {			$v=explode('|',$value);
			$v[0]=trim($v[0]);
			if ($v[0]!=""){
				$base_bib=$v[1];
				$cipar_bib=$v[1].".par";
				$pref_control="CN_";
				if (substr($fe_classification,0,1)=="@")  $fe_classification=substr($fe_classification,1);				$clas=BuscarClasificacion($v[0],$fe_classification,$pref_control,$base_bib,$cipar_bib);
				foreach ($clas as $nc){					if (trim($nc)!=""){						ImprimirBarCode($nc,$v[2],$output);
					}				}			}		}	}
}

if ($arrHttp["output"]=="display"){
	echo "<html><body>";
}
switch ($arrHttp["Opcion"]){	case "mfn":
		MfnBarCode($arrHttp["base"],$arrHttp["mfn_from"],$arrHttp["mfn_to"],$fe_classification,$copies,$pref_control,$arrHttp["output"]);
		break;
	case "clasificacion":
		ClasificacionBarCode($arrHttp["base"],$arrHttp["classification_from"],$arrHttp["classification_to"],$fe_classification,$copies,$pref_control,$arrHttp["output"]);
    	break;
    case "control":
    	ControlBarCode($arrHttp["base"],$arrHttp["control_from"],$arrHttp["control_to"],$fe_control,$copies,$pref_control,$arrHttp["output"]);
    	break;
    case "inventario":
    	InventarioBarCode($arrHttp["base"],$arrHttp["inventory_from"],$arrHttp["inventory_to"],$fe_control,$copies,$pref_inventory,$arrHttp["output"]);
		break;
	case "date":
    	DateBarCode($arrHttp["base"],$arrHttp["date_from"],$arrHttp["date_to"],$fe_date,$copies,$pref_date,$arrHttp["output"]);
		break;

}
if ($arrHttp["output"]=="display"){
	echo "</body></html>";
}
?>
