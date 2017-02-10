<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include ("../common/get_post.php");
include("../config.php");
include("../lang/prestamo.php");
//foreach ($arrHttp as $var=>$value) echo "**$var=$value<br>";
$script_php="../output_circulation/rs01.php";
//die;



$IsisScript=$xWxis."eliminarregistro_busqueda.xis";
$Formato="";
$query = "&base=reserve&cipar=$db_path"."par/reserve.par&login=".$_SESSION["login"]."&Expresion=".$arrHttp["Expresion"];
include("../common/wxis_llamar.php");
//foreach ($contenido as $value) echo "****$value<br>";die;
?>
<form name=enviar method=post action="<?php echo $script_php?>">;
<?php foreach ($arrHttp as $var=>$value){	echo "<input type=hidden name=$var value=\"$value\">\n";}
?>
<script>
document.enviar.submit()
</script>