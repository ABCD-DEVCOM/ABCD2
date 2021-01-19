<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");


include("../lang/dbadmin.php");
include("../lang/soporte.php");

$lang=$_SESSION["lang"];


function CrearPft($Pft_w){
global $arrHttp,$msgstr;
	$ix=0;
	echo "<p><dd><span class=title>".$msgstr["subir"]." ".$arrHttp["base"].".pft"."</span>";
	$salida="";
	echo "<dd><table bgcolor=#FFFFFF>
		<td>";
	echo "<xmp>$Pft_w</xmp>";
	echo "</dd></table>";
	echo "<dd>" .$arrHttp["base"].".pft Uploaded!!";
	return $Pft_w;
}

include("../common/header.php");
if (isset($arrHttp["encabezado"]))
	include("../common/institutional_info.php");
echo "
	<div class=\"sectionInfo\">

			<div class=\"breadcrumb\"><h5>".
				$msgstr["winisisdb"].": " . $arrHttp["base"]."</h5>
			</div>

			<div class=\"actions\">
	";
if (isset($arrHttp["encabezado"]))
		$encabezado="&encabezado=s";
	else
		$encabezado="";
echo "<a href=winisis_upload_fst.php?base=".$arrHttp["base"]."&nombre=".$arrHttp["base"]."&desc=".urlencode($arrHttp["desc"]).$encabezado." class=\"defaultButton backButton\">";

echo "
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["cancel"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
	</div>";

echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/winisis_upload_pft.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/winisis_upload_pft.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: winisis_upload_pft.php</font></div>";

echo "
<div class=\"middle form\">
			<div class=\"formContent\">";

$files = $_FILES;
if ($files['userfile']['size']) {
      // clean up file name
      	$name=$files['userfile']["size"];
   		$name = ereg_replace("[^a-z0-9._]", "",
       	str_replace(" ", "_",
       	str_replace("%20", "_", strtolower($name)
   			)
      		)
        );
      	$fp=file($files['userfile']['tmp_name']);
       	$Pft="";
        foreach($fp as $linea) $Pft.=$linea;
        $Pft_conv=CrearPft($Pft);
}

$_SESSION["PFT"]=$Pft_conv;
echo "<P><dd><a href=menu_creardb.php?base=".$arrHttp["base"].">".$msgstr["cancel"]."</a> &nbsp; &nbsp;
	<a href=winisis_upload_fst.php?base=".$arrHttp["base"]."&nombre=".$arrHttp["base"]."&desc=".urlencode($arrHttp["desc"])."$encabezado>".$msgstr["back"]."</a> &nbsp; &nbsp; &nbsp; &nbsp;
	<a href=crearbd_new_create.php?base=".$arrHttp["base"]."$encabezado>".$msgstr["createdb"]."</a> &nbsp; &nbsp; &nbsp; &nbsp;
	";
echo "</div></div>\n";
include("../common/footer.php");
?>
