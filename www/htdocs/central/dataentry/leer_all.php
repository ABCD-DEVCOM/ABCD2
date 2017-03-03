<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
?>
<html>
<body>
<font face="courier new">
<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
global $arrHttp,$xWxis;

// ==================================================================================================
// INICIO DEL PROGRAMA
// ==================================================================================================

//



include("../common/get_post.php");
include("../config.php");

//foreach ($arrHttp as $var => $value) 	echo "$var = $value<br>";

$IsisScript=$xWxis."leer_all.xis";
$query="&base=".$arrHttp["base"]."&cipar=".$db_path."par/".$arrHttp["cipar"]."&Mfn=".$arrHttp["Mfn"]."&count=1";
include("../common/wxis_llamar.php");
foreach ($contenido as $value) echo "$value";
 ?>
 </body>
 </html>