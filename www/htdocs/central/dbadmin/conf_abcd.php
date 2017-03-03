<?php
///////////////////////////////////////////////////////////////////////////////
//
//  MODIFICA LA CONFIGURACIÓN DE LA BASE DE DATOS
//
///////////////////////////////////////////////////////////////////////////////

session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"]="en";
$lang=$_SESSION["lang"];
include("../common/get_post.php");
include("../config.php");

// ARCHIVOS DE LENGUAJE
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../lang/prestamo.php");

// VERIFICACION DE LA PERMISOLOTIA
if (isset($_SESSION["permiso"]["CENTRAL_ALL"])){}else{	echo "<h2>".$msgstr["invalidright"]. " ".$base;	die;}



// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILO
include("../common/header.php");

// INCLUSION DE LOS SCRIPTS
?>
<script src=../dataentry/js/lr_trim.js></script>
<script languaje=javascript>

function Update(Option){

	document.update_base.submit()
}

</script>
<body>
<div id="loading">
  <img id="loading-image" src="../dataentry/img/preloader.gif" alt="Loading..." />
</div>
<?php
// ENCABEZAMIENTO DE LA PÁGINA

include("../common/institutional_info.php");
$encabezado="&encabezado=s";
echo "
	<div class=\"sectionInfo\">
			<div class=\"breadcrumb\">".
				$msgstr["configure"]. " ABCD
			</div>
			<div class=\"actions\">

	";
echo "<a href=\"../common/inicio.php?reinicio=s\" class=\"defaultButton backButton\">";
echo "
					<img src=\"../images/defaultButton_iconBorder.gif\" alt=\"\" title=\"\" />
					<span><strong>". $msgstr["back"]."</strong></span>
				</a>";
echo "			</div>
			<div class=\"spacer\">&#160;</div>
	</div>";


// AYUDA EN CONTEXTO E IDENTIFICACIÓN DEL SCRIPT QUE SE ESTÁ EJECUTANDO
// OPCIONES DEL MENU
 ?>
<div class="helper">
<a href=../documentacion/ayuda.php?help=<?php echo $_SESSION["lang"]?>/admin.html target=_blank><?php echo $msgstr["help"]?></a>&nbsp &nbsp;
<?php
if (isset($_SESSION["permiso"]["CENTRAL_EDHLPSYS"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]))
	echo "<a href=../documentacion/edit.php?archivo=".$_SESSION["lang"]."/admin.html target=_blank>".$msgstr["edhlp"]."</a>";
echo "&nbsp; &nbsp; <a href=http://abcdwiki.net/wiki/es/index.php?title=Modificar_definici%C3%B3n_base_de_datos target=_blank>abcdwiki.net</a>";
echo "<font color=white>&nbsp; &nbsp; Script: dbadmin/menu_modificardb.php";
?>
</font>
	</div>
 <div class="middle form">
			<div class="formContent">
</center>
<table width=400 align=center>
	<tr>
		<td>
			<form name=update_base onSubmit="return false" method=post>
			<input type=hidden name=Opcion value=update>
			<input type=hidden name=type value="">
			<input type=hidden name=modulo>
			<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";?>
            <br>
            <ul style="font-size:12px;line-height:20px">
            <?php if ($_SESSION["profile"]=="adm"){
				echo "<li><a href=../dbadmin/editar_abcd_def.php?Opcion=abcd_def>abcd.def</a></li>";
				echo "<li><a href=../dbadmin/databases_list.php>". $msgstr["dblist"]."</a></li>";
				echo "<li><a href=../dbadmin/editar_correo_ini.php>correo.ini</a></li>";
			}
			?>
            </ol>
			</form>
		</td>
</table>
<br>
</div>
</div>
<?php
// PIE DE PÁGINA
include("../common/footer.php");
?>
</body>
</html>
