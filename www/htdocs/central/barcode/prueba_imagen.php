<?php
include('../Classes/PHPExcel.php');
$sheetIndex=-1;
$cols=array(" ","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
$gdImage = imagecreatefrompng('barcode_draw.php?text=0001');
$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWidth(300);
        $objDrawing->setHeight(38);

        $objDrawing->getActiveSheet()->setCellValue('A1', '                  ');
        $objDrawing->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objDrawing->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte de distribución.xls"');
header('Content-Charset: utf-8');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objDrawing, 'Excel5');
$objWriter->save('php://output');
?>

</body>

</html>