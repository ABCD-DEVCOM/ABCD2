<?php

// Globales.
//set_time_limit (0);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include ("../config.php");
include("../lang/dbadmin.php");
include("../lang/prestamo.php");
//echo $wxisUrl;

function InicializarBd($base){
global $xWxis,$wxisUrl,$db_path,$Wxis,$msgstr;
 	$query = "&base=".$base."&cipar=$db_path"."par/$base".".par&Opcion=inicializar";
 	$IsisScript=$xWxis."administrar.xis";
 	include("../common/wxis_llamar.php");
	foreach ($contenido as $linea){
	 	if ($linea=="OK"){	 		echo "<h4>".$base." ".$msgstr["init"]."</h4>";	 	}
 	}
}

include("../common/header.php");
echo "<body>\n";
if (isset($arrHttp["encabezado"])){
	include("../common/institutional_info.php");
?>
<div class="sectionInfo">

			<div class="breadcrumb">
				<?php echo "<h5>".$msgstr["init_trans"]."</h5>"?>
			</div>

			<div class="actions">
<?php echo "<a href=\"../common/inicio.php?reinicio=s&encabezado=s\" class=\"defaultButton backButton\">";
?>
					<img src="../images/defaultButton_iconBorder.gif" alt="" title="" />
					<span><strong><?php echo $msgstr["back"]?></strong></span>
				</a>
			</div>
			<div class="spacer">&#160;</div>
</div>
<?php }
echo "
<div class=\"middle form\">
			<div class=\"formContent\">
";
echo "<font size=1> &nbsp; &nbsp; Script: dbadmin/initialize_trans.php</font><br>";
$base[]="trans";
$base[]="suspml";
$base[]="reserve";
foreach ($base as $bd){
    if (!file_exists($db_path.$bd)){    	echo "<h3>".$db_path.$bd.": ".$msgstr["folderne"]."</h3>";
    	continue;    }
    if (!file_exists($db_path."par/".$bd.".par")){
    	echo "<h3>".$db_path."par/".$bd.".par: ".$msgstr["ne"]."</h3>";
    	continue;
    }
    $arrHttp["IsisScript"]="administrar.xis";
	InicializarBd($bd);

}
echo "</div></div>";
include("../common/footer.php");
echo "</body></html>";
die;
?>
