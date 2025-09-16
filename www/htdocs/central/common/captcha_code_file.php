<?php 
/*
* Code downloaded from
* https://html.form.guide/contact-form/html-contact-form-captcha/#codedownload
* That code is based on captcha code by Simon Jarvis 
* http://www.white-hat-web-design.co.uk/articles/php-captcha.php
*
* This program is free software; you can redistribute it and/or 
* modify it under the terms of the GNU General Public License 
* as published by the Free Software Foundation
*
* This program is distributed in the hope that it will be useful, 
* but WITHOUT ANY WARRANTY; without even the implied warranty of 
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
* GNU General Public License for more details: 
* http://www.gnu.org/licenses/gpl.html
*
* 20240530 fho4abcd Adapted for use in ABCD
* 20240604 fho4abcd No longer use imagettfbbox. Gave problems on some hosts. Unreliable.
* 20250916 fho4abcd Change allowed characters for better readability +
*                   Improve position of text +
*                   Add comment in this file to help with debug if image does not appear
* Note:
* Debug and showing errors with echo does not work as they are incapsulated by the HTML statement:
*   <img src="./central/common/captcha_code_file.php" id="captchaimg">
* Effect is that the image will not appear/is destroyed
* Use error_log in stead as this writes to the PHP error log.
*/
/*
** Sometimes the image box does not appear. Even if no debug echo's are present.
** This effect has been seen on servers with unix OS.
** Seems to be due to CRLF line-endings of this file. Change to LF solved the problem.
** Windows servers work fine with CRLF & LF.
** Unknown yet why this happens. The error is not reproducible
*/

session_start();
include("../config.php");
//Settings: You can customize the captcha here
$image_width = 150;
$image_height = 40;
$characters_on_image = 5;

// The absolute path to the font is required
// Font file is defined in function to make it also available for other scripts.
// Other scripts have to show errors as this file cannot show them (See debug remark)
include("captcha_get_font.php");
$font=captcha_font();

// The characters that can be used in the CAPTCHA code.
// Avoid confusing characters (l 1 and i for example)
$possible_letters = '23456789ABCDEFGHbcdfhjkmnprstvwxyz';
$random_dots = 20;
$random_lines = 20;
$captcha_text_color="0x142864";
$captcha_noise_color = "0x142864";// same as text to confuse robots thet may try to follow color

$code = '';//The textstring to be shown
$i = 0;
while ($i < $characters_on_image) { 
	$code .= substr($possible_letters, random_int(0, strlen($possible_letters)-1), 1);
	$i++;
}
$font_size = $image_height * 0.75;
$image = @imagecreate($image_width, $image_height);

/* setting the background, text and noise colours here */
$background_color = imagecolorallocate($image, 255, 255, 255);

$arr_text_color = hexrgb($captcha_text_color);
$text_color = imagecolorallocate($image, $arr_text_color['red'], 
		$arr_text_color['green'], $arr_text_color['blue']);

$arr_noise_color = hexrgb($captcha_noise_color);
$image_noise_color = imagecolorallocate($image, $arr_noise_color['red'], 
		$arr_noise_color['green'], $arr_noise_color['blue']);

/* generating the dots randomly in background */
for( $i=0; $i<$random_dots; $i++ ) {
	imagefilledellipse($image, mt_rand(0,$image_width),mt_rand(0,$image_height), 2, 3, $image_noise_color);
}

/* generating lines randomly in background of image */
for( $i=0; $i<$random_lines; $i++ ) {
	imageline($image, random_int(0,$image_width), random_int(0,$image_height),random_int(0,$image_width), random_int(0,$image_height), $image_noise_color);
}
/* create a text box and add some letters code in it*/
/*
$textbox = imagettfbbox($font_size, 0, $font, $code); 
$x = ($image_width - $textbox[4])/2;
$y = ($image_height - $textbox[5])/2;
This imagettfbbox fails for unknown reasons, so we use fixed positions as alternative
*/
$x=5;  // basepoint of first character
$y=35; // position of the fonts baseline, not the very bottom of the character. Higher values move down....

//error_log("font=".$font.", code=".$code.", fontsize=".$font_size.", x=".$x.", y=".$y,0);
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font , $code);

/* Show captcha image in the html page */
header('Content-Type: image/jpeg');// defining the image type to be shown in browser window
imagejpeg($image);                 //showing the image
imagedestroy($image);              //destroying the image instance

$_SESSION['6_letters_code'] = $code;

function hexrgb ($hexstr)
{
  $int = hexdec($hexstr);
  return array("red" => 0xFF & ($int >> 0x10),
               "green" => 0xFF & ($int >> 0x8),
               "blue" => 0xFF & $int);
}
?>