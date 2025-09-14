<?php

/**
 * This script displays a dropdown with the list of available databases.
 * 20230312 rogercgui Created
 */
?>

<div class="dropdown">
	<button class="btn btn-light dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
		<?php echo $msgstr["front_catalog"]; ?>
	</button>
	<ul class="dropdown-menu w-100">

		<?php
		if (!isset($_REQUEST["existencias"]) or trim($_REQUEST["existencias"]) == "") {


			$primeravez = "S";
			if (isset($_REQUEST["modo"]) and $_REQUEST["modo"] != "") {
			}

			$num_db_list = count($bd_list);
			$current_db_index = 0;

			foreach ($bd_list as $key => $value) {
				$archivo = $db_path . $key . "/opac/" . $lang . "/" . $key . "_colecciones.tab";
				$ix = 0;
				$value_info = "";
				$home_link = "*";
				if (file_exists($db_path . "opac_conf/" . $lang . "/" . $key . "_home.info")) {
					$home_info = file($db_path . "opac_conf/" . $lang . "/" . $key . "_home.info");
					foreach ($home_info as $value_info) {
						$value_info = trim($value_info);
						if ($value_info != "") {
							if (substr($value_info, 0, 6) == "[LINK]") $home_link = $value_info;
							if (substr($value_info, 0, 6) == "[TEXT]") $home_link = $value_info;
							if (substr($value_info, 0, 5) == "[MFN]")  $home_link = "";
						}
					}
					echo "**" . $value_info . "<br>";
				}
				if (trim($value["nombre"]) != "") {
					// Usando o cabeçalho de dropdown para o nome da base de dados
					echo "<li><h5 class=\"dropdown-header\"><a class='dropdown-item' href='javascript:BuscarIntegrada(\"$key\",\"\",\"free\",\"\",\"\",\"\",\"\",\"\",\"\",\"$home_link\")'>" . $value["titulo"] . "</a></h5></li>\n";
					if (file_exists($archivo)) {
						$fp = file($archivo);
						foreach ($fp as $colec) {
							$colec = trim($colec);
							if ($colec != "") {
								$v = explode('|', $colec);
								$ix = $ix + 1;
								$col_expr = isset($v[2]) ? $v[2] . $v[0] : "";
								if ($v[0] != '<>') {
									if (isset($IndicePorColeccion) and $IndicePorColeccion == "Y")
										$cipar = "_" . strtolower($v[0]);
									else
										$cipar = "";
									echo "<li>";
									echo "<a class='dropdown-item' href='javascript:BuscarIntegrada(\"$key\",\"1B\",\"free\",\"$col_expr\",\"$colec\",\"\",\"\",\"\",\"\",\"\")'>" . $v[1] . "</a>";
									echo "</li>";
								}
							}
						}
					}
				}

				$current_db_index++;
				if ($current_db_index < $num_db_list) {
					echo "<li><hr class=\"dropdown-divider\"></li>\n";
				}
			}
		}
		?>
	</ul>
</div>