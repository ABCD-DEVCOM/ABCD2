<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];

include("../lang/prestamo.php");
include("../lang/admin.php");

include("../common/header_display.php");

?>

<script>

</script>
<?php
echo "<body>\n";
if (!isset($arrHttp["usuario"]) or trim($arrHttp["usuario"])==""){
	echo "<h1>".$msgstr["falta"]." ".$msgstr["usercode"]."</h1>";
	echo "</body></html>" ;
	die;
}
include("leer_pft.php");
// se lee la configuración de la base de datos de usuarios
include("borrowers_configure_read.php");
$Expresion=$uskey.trim($arrHttp["usuario"]);
$IsisScript=$xWxis."buscar.xis";
$arrHttp["base"]="users";
$arrHttp["cipar"]="users.par";
$arrHttp["Opcion"]="buscar";
$Formato=$db_path."trans/pfts/".$_SESSION["lang"]."/r_solvency";
$query = "&cipar=$db_path"."par/".$arrHttp["cipar"]. "&Expresion=$Expresion&Opcion=".$arrHttp["Opcion"]."&base=" .$arrHttp["base"]."&Formato=$Formato&prologo=NNN";
include("../common/wxis_llamar.php");
foreach ($contenido as $value){	echo "$value<br>";}

echo "</body></html>" ;

?>
<script>self.print()</script>