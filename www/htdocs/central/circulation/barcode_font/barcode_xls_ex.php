<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../config.php");

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

$base=$arrHttp["base"];
$parms=array();
if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/barcode_label.tab")){
	$fp=file($db_path.$base."/def/".$_SESSION["lang"]."/barcode_label.tab");
	foreach ($fp as $linea){
		$linea=trim($linea);
		$l=explode('=',$linea);
		$parms[$l[0]]=$l[1];
	}

}else{
	echo "<h1>Falta la tabla $base/def/".$_SESSION["lang"]."/barcode_label.tab</h1>";
	die;
}
$Formato=$parms["formato"];
$ix=stripos($Formato,".pft");
if ($ix!==false)
	$Formato=substr($Formato,0,$ix);
$desde=$arrHttp["desde"];
$hasta=$arrHttp["hasta"];
include('../Classes/PHPExcel.php');
$objPHPExcel = new PHPExcel();
$sheetIndex=-1;
$cols_array=array(" ","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex(0);

$cols=$parms["cols"];
$ixcol=$cols+99;
$ixrow=0;
$code_size=trim(strlen($desde));
for ($ix=1;$ix<=$cols;$ix++){
	$letra=$cols_array[$ix];	$objPHPExcel->getActiveSheet()->getColumnDimension($letra)->setWidth($parms["width"]*37.795275591);}
$base=$arrHttp["base"];
$cipar=$base.".par";

$contenido=LeerRegistro($base,$cipar,$desde,$hasta,"leer",$Formato);
foreach ($contenido as $value){
	echo "$value<br>";
	continue;
	if (trim($value)!=""){
		if ($ixcol>=$cols){
			$ixcol=0;
			$ixrow=$ixrow+1;
			$objPHPExcel->getActiveSheet()->getRowDimension($ixrow)->setRowHeight($parms["height"]*37.795275591);
		}
        $l=explode('|',$value);
	//$ix_formatted=str_pad ( $ix , $code_size , "0" , STR_PAD_LEFT );
	//echo "<td class=td align=center><img src=barcode_draw.php?text=$ix_formatted></td>";
		$ixcol=$ixcol+1;
		$celda=$cols_array[$ixcol].$ixrow;
        $val_celda=strip_tags($l[1]);
        $objPHPExcel->getActiveSheet()->getCell($celda)->setValueExplicit($val_celda, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setWrapText(true);
		$objPHPExcel->getActiveSheet()->getStyle($celda)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle($celda)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle($celda)->getFont()->setName('Bar Code 39 e HR')->setSize(42);

	}
}

die;
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte de distribución.xls"');
header('Content-Charset: utf-8');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>