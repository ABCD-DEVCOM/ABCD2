<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include ("../config.php");
$lang=$_SESSION["lang"];
include("../lang/prestamo.php");
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");

include("../common/header.php");
?>
<script languaje=javascript>
function AbrirVentana(Html){
	msgwin=window.open("../documentacion/ayuda.php?help=<?php echo $lang?>/"+Html,"Ayuda","")
	msgwin.focus()
}
function Edit(Html){
	msgwin=window.open("../documentacion/edit.php?archivo=<?php echo $lang?>/"+Html,"Ayuda","")
	msgwin.focus()
}
</script>
<?php
$encabezado="";
echo "<body>\n";
include("../common/institutional_info.php");
echo "
	<div class=\"sectionInfo\">
	<div class=\"breadcrumb\">".
	$msgstr["usrmanual"]."
	</div>
	<div class=\"actions\">\n";
if (isset($arrHttp["encabezado"])){
	echo "<a href=\"../common/inicio.php?reinicio=s";
	if (isset($arrHttp["base"]))echo "&base=".$arrHttp["base"];
	echo "\" class=\"defaultButton backButton\">
		<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
		<span><strong>". $msgstr["back"]."</strong></span>
		</a>
	";
}
echo "</div>
			<div class=\"spacer\">&#160;</div>
		</div>";
?>
<div class="helper">
<?php echo "<font color=white>&nbsp; &nbsp; Script: menu_traducir.php" ?></font>
	</div>
<div class="middle homepage">

	<div class="mainBox" onmouseover="this.className = 'mainBox mainBoxHighlighted';" onmouseout="this.className = 'mainBox';">
		<div class="boxTop">
			<div class="btLeft">&#160;</div>
			<div class="btRight">&#160;</div>
		</div>
		<div class="boxContent titleSection">
<?php
echo "<br><h4>".$msgstr["catalogacion"]."</h4>";
echo "    <a href='javascript:AbrirVentana(\"dataentry_toolbar.html\")'>".  $msgstr["recedit"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"dataentry.html\")'>".  $msgstr["fmt"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"assist_sc.html\")'>".  $msgstr["subc_asist"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"ayuda_captura.html\")'>".  $msgstr["m_capturar"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"valdef.html\")'>".  $msgstr["valdef"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"pft.html\")'>".  $msgstr["print"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"importiso.html\")'>".  $msgstr["cnv_import"].": ".$msgstr["cnv_iso"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"txt2isis.html\")'>".  $msgstr["cnv_import"].": ".$msgstr["cnv_txt"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"exportiso.html\")'>".  $msgstr["cnv_export"].": ".$msgstr["cnv_iso"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"exporttxt.html\")'>".  $msgstr["cnv_export"].": ".$msgstr["cnv_txt"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"cglobal.html\")'>".  $msgstr["mnt_globalc"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"mantenimiento.html\")'>".  $msgstr["mantenimiento"]."</a>";
///
echo "<P>";
echo "<h4>".$msgstr["admtit"]."</h4>";
echo "<br><a href='javascript:AbrirVentana(\"homepage.html\")'>".$msgstr["inicio"]." ".$msgstr["admtit"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"toolbar_admin.html\")'>".$msgstr["database"].": ".$msgstr["admtit"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"admin.html\")'>".$msgstr["createdb"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"upddef.html\")'>".$msgstr["updbdef"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"fdt.html\")'>".$msgstr["fdt"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"picklist_tab.html\")'>".$msgstr["termctrl"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"typeofrecs_marc.html\")'>".$msgstr["typeofrecords"]." (Marc)</a>";
echo "<br><a href='javascript:AbrirVentana(\"fst.html\")'>".$msgstr["fst"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"fmt.html\")'>".$msgstr["fmt"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"pft.html\")'>".$msgstr["pft"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"typeofrecs.html\")'>".$msgstr["typeofrecords"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"recval.html\")'>".$msgstr["recval"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"asearch_schema.html\")'>". $msgstr["advsearch"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"databases_list.html\")'>". $msgstr["dblist"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"dbnpar.html\")'>". $msgstr["dbnpar"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"helpfilesdb.html\")'>".  $msgstr["helpdatabasefields"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"iah_edit_db.html\")'>".  $msgstr["iah-conf"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"assign_operators.html\")'>".  $msgstr["assop"]."</a>
	  <br><a href='javascript:AbrirVentana(\"browse.html\")'>".  $msgstr["usuarios"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"menu_mantenimiento.html\")'>".  $msgstr["mantenimiento"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"dirtree.html\")'>". $msgstr["expbases"]."</a>";
echo "<h4>".$msgstr["translate"]."</h4>";
echo "    <a href='javascript:AbrirVentana(\"menu_traducir.html\")'>".  $msgstr["traducir"]."</a>";
echo "<br><a href='javascript:AbrirVentana(\"trad_ayudas.html\")'>".  $msgstr["tradyudas"]."</a>";

//
echo "<p><h4>".$msgstr["mantenimiento"]."</h4>";
echo "<a href='javascript:AbrirVentana(\"mantenimiento.html\")'>".$msgstr["mantenimiento"]."</a>";

echo "<p>";


?>
			</div>
			<div class="spacer">&#160;</div>
		</div>
		<div class="boxBottom">
			<div class="bbLeft">&#160;</div>
			<div class="bbRight">&#160;</div>
		</div>
	</div>
<form name=admin method=post action=administrar_ex.php onSubmit="Javascript:return false">
<input type=hidden name=base>
<input type=hidden name=cipar>
<input type=hidden name=Opcion>
</form>
</div>
<?php include("../common/footer.php");?>

</body>
</html>
