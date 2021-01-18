<?php
set_time_limit(0);
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";//die;
include ("../config.php");

include ("../lang/admin.php");
include ("../lang/dbadmin.php");
include ("../lang/soporte.php");
include ("../lang/reports.php");

include ("configure.php");
$cm2em=2.37106301584;
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
		include('../Classes/PHPExcel.php');
		$objPHPExcel = new PHPExcel();
		$sheetIndex=-1;
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
   		break;
   	case "txt_print":
   	   	header('Content-Type: text/html;  charset=windows-1252');
   		header("Expires: 0");
   		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
   		header("Pragma: public");
   		break;
	default:
		break;
}

function MostrarSalida($contenido,$medio="",$bar_c){
global $arrHttp;
	if ($medio=="display" or $medio=="doc"){
		$table_width=$bar_c["cols"]*$bar_c["width"];
		if (isset($bar_c["cols"]) and $bar_c["cols"]>0){
			echo "<style>
			.columna{
    			border: 0px;
    			table-layout: fixed;
    			width: $table_width em;
			}

			.td1 {
    			border: 0px;
    			overflow: hidden;
    			width: ".$bar_c["width"]."em;
    			height: ".$bar_c["height"]."em;
			}
			</style>\n";
			echo "\n<table class=columna>\n<tr>";
		}else{
			$bar_c["cols"]=0;
		}
	}
	$ncols=0;
	$print="";
	foreach ($contenido as $value){
		$value=trim($value);
		if ($value!=""){
			$ix=strpos($value,"*INV*");
			if ($ix!==false){
				$ix1=strpos($value,"*INV*",$ix+2);
				if ($ix1!==false)
					$value=substr($value,0,$ix).substr($value,$ix1+5);
			}
			$salida=str_replace('!!!',PHP_EOL,$value);
			switch ($medio){
				case "txt":
					//echo utf8_encode($salida);
					echo $salida;
					break;
				case "txt_print":
					$print.=$salida;
					break;

				default:
					$ncols=$ncols+1;
					if ($ncols>$bar_c["cols"] and $bar_c["cols"]!=0){
						echo "</tr>\n<tr>";
						$ncols=1;
					}
					if ($bar_c["cols"]>0){
						$width=$bar_c["width"];
						$height=$bar_c["height"];
						echo "<td class=td1>$salida</td>\n";
					}else{
						echo $salida."<p>";
                    }
			}
		}
	}
	if (isset($bar_c["cols"]) and $bar_c["cols"]>0 and $medio!="txt" and $medio!="txt_print"){
		echo "</tr></table>";
	}
	if ($medio=="txt_print"){
	$salida=explode(PHP_EOL,$print);
	echo "<script>lineas=Array();i=-1;\n";
	foreach ($salida as $linea){
		echo "i=i+1\n";
		echo "lineas[i]=\"$linea\"\n";
	}
		?>
	msgwin=window.open("","recibo","width=400, height=300, scrollbars, resizable")
	for (j=0;j<=i;j++){
		msgwin.document.writeln(lineas[j])
	}
	msgwin.document.close()
	msgwin.focus()
	msgwin.print()
	msgwin.close()
	self.close();
</script>
<?php
	}
}


function MfnBarCode($base,$from,$to,$bar_c,$Pft){
global $xWxis,$msgstr,$db_path,$Wxis,$wxisUrl,$lang_db,$arrHttp;
	$base=$base;
	$cipar=$base.".par";
	$Opcion="leer";
	$login="xx";
	$password="xx";
	$IsisScript=$xWxis."leer_mfnrange.xis";
 	$query = "&base=$base&cipar=$db_path"."par/".$cipar. "&from=" . $from."&to=$to&Pft=$Pft";
 	//echo $Pft;
	include("../common/wxis_llamar.php");
    /*foreach ($contenido as $value){
    	 echo "***".$value;
    }
    die;  */
    $contenido=implode("!!!",$contenido);
	$contenido=explode('%%%',$contenido);
	MostrarSalida($contenido,$arrHttp["output"],$bar_c);

}
function InventarioLista($base,$lista,$bar_c,$Pft){
global $xWxis,$msgstr,$db_path,$Wxis,$wxisUrl,$lang_db,$arrHttp;
	$Expresion="";
	$inv=explode(",",$lista);
    $comp=array();
	foreach ($inv as $value){
		$value=trim($value);
		if ($value!=""){
			$comp[$value]=$value;
			if($Expresion==""){
				$Expresion=$bar_c["inventory_number_pref_list"].$value;
			}else{
				$Expresion.=" or ".$bar_c["inventory_number_pref_list"].$value;
			}
		}
	}
	$IsisScript=$xWxis."imprime.xis";
	$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Expresion=".urlencode($Expresion)."&Opcion=buscar&count=100&Pft=".urlencode($Pft);
	include("../common/wxis_llamar.php");
	$inventario=array();
	$array_c=array();
	$contenido=implode("!!!",$contenido);
	$contenido=explode('%%%',$contenido);
	foreach ($contenido as $value) {
		if (trim($value)!=""){
			foreach ($inv as $ni) {
				$ni=trim($ni);
				if (strpos($value,'*INV*'.$ni.'*INV')!==FALSE){
					if (!isset($inventario[$ni])){
						$inventario[$ni]=$ni;
						$array_c[]=$value;
					}else{

					}
				}
			}
		}
	}
	MostrarSalida($array_c,$arrHttp["output"],$bar_c);
}

function ClasificacionBarCode($base,$from,$to,$bar_c,$Pft){
global $arrHttp,$xWxis,$msgstr,$db_path,$Wxis,$wxisUrl,$lang_db;
    $Prefijo=trim($bar_c["classification_number_pref"]).trim($arrHttp["classification_from"]);
    $to=trim($bar_c["classification_number_pref"]).trim($arrHttp["classification_to"]);
	$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=diccionario&prefijo=".$Prefijo."&hasta=".$to."&Pft=".$Pft;
	$IsisScript=$xWxis."indice.xis";
	include("../common/wxis_llamar.php");
	$contenido=implode("!!!",$contenido);
	$contenido=explode('%%%',$contenido);
	MostrarSalida($contenido,$arrHttp["output"],$bar_c);
}

function InventarioBarCode($base,$from,$to,$bar_c,$Pft){
global $arrHttp,$xWxis,$msgstr,$db_path,$Wxis,$wxisUrl,$lang_db;
    $Prefijo=trim($bar_c["inventory_number_pref"]).trim($arrHttp["inventory_from"]);
    $to=trim($bar_c["inventory_number_pref"]).trim($arrHttp["inventory_to"])."ZZZ";
	$query = "&base=".$arrHttp["base"] ."&cipar=$db_path"."par/".$arrHttp["base"].".par&Opcion=diccionario&prefijo=".urlencode($Prefijo)."&hasta=".urlencode($to)."&Pft=".urlencode($Pft);
	$IsisScript=$xWxis."indice.xis";
	include("../common/wxis_llamar.php");
	$contenido=implode("!!!",$contenido);
	$contenido=explode('%%%',$contenido);
	foreach ($contenido as $value) {
		if (trim($value)!=""){
			$numeros="";
			$ix=strpos($value,"*INV*");
			if ($ix!==false){
				$ix1=strpos($value,"*INV*",$ix+1);
				$ni=substr($value,$ix+5,$ix1-$ix-5);
				if ($ni>=trim($arrHttp["inventory_from"]) and $ni<=trim($arrHttp["inventory_to"])){
					if (!isset($inventario[$ni])){
						$array_c[]=$value;
						$inventario[$ni]=$ni;
					}
				}
			}else{				$ni=$value;
				if (!isset($inventario[$ni])){
					$array_c[]=$value;
					$inventario[$ni]=$ni;
				}			}

		}
	}

	MostrarSalida($array_c,$arrHttp["output"],$bar_c);
}

if ($arrHttp["output"]=="display"){
	echo "<html><body>";
}

//SE LEE EL ARCHIVO DE CONFIGURACION
if (!file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/barcode.conf")){
	echo "<h4>".$msgstr["barcode_conf"]."</h4>";
	$err="Y";
}else{
	$err="";
}
if ($err!=""){
	echo "</div></div>";
	include("../common/footer.php");
	die;
}
$bar_c=array();
$fp=file($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".$arrHttp["tipo"].".conf");
if ($fp){
	foreach ($fp as $conf){
		$conf=trim($conf);
		if ($conf!=""){
			$a=explode('=',$conf,2);
			$bar_c[$a[0]]=$a[1];
		}
	}
}
//CONVERT CM TO EM
$bar_c["height"]=$bar_c["height"]*$cm2em;
$bar_c["width"]=$bar_c["width"]*$cm2em;

if ($arrHttp["output"]=="txt" or $arrHttp["output"]=="txt_print"){
	$bar_c["label_format"]=$bar_c["label_format_txt"];
	if (substr($bar_c["label_format"],0,1)=='@')
		$bar_c["label_format"]=",@".$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".substr($bar_c["label_format"],1).",";
}else{
	if (substr($bar_c["label_format"],0,1)=='@')
		$bar_c["label_format"]=",@".$db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/".substr($bar_c["label_format"],1).",";
}
switch ($arrHttp["tipo"]){
	case "barcode":
		$Pft=trim($bar_c["label_format"])."/";
		break;
	case "lomos":
		$Pft=trim($bar_c["label_format"])."/";
		break;
	case "etiquetas":
		$Pft=trim($bar_c["label_format"])."/";
		break;
}
switch ($arrHttp["Opcion"]){
	case "mfn":
		MfnBarCode($arrHttp["base"],$arrHttp["mfn_from"],$arrHttp["mfn_to"],$bar_c,$Pft);
		break;
	case "clasificacion":
		ClasificacionBarCode($arrHttp["base"],$arrHttp["classification_from"],$arrHttp["classification_to"],$bar_c,$Pft);
    	break;
    case "control":
    	//ControlBarCode($arrHttp["base"],$arrHttp["control_from"],$arrHttp["control_to"],$fe_control,$copies,$pref_control,$arrHttp["output"]);
    	break;
    case "inventario":
    	InventarioBarCode($arrHttp["base"],$arrHttp["inventory_from"],$arrHttp["inventory_to"],$bar_c,$Pft);
		break;
	case "date":
    	//DateBarCode($arrHttp["base"],$arrHttp["date_from"],$arrHttp["date_to"],$fe_date,$copies,$pref_date,$arrHttp["output"]);
		break;
	case "lista_inventario":
		InventarioLista($arrHttp["base"],$arrHttp["inventory_list"],$bar_c,$Pft);
		break;

}
if ($arrHttp["output"]=="display"){
	echo "</body></html>";
}

?>
