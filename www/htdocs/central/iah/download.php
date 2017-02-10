<?php
include("configure.php");
if (!isset($arrHttp["base"]))  die;
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
$dbn=$arrHttp["base"];
$db_path=$config["DB_PATH"];
$IsisScript=$xWxis."leer_mfnrange.xis";
$Pft=urlencode($config["DOCUMENT_NAME"]);
$query="&base=$dbn&cipar=".$db_path."par/$dbn.par&from=".$arrHttp["mfn"]."&to=".$arrHttp["mfn"]."&Pft=$Pft";
include("../common/wxis_llamar.php");
$occ=$arrHttp["occ"]-1;
$document=$contenido[$occ];
if (isset($config["HTTP_ACCESS"]) and trim($config["HTTP_ACCESS"])!=""){
    header("Location: ".$config["HTTP_ACCESS"].$document);}else{
	$document=trim($document);	$filename=$document;
    $f_ext = pathinfo($filename, PATHINFO_EXTENSION); //gets extension of file
	switch ($f_ext) //known file types
	 {
	   case "jpg": $cont_type="image/jpeg"; break;
	   case "jpeg": $cont_type="image/jpeg"; break;
	   case "gif": $cont_type="image/gif"; break;
	   case "png": $cont_type="image/png"; break;
	   case "txt": $cont_type="text/plain"; break;
       case "html": $cont_type="text/html"; break;
       case "htm": $cont_type="text/html"; break;
       case "doc": $cont_type="application/msword; charset=windows-1252 ";break;
       case "exe": $cont_type="application/octet-stream";break;
       case "pdf": $cont_type="application/pdf;";break;
       case "ai": $cont_type="application/postscript";break;
       case "eps": $cont_type="application/postscript";break;
       case "ps": $cont_type="application/postscript";break;
       case "xls": $cont_type="application/vnd.ms-excel";break;
       case "ppt": $cont_type="application/vnd.ms-powerpoint";break;
       case "zip": $cont_type="application/zip";break;
       case "mid": $cont_type="audio/midi";break;
       case "kar": $cont_type="audio/midi";break;
       case "mp3": $cont_type="audio/mpeg";break;
       case "wav": $cont_type="audio/x-wav";break;
       case "bmp": $cont_type="image/bmp";break;
       case "tiff": $cont_type="image/tiff";break;
       case "tif": $cont_type="image/tiff";break;
       case "asc": $cont_type="text/plain";break;
       case "rtf": $cont_type="text/rtf; charset=windows-1252 ";break;
       case "mpeg": $cont_type="video/mpeg";break;
       case "mpg": $cont_type="video/mpeg";break;
       case "mpe": $cont_type="video/mpeg";break;
       case "avi": $cont_type="video/x-msvideo";break;

	 }
	$file=$config["FILE_ACCESS"].$document;
	//echo $file."***";
	//die;
	header("Content-Description: File Transfer");
	header("Content-type: $cont_type");
	header('Content-Disposition: inline; filename="'.$document.'"');

	@readfile($file);
}


?>
