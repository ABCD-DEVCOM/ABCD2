<?php
/**
 * @program:   ABCD - ABCD-Central - http://reddes.bvsaude.org/projects/abcd
 * @copyright:  Copyright (C) 2009 BIREME/PAHO/WHO - VLIR/UOS
 * @file:      upload_html.php
 * @desc:
 * @author:    Guilda Ascencio
 * @since:     20091203
 * @version:   1.0
 *
 * == BEGIN LICENSE ==
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU Lesser General Public License as
 *    published by the Free Software Foundation, either version 3 of the
 *    License, or (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU Lesser General Public License for more details.
 *
 *    You should have received a copy of the GNU Lesser General Public License
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * == END LICENSE ==
*/
session_start();
include ("../config.php");
$lang="en";
include("../lang/admin.php");
include("../lang/soporte.php");
include("../common/get_post.php");
//foreach($arrHttp as $var=>$value) echo "$var=$value<br>";
$tag=173;                                                        // TAG TO STORE THE HTML
$tipo="B";
$input="/bases_abcd/bases/biblo/pdf/Contract_GA.pdf";           // PATH AND NAME OF THE PDF FILE TO BE CONVERTED
$output_html="/bases_abcd/bases/biblo/pdf/Contract_GA.html";    // PATH AND NAME OF THE FILE THAT STORES THE CONVERSION TO HTML
$database="/bases_abcd/bases/biblo/data/biblo";                 // PATH AND NAME OF THE DATABASE
echo $mx_path."pdftohtml.exe -noframes $input $output_html <br>";
$res=exec($mx_path."pdftohtml.exe -noframes $input $output_html  ",$contenido,$resultado);
if ($resultado==0){
	$s=explode("." ,$output_html);
	$ix=count($s)-1;
	$name=$s[0].".html";
}else{
	echo "no funcionó";
    die;
}
echo "<br>File size $name: ".filesize($output_html)." bytes<br>";
if (!file_exists($output_html)){	echo "$name Not created";
	die;}

if (filesize($output_html)>32000){	echo "<font color=red>File too big. Max=32K";
	die;}
// LOAD THE RECORD
	echo "COMMAND: ".$mx_path."mx null \"proc='Gload/$tag/nonl=$output_html'\" append=$database now -all count=1<P>";
	$res=exec($mx_path."mx null \"proc='Gload/$tag=$output_html'\" append=$database now -all count=1");
?>