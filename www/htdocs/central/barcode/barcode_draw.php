<?php
session_start();
// Including all required classes
require_once('class/BCGFontFile.php');
require_once('class/BCGColor.php');
require_once('class/BCGDrawing.php');
$base=$_SESSION["base_barcode"];
$arrHttp["base"]=$base;
include("../config.php");
$parms=array();
if (file_exists($db_path.$base."/def/".$_SESSION["lang"]."/barcode_code.tab")){
	$fp=file($db_path.$base."/def/".$_SESSION["lang"]."/barcode_code.tab");
	foreach ($fp as $linea){		$linea=trim($linea);
		$l=explode('=',$linea);
		$parms[$l[0]]=$l[1];	}

}
// Including the barcode technology
$type=explode('.',$parms["type"]);
$type=$type[0].".barcode.php";
require_once('class/'.$type);

// Loading Font
$font = new BCGFontFile('./font/'.$parms["font_family"], $parms["font_size"]);

// Don't forget to sanitize user inputs
$text = isset($_REQUEST['text']) ? $_GET['text'] : 'HELLO';

// The arguments are R, G, B for color.
$color_black = new BCGColor(0, 0, 0);
$color_white = new BCGColor(255, 255, 255);

$drawException = null;
try {
	$code = new BCGcode39();
	$code->setScale($parms["scale"]); // Resolution
	$code->setThickness($parms["thickness"]); // Thickness
	$code->setForegroundColor($color_black); // Color of bars
	$code->setBackgroundColor($color_white); // Color of spaces
	$code->setFont($font); // Font (or 0)
	$code->parse($text); // Text
} catch(Exception $exception) {
	$drawException = $exception;
}

/* Here is the list of the arguments
1 - Filename (empty : display on screen)
2 - Background color */
$drawing = new BCGDrawing('', $color_white);
if($drawException) {
	$drawing->drawException($drawException);
} else {
	$drawing->setBarcode($code);
	$drawing->draw();
}

// Header that says it is an image (remove it if you save the barcode to a file)
header('Content-Type: image/png');
header('Content-Disposition: inline; filename="barcode.png"');

// Draw (or save) the image into PNG format.
$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
?>