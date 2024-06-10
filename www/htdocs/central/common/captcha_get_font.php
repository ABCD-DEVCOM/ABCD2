<?php
/*
** This file defines the font for the captcha.
** Generates a better error in the php error log as the functions imagettfbbox/imagettftext in captcha_code_file.php
** Shows also an error as html if used in an html generating file (e.g. index.php)
**
20240602 fho4abcd Created
20240610 fho4abcd Check also extension gd.
*/
function captcha_font() {
	$font=$_SERVER['DOCUMENT_ROOT'].'/assets/webfonts/first_school.ttf';
	if (!file_exists($font)){
		$message="Captcha font file: ".$font." does not exist";
		echo "<div style='color:red'>".$message."</div>";
		error_log($message);
		die;
	}
	if (!extension_loaded('gd')&&!extension_loaded('gd2')) {
		$message="Load required PHP extension 'gd' (or equivalent gd2/gd.so/....)";
		echo "<div style='color:red'>".$message."</div>";
		error_log($message);
	}
	return $font;
}