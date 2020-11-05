<?php
	session_start();
    include("../common/get_post.php");
  	include("../config.php");
  	//foreach ($arrHttp as $var=>$value)  echo "$var=$value<br>";
  	//die;
  	if (file_exists($db_path.$arrHttp["base"]."/dr_path.def")){
		$def = parse_ini_file($db_path.$arrHttp["base"]."/dr_path.def");
		$img_path=trim($def["ROOT"]);
	}else{
		$img_path=getenv("DOCUMENT_ROOT")."/bases/".$arrHttp["base"]."/";
	}
  	$filename=$arrHttp["image"];
  	//$filename=strtolower($filename);// file name is changed to lowercase
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
       case "xlsx": $cont_type="application/vnd.ms-excel";break;
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
	$img=$img_path.$arrHttp["image"];
	if (!file_exists($img)){		echo $img." Not found";
		die;	}
	header("Content-type: $cont_type");
	header('Content-Disposition: inline; filename="'.$img.'"');

  	//if (!file_exists($img)){  	///	$img=$img_path."/noimage.jpg";  	//}
  	$img=file($img);
	$imagen="";
	foreach ($img as $value)  $imagen.=$value;
    print $imagen;

?>