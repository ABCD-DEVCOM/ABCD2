<?php

global $arrHttp;
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
unset($_SESSION["FDT"]);
unset($_SESSION["PFT"]);
unset($_SESSION["FST"]);
include("../common/get_post.php");
include ("../config.php");


include ("../lang/dbadmin.php");
include ("../lang/soporte.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>";
include("../common/header.php");
echo "<script  src=\"../dataentry/js/lr_trim.js\"></script>\n";
echo "<script languaje=javascript>
function EnviarForma(){	if (Trim(document.winisis.userfile.value)==''){		alert('".$msgstr["missing"]." ".$msgstr["fdt"]."')
		return	}
	ext=document.winisis.userfile.value
	e=ext.split(\".\")
	if (e.length==1 || e[1].toUpperCase()!=\"FDT\"){		alert('".$msgstr["missing"]." ".$msgstr["fdt"]."')
		return	}
	document.winisis.submit()}
</script>";
if (isset($arrHttp["encabezado"]))	include("../common/institutional_info.php");
echo "
	<div class=\"sectionInfo\">

			<div class=\"breadcrumb\"><h5>".
				$msgstr["winisisdb"].": " . $arrHttp["nombre"]."</h5>
			</div>

			<div class=\"actions\">
	";
if (isset($arrHttp["encabezado"]))
		$encabezado="?encabezado=s";
	else
		$encabezado="";
echo "<a href=menu_creardb.php$encabezado class=\"defaultButton backButton\">";

echo "
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>
			</div>
			<div class=\"spacer\">&#160;</div>
	</div>";

echo "
	<div class=\"helper\">
	<a href=../documentacion/ayuda.php?help=".$_SESSION["lang"]."/crearbd_winisis_create.html target=_blank>".$msgstr["help"]."</a>&nbsp &nbsp;";
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=". $_SESSION["lang"]."/crearbd_winisis_create.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: winisis.php</font></div>";

echo "
<div class=\"middle form\">
			<div class=\"formContent\">";
echo "<br><br>

<form name=winisis action=winisis_upload_fdt.php method=POST enctype=multipart/form-data onsubmit='javascript:EnviarForma();return false'>
<input type=hidden name=Opcion value=FDT>
<input type=hidden name=base value=".$arrHttp["nombre"].">
<input type=hidden name=desc value=\"".$arrHttp["desc"]."\"> ";
if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";
echo "<dd><table bgcolor=#eeeeee>
<tr>
<tr><td class=title>".$msgstr["subir"]." ".$arrHttp["nombre"]. ".fdt</td>

<tr><td><input name=userfile type=file size=50></td><td></td>
<tr><td>  <input type=submit value='".$msgstr["subir"]."'></td>
</table>
<p>
</div>
</div>";
include("../common/footer.php");

?>
