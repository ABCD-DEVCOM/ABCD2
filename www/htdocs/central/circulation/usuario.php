<?php
session_start();
// rutina para almacenar los préstamos otorgados,las renovaciones y las devoluciones
if (!isset($_SESSION["login"])) die;
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
include("../config_loans.php");
$lang=$_SESSION["lang"];
include("../lang/prestamo.php");
// se lee la configuración local
include("locales_read.php");
// se leen las politicas de préstamo
include("loanobjects_read.php");
// se lee la configuración de la base de datos de usuarios
include("borrowers_configure_read.php");

$valortag = Array();
//foreach ($arrHttp as $var => $value) echo "$var = $value<br>";

include ('../dataentry/leerregistroisispft.php');
include("../common/header.php");

Function Iso2Fecha($fecha){
	$f=substr($fecha,6,2)."/".substr($fecha,4,2)."/".substr($fecha,0,4);
	return $f;
}

// ------------------------------------------------------
include("../common/header.php");
 	include("../common/institutional_info.php");


echo "<body>";
?>
<div class="sectionInfo">
	<div class="breadcrumb">
		<?php echo $msgstr["statment"]?>
	</div>
	<div class="actions">
		<a href="javascript:self.close()" class="defaultButton backButton">
		<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
		<span><strong><?php echo $msgstr["back"]?></strong></span>
		</a>
	</div>
	<div class="spacer">&#160;</div>
</div>

<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/prestamo_procesar.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
		echo "        		<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/prestamo_procesar.html target=_blank>".$msgstr["edhlp"]."</a>";
  echo "<font color=white>&nbsp; &nbsp; Script: usuario.php</font>\n";
?>
	</div>
<div class="middle form">
	<div class="formContent">
<form name=ecta>
<?php
$ec_output="";
include("ec_include.php");  //se incluye el procedimiento para leer el usuario y los préstamos pendientes
echo $ec_output;
?>
</div></div>
<?php include("../common/footer.php");?>
</body>
</html>