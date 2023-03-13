<?php
/* Modifications
20210615 fho4abcd Removed opac configuration.Not working and not in line with wiki OPAC-ABCD Configuration Tutorial
20210615 fho4abcd Improve html, cleanup code, lineends
20211216 fho4abcd Backbutton by included file
*/

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
include("../lang/dbadmin.php");
include("../lang/prestamo.php");

// VERIFICACION DE LA PERMISOLOTIA
if (isset($_SESSION["permiso"]["CENTRAL_ALL"])){

}else{
	echo "<h2>".$msgstr["invalidright"]. " ".$base;
	die;
}



// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILO
include("../common/header.php");

// INCLUSION DE LOS SCRIPTS
?>
<body>
<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
<script language="JavaScript">

function Ejecutar(Script,Opcion){
	document.forma1.action=Script
	if (Opcion!="")
		document.forma1.Opcion.value=Opcion
	document.forma1.submit()

}

</script>
<?php
// ENCABEZAMIENTO DE LA PÁGINA

include("../common/institutional_info.php");
?>
<div class=sectionInfo>
    <div class=breadcrumb><?php echo $msgstr["configure"]. " ABCD";?>
    </div>
    <div class="actions">
    <?php include "../common/inc_back.php"; ?>
	</div>
	<div class="spacer">&#160;</div>
</div>
<?php
$ayuda="admin.html";
include "../common/inc_div-helper.php";
?>
<div class="middle form">
<div class="formContent">
<table width=400 align=center>
	<tr>
		<td>
			<form name=update_base onSubmit="return false" method=post>
			<input type=hidden name=Opcion value=update>
			<input type=hidden name=type value="">
			<input type=hidden name=modulo>
			<?php if (isset($arrHttp["encabezado"])) {?>
                <input type=hidden name=encabezado value=s>
                <br>
            <?php } ?>

            <ul>

            <?php if ($_SESSION["profile"]=="adm"){ ?>
				<li>
					<a href='javascript:Ejecutar("../settings/editar_abcd_def.php","abcd_styles")'>
                    	<?php echo $msgstr["set_logo_css"];?>
                	</a>
                </li>
				<li>
					<a href='Javascript:Ejecutar("../settings/databases_list.php","")'>
                    	<?php echo $msgstr["dblist"];?>
                    </a>
                </li>
				<li>
					<a href='Javascript:Ejecutar("../settings/editar_correo_ini.php","")'>
						<?php echo $msgstr["set_mail"];?>
					</a>
				</li>
				<li>
					<a href='opac/'>
						OPAC
					</a>
				</li>	
				
				<?php
				$script_abcd_stats = 'abcd_stats.php';
				if (file_exists($script_abcd_stats)) {
				?>					
				<li>
					<a href='Javascript:Ejecutar("../settings/abcd_stats.php","")'>
						<?php echo $msgstr["s_e_overview"];?>
					</a>
				</li>
				<?php
				} 
				?>


			<?php } ?>
            </ul>
			</form>
		</td>
</table>
<br>
</div>
</div>

<form name=forma1 method=post>
<input type=hidden name=Opcion>
</form>

<?php
// PIE DE PÁGINA
include("../common/footer.php");
?>

