<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];



include("../lang/admin.php");
include("../lang/dbadmin.php");
include("../lang/soporte.php");
include("../common/header.php");
if (isset($arrHttp["encabezado"])) {
	include("../common/institutional_info.php");
	$encabezado="&encabezado=s";
}else{	$encabezado="";}

	echo " <body>
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">"."<h5>".
				$msgstr["tradyudas"]."</h5>
			</div>
			<div class=\"actions\">

	";
echo "<a href=\"menu_traducir.php?$encabezado\" class=\"defaultButton backButton\">";
echo "
	<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
	<span><strong>". $msgstr["back"]."</strong></span>
	</a>";
echo "			</div>
			<div class=\"spacer\">&#160;</div>
	</div>";

 ?>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/trad_ayudas.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/trad_ayudas.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "<font color=white>&nbsp; &nbsp; Script: trad_ayudas_utils.php";
?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">
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
<body>
<?
echo "<table border=0>";
echo "<tr><td colspan=3><h3>".$msgstr["mantenimiento"]."</h3></td>";
echo "<tr><td width=50>".$msgstr["vistap"]."</td><td>". $msgstr["editar"]."</td><td></td>";
echo "<tr>
	   	<td>
	   		<a href='javascript:AbrirVentana(\"mantenimiento.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"mantenimiento.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
		<td bgcolor=white>".$msgstr["mantenimiento"]."</td>";
	echo "

	</table>";

echo "</center></div></div>";
include("../common/footer.php");
?>
</body>
</html>