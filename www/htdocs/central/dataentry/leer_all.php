<?php
/* Modifications
20210623 fho4abcd Improve html:add header,replace placeholder iso characters
20220716 fho4abcd Use $actparfolder as location for .par files
*/

//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

include("../common/get_post.php");
include("../config.php");
include("../common/header.php");
?>
<body>
<div class="middle formContent">
<p><?php echo $charset;?></p>
<font face="courier new">
<?php
//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";

$IsisScript=$xWxis."leer_all.xis";
$query="&base=".$arrHttp["base"]."&cipar=".$db_path.$actparfolder.$arrHttp["cipar"]."&Mfn=".$arrHttp["Mfn"]."&count=1";
include("../common/wxis_llamar.php");
/*
** The code on Windows shows unfortunately ISO-8859-1 codes to mark the left and right side of the string
** following code mitigates this: shows html codes for arrows to mark the string
** It is assumed that the searchcodes appear only once in the strings. If not: improve the replace code
** This does not hurt the code on linux (shows correct delimiters)
*/
if ($charset=="ISO-8859-1") {
    $leftsrc=" ".chr(174); // space with iso-885-1 registered trademark symbol
    $rightsrc=chr(175)."<BR>"; //iso-885-1 macron + <BR>
} else {
    $leftsrc=" ".chr(194); // space with iso-885-1 Â
    $rightsrc=chr(194)."<BR>"; //iso-885-1 Â + <BR>
}
$leftrep=" &rArr;";
$rightrep="&lArr;<br>";
foreach ($contenido as $value){
    $value = str_replace($leftsrc,$leftrep,$value);
    $value = str_replace($rightsrc,$rightrep,$value);
    echo "$value";
}
?>
 </font>
 </div>
 </body>
 </html>