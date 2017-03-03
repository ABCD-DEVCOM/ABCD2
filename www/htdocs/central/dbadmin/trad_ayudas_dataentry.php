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
echo "<font color=white>&nbsp; &nbsp; Script: trad_ayudas_dataentry.php";
?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">
<?php
echo "<table border=0>";

echo "<tr><td colspan=3><h3>Menu</h3></td>";
echo "<tr><td>".$msgstr["vistap"]."</td><td>". $msgstr["editar"]."</td><td></td>";
echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"homepage.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"homepage.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>Menu</td>";


echo "<tr><td colspan=3><h3>".$msgstr["catalogacion"]."</h3></td>";
echo "<tr><td>".$msgstr["vistap"]."</td><td>". $msgstr["editar"]."</td><td></td>";
echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"inicio_base.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"inicio_base.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["seleccionar"]." ".$msgstr["database"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"dataentry_toolbar.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"dataentry_toolbar.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["toolbar"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"dataentry.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"dataentry.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["recedit"]."</td>";
echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"assist_sc.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"assist_sc.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["subc_asist"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"ayuda_captura.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"ayuda_captura.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["m_capturar"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"valdef.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"valdef.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["valdef"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"alfa.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"alfa.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["main_eindex"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"buscar.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"buscar.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["busqueda"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"diccionario.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"diccionario.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["termsdict"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"pft.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"pft.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["print"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"importiso.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"importiso.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["cnv_import"].": ".$msgstr["cnv_iso"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"txt2isis.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"txt2isis.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["cnv_import"].": ".$msgstr["cnv_txt"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"exportiso.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"exportiso.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["cnv_export"].": ".$msgstr["cnv_iso"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"exporttxt.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"exporttxt.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["cnv_export"].": ".$msgstr["cnv_txt"]."</td>";
echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"conversion_table.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"conversion_table.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>". $msgstr["cnv_import"]."/" .$msgstr["cnv_export"]." ".$msgstr["cnv_txt"]." - ".$msgstr["cnv_tab"]."</td>";
echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"cglobal.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"cglobal.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["mnt_globalc"]."</td>";

echo "<tr>
	   	<td width=50>
	   		<a href='javascript:AbrirVentana(\"mantenimiento.html\")'><img src=../dataentry/img/preview.gif alt=\"ver\" border=0></a></td>
	   	<td><a href='javascript:Edit(\"mantenimiento.html\")'><img src=../dataentry/img/barEdit.png border=0 alt=\"editar\"></a></td>
				<td bgcolor=white><dd>".  $msgstr["mantenimiento"]."</td>";


echo "</table>";
echo "</center></div></div>";
include("../common/footer.php");
?>
</body>
</html>