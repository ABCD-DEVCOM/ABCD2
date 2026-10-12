<?php
/*
* @file        typeofrecs_marc_edit.php
* @description Simplified Type of Records definition using a basic editable table
* @author      Refactored by Roger C. Guilherme
* @date        2025-11-18
* 
* CHANGE LOG
* 2022-01-21 fho4abcd buttons+html cleanup+div-helper
* 2022-01-26 fho4abcd allow empty lines in worksheet table
*/

session_start();
if (!isset($_SESSION["permiso"])) {
	header("Location: ../common/error_page.php");
	die;
}
if (!isset($_SESSION["lang"]))  $_SESSION["lang"] = "en";
include("../common/get_post.php");
include("../config.php");
$lang = $_SESSION["lang"];

include("../lang/dbadmin.php");
include("../common/header.php");

// File path
$file_tor_session = $db_path . $arrHttp["base"] . "/def/" . $_SESSION["lang"] . "/typeofrecord.tab";
$file_tor_default = $db_path . $arrHttp["base"] . "/def/" . $lang_db . "/typeofrecord.tab";

// Check which file exists
if (file_exists($file_tor_session)) {
	$file_tor = $file_tor_session;
} elseif (file_exists($file_tor_default)) {
	$file_tor = $file_tor_default;
} else {
	$file_tor = ""; // File does not exist
}

$current_tipom = ""; // Tag 1
$current_nivelr = ""; // Tag 2
$current_rows = [];

// 1. Carregar Dados Atuais (typeofrecord.tab) com conversão de encoding
if (!empty($file_tor)) {
	$fp = file($file_tor); // Read raw lines
	$first_line = true;

	// Verifica se a sessão está em modo UNICODE (UTF-8)
	$is_unicode = (isset($_SESSION["UNICODE"]) && $_SESSION["UNICODE"] == 1);

	foreach ($fp as $linea) {
		$linea = trim($linea);
		if ($linea == "") continue;

		if ($is_unicode) {
			$linea = mb_convert_encoding($linea, 'UTF-8', 'ISO-8859-1');
		}

		if ($first_line) {
			// A primeira linha define as tags: "3006 3007"
			$parts = preg_split('/\s+/', $linea);
			$current_tipom = isset($parts[0]) ? $parts[0] : "";
			$current_nivelr = isset($parts[1]) ? $parts[1] : "";
			$first_line = false;
		} else {
			// Linhas subsequentes são os mapeamentos, separadas por '|'
			$current_rows[] = explode('|', $linea, 4);
		}
	}
}
?>

<body>
	<?php
	if (isset($arrHttp["encabezado"])) {
		include("../common/institutional_info.php");
	}
	?>

	<div class="sectionInfo">
		<div class="breadcrumb"><?php echo $msgstr["typeofrecords"] . ": " . $arrHttp["base"] ?></div>
		<div class="actions">
			<?php
			if (isset($arrHttp["encabezado"])) $encabezado = "&encabezado=s";
			else $encabezado = "";
			$backtocancelscript = "menu_modificardb.php?base=" . $arrHttp["base"] . $encabezado;
			include "../common/inc_cancel.php";
			?>
		</div>
		<div class="spacer">&#160;</div>
	</div>

	<?php include "../common/inc_div-helper.php"; ?>

	<div class="middle form">
		<div class="formContent">

			<form name="tor" id="torForm" method="post" action="typeofrecs_update.php" onsubmit="return ValidarEnviar();">
				<input type="hidden" name="base" value="<?php echo $arrHttp["base"] ?>">
				<?php if (isset($arrHttp["encabezado"])) echo "<input type='hidden' name='encabezado' value='s'>\n"; ?>

				<div class="helper-box">
					<h5><i class="fas fa-cog"></i> <?php echo $msgstr["typeofrecords_tags"] ?? "Configuração de Tags" ?></h5>
					<div class="form-row-custom">
						<div class="form-group-custom" style="width: 120px;">
							<label>TAG 1 (Tipo)</label>
							<input type="text" name="tipom" id="tipom" value="<?php echo htmlspecialchars($current_tipom) ?>" placeholder="Ex: 3006">
						</div>
						<div class="form-group-custom" style="width: 120px;">
							<label>TAG 2 (Nível)</label>
							<input type="text" name="nivelr" value="<?php echo htmlspecialchars($current_nivelr) ?>" placeholder="Ex: 3007">
						</div>
						<div class="form-group-custom" style="justify-content: flex-end; padding-bottom: 2px;">
							<span class="text-muted" style="font-size: 11px;">
								<i class="fas fa-info-circle"></i> <?php echo $msgstr["typeofrecords_tagsempty"] ?>
							</span>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<table class="table-edit striped" id="tblRows">
							<thead>
								<tr>
									<th width="25%">FDT / Worksheet</th>
									<th width="15%"><?php echo $msgstr["tag"] ?> 1 <?php echo $msgstr["value"] ?></th>
									<th width="15%"><?php echo $msgstr["tag"] ?> 2 <?php echo $msgstr["value"] ?></th>
									<th width="30%"><?php echo $msgstr["description"] ?></th>
									<th width="10%" class="actions-cell"><?php echo $msgstr["actions"] ?? "Ações" ?></th>
								</tr>
							</thead>
							<tbody id="torBody">
								<?php
								$rowIdx = 0;
								foreach ($current_rows as $row) {
									$rowIdx++;

									$val_fdt = isset($row[0]) ? $row[0] : "";
									$val_tag1 = isset($row[1]) ? $row[1] : "";
									$val_tag2 = isset($row[2]) ? $row[2] : "";
									$val_desc = isset($row[3]) ? $row[3] : "";

									echo "<tr class='tor-row' data-idx='$rowIdx'>";

									// Col 1: FDT (Worksheet)
									echo "<td><input type='text' name='cell{$rowIdx}_1' value='" . htmlspecialchars($val_fdt) . "'></td>";

									// Col 2: Valor TAG 1
									echo "<td><input type='text' name='cell{$rowIdx}_2' value='" . htmlspecialchars($val_tag1) . "' style='text-align: center;'></td>";

									// Col 3: Valor TAG 2
									echo "<td><input type='text' name='cell{$rowIdx}_3' value='" . htmlspecialchars($val_tag2) . "' style='text-align: center;'></td>";

									// Hidden Fixed Map (Mantido para compatibilidade com o update.php)
									echo "<input type='hidden' name='cell{$rowIdx}_4' value=''>";

									// Col 4 (Visual, que é a Coluna 5 do script original): Descrição
									echo "<td><input type='text' name='cell{$rowIdx}_5' value='" . $val_desc . "'></td>";

									// Ações
									echo "<td class='actions-cell'>";
									echo "<button type='button' class='bt bt-gray' title='Mover para Cima' onclick='moveRow(this, -1)'><i class='fas fa-arrow-up'></i></button>";
									echo "<button type='button' class='bt bt-gray' title='Mover para Baixo' onclick='moveRow(this, 1)'><i class='fas fa-arrow-down'></i></button>";
									echo "<button type='button' class='bt bt-red' title='Apagar linha' onclick='deleteRow(this)'><i class='fas fa-trash-alt'></i></button>";
									echo "</td>";

									echo "</tr>";
								}
								?>
							</tbody>
						</table>

						<div style="margin-top: 15px;">
							<button type="button" class="bt bt-blue" onclick="addEmptyRow()">
								<i class="fas fa-plus"></i> <?php echo $msgstr["add"] ?? "Adicionar Linha" ?>
							</button>
						</div>
					</div>
				</div>

				<div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 15px;">
					<button type="submit" class="bt bt-green">
						<i class="fas fa-save"></i> <?php echo $msgstr["save"] ?? "Salvar" ?>
					</button>
				</div>

			</form>
		</div>
	</div>

	<script>
		// Se as funções deleteRow e moveRow estiverem em um arquivo global, retire-as daqui.
		// Caso contrário, mantenha-as para funcionalidade.
		let nextRowIdx = <?php echo $rowIdx + 1; ?>;

		function addEmptyRow() {
			const tbody = document.getElementById("torBody");
			const newIdx = nextRowIdx++;

			const tr = document.createElement("tr");
			tr.className = "tor-row";
			tr.innerHTML = `
            <td><input type="text" name="cell${newIdx}_1" value="" placeholder="Ex: LIVROS.fmt"></td>
            <td><input type="text" name="cell${newIdx}_2" value="" style='text-align: center;'></td>
            <td><input type="text" name="cell${newIdx}_3" value="" style='text-align: center;'></td>
            <input type="hidden" name="cell${newIdx}_4" value="">
            <td><input type="text" name="cell${newIdx}_5" value=""></td>
            <td class="actions-cell">
                <button type="button" class="bt bt-gray" title="Mover para Cima" onclick="moveRow(this, -1)"><i class="fas fa-arrow-up"></i></button>
                <button type="button" class="bt bt-gray" title="Mover para Baixo" onclick="moveRow(this, 1)"><i class="fas fa-arrow-down"></i></button>
                <button type="button" class="bt bt-red" title="Apagar linha" onclick="deleteRow(this)"><i class="fas fa-trash-alt"></i></button>
            </td>
        `;
			tbody.appendChild(tr);
			tr.scrollIntoView({
				behavior: "smooth",
				block: "nearest"
			});
		}

		function deleteRow(btn) {
			if (confirm("<?php echo $msgstr['are_you_sure'] ?? 'Tem certeza que deseja apagar esta linha?'; ?>")) {
				btn.closest("tr").remove();
			}
		}

		function moveRow(btn, direction) {
			var row = btn.closest("tr");
			var tbody = row.parentNode;
			if (direction === -1 && row.previousElementSibling) {
				tbody.insertBefore(row, row.previousElementSibling);
			} else if (direction === 1 && row.nextElementSibling) {
				tbody.insertBefore(row.nextElementSibling, row);
			}
		}

		function ValidarEnviar() {
			const tipom = document.getElementById("tipom").value.trim();

			if (tipom === "") {
				alert("<?php echo $msgstr['typeofrecords_new'] ?? 'Defina a TAG 1 (Tipo de Material).'; ?>");
				return false;
			}

			// A conversão de encoding para ISO-8859-1 (utf8_decode) deve ser feita no typeofrecs_update.php antes de salvar!

			return true;
		}
	</script>

	<?php include("../common/footer.php"); ?>
