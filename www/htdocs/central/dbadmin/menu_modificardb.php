<?php
/* Modifications
20211216 fho4abcd Backbutton & helper by included file. improve html
20220112 fho4abcd fmt.php->fmt_adm.php
20220202 fho4abcd improved text strings, more translations
20220209 fho4abcd Preserve base
20220214 fho4abcd Marc menu items only for MARC
20220317 fho4abcd Layout, remove superfluous permission check, add barcode configuration
20220321 fho4abcd renamed barcode scripts
20220926 fho4abcd add statistic configuration. top/down buttons
20250902 rogercgui Fix links from statistics links
*/
///////////////////////////////////////////////////////////////////////////////
//
//  MODIFICA LA CONFIGURACIÓN DE LA BASE DE DATOS
//
///////////////////////////////////////////////////////////////////////////////

session_start();
if (!isset($_SESSION["permiso"])) {
	header("Location: ../common/error_page.php");
}
include("../common/get_post.php");
include("../config.php");
// ARCHIVOS DE LENGUAJE
include("../lang/admin.php");
include("../lang/soporte.php");
include("../lang/dbadmin.php");
include("../lang/statistics.php");
// EXTRACCIÓN DEL NOMBRE DE LA BASE DE DATOS


if (isset($arrHttp["base"])) {
	$selbase = $arrHttp["base"];
} else {
	$selbase = "";
}

if (strpos($selbase, "|") === false) {
} else {
	$ix = explode('|', $selbase);
	$selbase = $ix[0];
}
$base = $selbase;
$arrHttp["base"] = $base;
// VERIFICACION DE LA PERMISOLOTIA
if (isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"]["CENTRAL_MODIFYDEF"]) or isset($_SESSION["permiso"][$base . "_CENTRAL_MODIFYDEF"]) or isset($_SESSION["permiso"][$base . "_CENTRAL_ALL"])) {
} else {
	echo "<h2>" . $msgstr["invalidright"] . " " . $base;
	die;
}

// ENCABEZAMIENTO HTML Y ARCHIVOS DE ESTILO
include("../common/header.php");

// INCLUSION DE LOS SCRIPTS
?>

<body>
	<script language="JavaScript" type="text/javascript" src=../dataentry/js/lr_trim.js></script>
	<script language='javascript'>
		function Update(Option) {
			if (document.update_base.base.value == "") {
				alert("<?php echo $msgstr["seldb"] ?>")
				return
			}
			switch (Option) {
				case "fdt":
					document.getElementById('loading').style.display = 'block';
					document.update_base.action = "fdt.php"
					document.update_base.type.value = "bd"
					break;
				case "leader":
					document.getElementById('loading').style.display = 'block';
					document.update_base.action = "fdt.php"
					document.update_base.type.value = "leader.fdt"
					break;
				case "fdt_new":
					document.getElementById('loading').style.display = 'block';
					document.update_base.action = "fdt_short_a.php"
					document.update_base.type.value = "bd"
					break;
				case "fst":
					document.getElementById('loading').style.display = 'block';
					document.update_base.action = "fst.php"
					break;
				case "fmt_adm":
					document.update_base.action = "fmt_adm.php"
					break;
				case "pft":
					document.update_base.action = "pft.php"
					break;
				case "typeofrecs":
					document.getElementById('loading').style.display = 'block';
					<?php
					$archivo = $db_path . $selbase . "/def/" . $_SESSION["lang"] . "/typeofrecs.tab";
					if (!file_exists($archivo))  $archivo = $db_path . $selbase . "/def/" . $lang_db . "/typeofrecs.tab";
					if (file_exists($archivo))
						$script = "typeofrecs_edit.php";
					else
						$script = "typeofrecs_edit.php";
					echo "\ndocument.update_base.action=\"$script\"\n";
					?>
					break;
				case "fixedfield":
					document.getElementById('loading').style.display = 'block';
					document.update_base.action = "typeofrecs_marc_edit.php"
					break;
				case "fixedmarc":
					document.getElementById('loading').style.display = 'block';
					document.update_base.action = "fixed_marc.php"
					break;
				case "recval":
					document.update_base.action = "typeofrecs.php"
					break;
				case "delval":
					document.update_base.action = "recdel_val.php"
					document.update_base.format.value = "recdel_val"
					break;
				case "bases":
					document.update_base.action = "../settings/databases_list.php"
					break;
				case "par":
					document.update_base.action = "editpar.php"
					break;
				case "dr_path":
					document.update_base.Opcion.value = "dr_path"
					document.update_base.action = "../settings/editar_abcd_def.php"
					break;
				case "search_catalog":
					document.update_base.action = "advancedsearch.php"
					document.update_base.modulo.value = "catalogacion"
					break;
				case "search_circula":
					document.update_base.action = "advancedsearch.php"
					document.update_base.modulo.value = "prestamo"
					break;
				case "IAH":
					document.update_base.action = "iah_edit_db.php"
					break
				case "tooltips":
					document.update_base.action = "database_tooltips.php"
					break
				case "help":
					document.update_base.action = "../documentacion/help_ed.php"
					break
				case "tes_config":
					document.update_base.action = "tes_config.php"
					break
				case "chk_dbdef":
					document.update_base.action = "chk_dbdef.php"
					break
				case "labeltab":
					document.update_base.action = "../barcode/bcl_config_label_table.php"
					break
				case "labelconfig":
					document.update_base.action = "../barcode/bcl_config_labels.php"
					break
				case "stats_var":
					document.update_base.action = "config_vars.php"
					break
				case "stats_tab":
					document.update_base.action = "tables_cfg.php"
					break
				case "stats_var":
					document.update_base.action = "../statistics/config_vars.php"
					break
				case "stats_pft":
					document.update_base.action = "../statistics/config_tables.php"
					break
				case "stats_tab":
					document.update_base.action = "../statistics/tables_cfg.php"
					break
				case "stats_proc":
					document.update_base.action = "../statistics/proc_cfg.php"
					break
			}
			document.update_base.submit()
		}
	</script>
	<div id="loading">
		<img id="loading-image" src="../dataentry/img/preloader.gif" alt="Loading...">
	</div>
	<?php
	// ENCABEZAMIENTO DE LA PÁGINA
	if (isset($arrHttp["encabezado"])) {
		include("../common/institutional_info.php");
		$encabezado = "&encabezado=s";
	}
	?>
	<div id="top"></div>
	<div class="sectionInfo">
		<div class="breadcrumb"><?php echo $msgstr["updbdef"] . ": " . $selbase ?>
		</div>
		<div class="actions">
			<?php include "../common/inc_home.php"; ?>
		</div>
		<div class="spacer">&#160;</div>
	</div>
	<?php
	include "../common/inc_div-helper.php";

	$dir_fdt = $db_path . $selbase . "/def/" . $lang . "/";
	$ldr = "";

	// para verificar si en la FDT tiene el campo LDR Definido y ver si se presenta el tipo de registro MARC
	if (is_dir($dir_fdt)) {
		if (file_exists($dir_fdt . $selbase . ".fdt")) {
			$fp = file($dir_fdt . $selbase . ".fdt");
		} else {
			$fp = file($db_path . $selbase . "/def/" . $lang_db . "/" . $selbase . ".fdt");
		}

		foreach ($fp as $value) {
			$value = trim($value);
			if (trim($value) != "") {
				$fdt = explode('|', $value);
				if ($fdt[0] == "LDR") {
					$ldr = "s";
					break;
				}
			}
		}
	}
	?>
	<div class="middle form">
		<div class="formContent">
			<form name=update_base onSubmit="return false" method=post>
				<input type=hidden name=Opcion value=update>
				<input type=hidden name=type value="">
				<input type=hidden name=modulo>
				<input type=hidden name=format>
				<input type=hidden name=base value=<?php echo $selbase; ?>>
				<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>"; ?>

				<table align=center class="striped">
					<tr>
						<td>
							<h5><?php echo $msgstr["dbadmin_FDT_FMT"] ?> (FDT / FMT)</h5>
						</td>
						<td>
							<a href='javascript:Update("fdt")'><?php echo $msgstr["fdt"] ?></a><br>
							<a href='javascript:Update("fdt_new")'><?php echo $msgstr["fdt"] . " (" . $msgstr["wosubfields"] . ")" ?></a><br>
							<?php
							// SI ES UN REGISTRO MARC SE INCLUYE LA OPCION PARA MANEJO DE LOS TIPOS DE REGISTRO DE ACUERDO AL LEADER
							if ($ldr == "s") {
							?>
								<a href='javascript:Update("leader")'><?php echo $msgstr["ft_ldr"] ?></a><br>
								<a href='javascript:Update("fixedmarc")'><?php echo "MARC-" . $msgstr["typeofrecord_ff"] ?></a><br>
								<a href='javascript:Update("fixedfield")'><?php echo "MARC-" . $msgstr["typeofrecord_aw"] ?></a><br>
							<?php
							}
							?>
							<a href='javascript:Update("fmt_adm")'><?php echo $msgstr["fmt"] ?></a><br>
							<?php
							if (!isset($ldr) or $ldr != "s") {
								// SI NO ES UN REGISTRO MARC SE INCLUYE EL MANEJO DE LOS TIPOS DE REGISTRO NO MARC
							?>
								<a href='javascript:Update("typeofrecs")'><?php echo $msgstr["typeofrecord_aw"]; ?></a><br>
							<?php
							}
							?>
						</td>
						<td> &nbsp; &nbsp;
							<a class="bt bt-blue" href="#bottom"><i class="fa fa-arrow-down"></i></a>
						</td>

					</tr>
					<tr>
						<td>
							<h5><?php echo $msgstr["dbadmin_INDEX"] ?> (FST)</h5>
						</td>
						<td>
							<a href='javascript:Update("fst")'><?php echo $msgstr["fst"] ?></a>
						</td>
					</tr>
					<tr>
						<td>
							<h5><?php echo $msgstr["dbadmin_FORMAT"] ?> (PFT)</h5>
						</td>
						<td>
							<a href='javascript:Update("pft")'><?php echo $msgstr["pft"] ?></a>
						</td>
					</tr>
					<tr>
						<td>
							<h5><?php echo $msgstr["dbadmin_VALID"] ?> (VAL)</h5>
						</td>
						<td>
							<a href='javascript:Update("recval")'><?php echo $msgstr["recval"] ?></a><br>
							<a href='javascript:Update("delval")'><?php echo $msgstr["delval"] ?></a>
						</td>
					</tr>
					<tr>
						<td>
							<h5><?php echo $msgstr["dbadmin_INTERNALSEARCH"] ?></h5>
						</td>
						<td>
							<a href='javascript:Update("search_catalog")'><?php echo $msgstr["advsearch"] . ": " . $msgstr["catalogacion"] ?></a><br>
							<a href='javascript:Update("search_circula")'><?php echo $msgstr["advsearch"] . ": " . $msgstr["prestamo"] ?></a>
						</td>
					</tr>
					<tr>
						<td>
							<h5><?php echo $msgstr["dbadmin_EDIT_HELPS"] ?></h5>
						</td>
						<td>
							<a href='javascript:Update("help")'><?php echo $msgstr["helpdatabasefields"] ?></a><br>
							<a href='javascript:Update("tooltips")'><?php echo $msgstr["database_tooltips"] ?></a>
						</td>
					</tr>
					<tr>
						<td>
							<h5><?php echo $msgstr["dbadmin_BARCOLABEL"] ?></h5>
						</td>
						<td>
							<a href='javascript:Update("labeltab")'><?php echo $msgstr["barcode_table"] ?></a><br>
							<a href='javascript:Update("labelconfig")'><?php echo $msgstr["barcode_config"] ?></a>
						</td>
					</tr>
					<tr>
						<td>
							<h5><?php echo $msgstr["dbadmin_ADVANCED"] ?></h5>
						</td>
						<td>
							<a href='javascript:Update("IAH")'><?php echo $msgstr["iah-conf"] ?></a><br>
							<a href='javascript:Update("tes_config")'><?php echo $msgstr["tes_config"] ?></a><br>
							<a href='javascript:Update("chk_dbdef")'><?php echo $msgstr["chk_dbdef"] ?></a><br>
							<a href='javascript:Update("dr_path")'><?php echo $msgstr["dr_path.def"] ?></a><br>
							<a href='javascript:Update("par")'><?php echo $msgstr["dbnpar"] ?></a>
						</td>
					</tr>
					<tr>
						<td>
							<h5><?php echo $msgstr["stats_conf"] ?></h5>
						</td>
						<td>
							<a href='javascript:Update("stats_var")'><?php echo $msgstr["stat_cfg_vars"] ?></a><br>
							<a href='javascript:Update("stats_pft")'><?php echo $msgstr["def_pre_tabs"] ?></a><br>
							<a href='javascript:Update("stats_tab")'><?php echo $msgstr["stat_cfg_tabs"] ?></a><br>
							<a href='javascript:Update("stats_proc")'><?php echo $msgstr["stat_cfg_procs"] ?></a><br>
						</td>
						<td> &nbsp; &nbsp;
							<a class="bt bt-blue" href="#top"><i class="fas fa-arrow-up"></i></a>
						</td>
					</tr>
				</table>
			</form>

		</div>
	</div>
	<div id="bottom"></div>
	<?php
	// PIE DE PÁGINA
	include("../common/footer.php");
	?>