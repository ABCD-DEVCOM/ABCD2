<?php
session_start();
if (!isset($_SESSION["permiso"]["CENTRAL_ALL"])and !isset($_SESSION["permiso"]["CIRC_CIRCALL"]) ){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include ("../config.php");

$lang=$_SESSION["lang"];

include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../lang/prestamo.php");


//foreach ($arrHttp as $var=>$value) echo "$var = $value<br>";
include("../common/header.php");
include("../common/institutional_info.php");
?>

<body >
<?php
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["loantit"]. " " . $msgstr["basedatos"].": ".$msgstr["admtit"]."
			</div>
			<div class=\"actions\">
                <a href=\"menu_mantenimiento.php\" class=\"defaultButton backButton\">
                <img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	           <span><strong>". $msgstr["back"]."</strong></span></a>
            </div>
	       <div class=\"spacer\">&#160;</div>
	</div>";
?>
<div class="helper">
	<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/menu_mantenimiento.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
 	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/menu_mantenimiento.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: circulacion/bases_inicializar.php";
?>
</font>
</div>
<div class="middle form">
	<div class="formContent">
<?php
$bd=$arrHttp["base"];
$IsisScript=$xWxis."administrar.xis";
$query = "&base=".$bd."&cipar=$db_path"."par/".$bd.".par&Opcion=inicializar";
include("../common/wxis_llamar.php");
echo "<p>$bd :";
foreach ($contenido as $value) echo "$value<br>";?>
</div>
</div>
<?php include("../common/footer.php");?>
</body>
</html>
