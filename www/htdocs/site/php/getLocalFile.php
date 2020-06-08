<?php
include("include.php");

$f = $_REQUEST['f'];

if ($f == '' || preg_match("/\.\./",$f) || preg_match("/\/$/",$f) ){
	die("404 - page not found" );
}

$filename = $def['DATABASE_PATH'] .'/local/' . $f;
$filename = realpath($filename);

if (!file_exists($filename)) {
	die("404 - page not found");
}

$file_extension = strtolower(substr(strrchr($filename,"."),1));

switch ($file_extension) {
	case "pdf": $ctype="application/pdf"; break;
	case "exe": $ctype="application/octet-stream"; break;
	case "zip": $ctype="application/zip"; break;
	case "doc": $ctype="application/msword"; break;
	case "xls": $ctype="application/vnd.ms-excel"; break;
	case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
	case "gif": $ctype="image/gif"; break;
	case "png": $ctype="image/png"; break;
	case "jpe": case "jpeg":
	case "jpg": $ctype="image/jpg"; break;
	case "htm":
	case "html":$ctype="text/html"; break;
	default: $ctype="application/force-download";
}

if ($ctype == 'text/html' || preg_match("/^image/",$ctype) ){
	header("Content-Type: $ctype");
	echo @readfile("$filename");
	die();
}

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Type: $ctype");
header("Content-Disposition: attachment; filename=\"".basename($filename)."\";");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".@filesize($filename));
set_time_limit(0);
@readfile("$filename") or die("File not found.");

?>
