<?php
include("conf_opac_top.php");
$wiki_help = "OPAC-ABCD_configuraci%C3%B3n_avanzada#Facetas";
include "../../common/inc_div-helper.php";
?>

<?php if ($_REQUEST["base"] == "META") {
	echo $_REQUEST["base"]; ?>
	<script>
		var idPage = "metasearch";
	</script>
<?php } else { ?>
	<script>
		var idPage = "db_configuration";
	</script>
<?php } ?>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
		<?php include("conf_opac_menu.php"); ?>
	</div>
	<div class="formContent col-9 m-2">

		<?php include("menu_dbbar.php");  ?>

		<h3><?php echo $msgstr["facetas"]; ?></h3>

		<?php

		//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>"; DIE;
		$linea = array();
		if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"] == "Guardar") {
			$lang = $_REQUEST["lang"];
			$archivo = $db_path . $_REQUEST['base'] . "/opac/$lang/" . $_REQUEST["file"];
			$fout = fopen($archivo, "w");
			foreach ($_REQUEST as $var => $value) {
				$value = trim($value);
				if ($value != "") {
					$var = trim($var);
					if (substr($var, 0, 9) == "conf_base") {
						if (trim($value) != "") {
							$x = explode('_', $var);
							$linea[$x[2]][$x[3]] = $value;
						}
					}
				}
			}
			foreach ($linea as $value) {
				ksort($value);
				$salida = $value[0] . '|' . $value[1];
				fwrite($fout, $salida . "\n");
			}

			fclose($fout);
		?>

			<p class="color-green"><strong><?php echo $archivo . " " . $msgstr["updated"]; ?></strong></p>

		<?php

		}
		if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"] == "copiarde") {
			$archivo = $db_path . $base . "/opac/" . $_REQUEST["lang_copiar"] . "/" . $_REQUEST["archivo"];
			copy($archivo, $db_path . $base . "/opac/" . $_REQUEST["lang"] . "/" . $_REQUEST["archivo"]);
			echo "<p><font color=red>" . $db_path . $base . "/opac/$lang/" . $_REQUEST["archivo"] . " " . $msgstr["copiado"] . "</font>";
		}

		function CopiarDe($iD, $name, $lang, $file)
		{
			global $db_path, $msgstr;
			echo "<br>" . $msgstr["copiar_de"] . " ";
			echo "<select name=lang_copy onchange='Copiarde(\"$iD\",\"$name\",\"$lang\",\"$file\")' id=lang_copy > ";
			echo "<option></option>\n";
			$fp = file($db_path . "opac_conf/$lang/lang.tab");
			foreach ($fp as $value) {
				if (trim($value) != "") {
					$a = explode("=", $value);
					echo "<option value=" . $a[0];
					echo ">" . trim($a[1]) . "</option>";
				}
			}
			echo "</select><br>";
		}

		?>
		<form name=indices method=post>
			<input type=hidden name=db_path value=<?php echo $db_path; ?>>


			<?php

			if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"] != "Guardar") {
				$archivo = $db_path . "opac_conf/$lang/bases.dat";
				$fp = file($archivo);
				$base = $_REQUEST["base"];
				if ($base == "META") {
					Entrada("MetaSearch", $msgstr["metasearch"], $lang, "facetas.dat", $base);
				} else {
					foreach ($fp as $value) {
						if (trim($value) != "") {
							$x = explode('|', $value);
							if ($x[0] != $_REQUEST["base"]) continue;
							echo "<p>";
							Entrada(trim($x[0]), trim($x[1]), $lang, trim($x[0]) . "_facetas.dat", $base);
							break;
						}
					}
				}
			}
			?>
	</div>
	<?php
	function Entrada($iD, $name, $lang, $file, $base)
	{
		global $msgstr, $db_path;
		echo "<form name=$iD" . "Frm method=post>\n";
		echo "<input type=hidden name=Opcion value=Guardar>\n";
		echo "<input type=hidden name=base value=$base>\n";
		echo "<input type=hidden name=file value=\"$file\">\n";
		echo "<input type=hidden name=lang value=\"$lang\">\n";
		if (isset($_REQUEST["conf_level"])) {
			echo "<input type=hidden name=conf_level value=" . $_REQUEST["conf_level"] . ">\n";
		}
		echo "<strong>" . $name . " ($base)</strong>";
		echo "<div  id='$iD' style=\"width:100%; display: table;\">\n";
		echo "<div style=\"display: table-row\">";
		echo "<div style=\"display:table-cell;width:50%;text-align:left;margin-top:0;\">";
		$cuenta = 0;

		if ($base != "" and $base != "META") {
			$fp_campos = file($db_path . $base . "/data/$base.fst");
			$cuenta = count($fp_campos);
		}

		if ($base != "" and $base != "META") {
			$file_av = $db_path . $base . "/opac/$lang/$file";
		} else {
			$file_av = $db_path . "/opac_conf/$lang/$file";
		}


		if (!file_exists($file_av)) {
			$fp = array();
			for ($i = 0; $i < 10; $i++) {
				$fp[] = "|";
			}
		} else {
			$fp = file($file_av);
			$fp[] = '|';
			$fp[] = '|';
			$fp[] = '|';
			$fp[] = '|';
		}
		echo "<table >\n";
		echo "<tr><td colspan=2>";
		echo "<code>$file_av</code><br>";
		echo "</td></tr>";
		echo "<tr><th>" . $msgstr["nombre"] . "</th><th>" . $msgstr["expr_b"] . "</th></tr>\n";
		$row = 0;
		foreach ($fp as $value) {
			$value = trim($value);
			if ($value != "") {
				$ix = -1;
				$row = $row + 1;
				$v = explode('|', $value);
				echo "<tr>";
				foreach ($v as $var) {
					$ix = $ix + 1;
					if ($ix > 3) break;
					echo "<td>";
					if ($ix == 0)
						$size = 20;
					else
						$size = 20;
					echo "<input type=text name=conf_base_" . $row . "_" . $ix . " value=\"$var\" size=$size>";
					echo "</td>\n";
				}
				echo "</tr>\n";
			}
		}
	?>
		<tr>
			<td colspan=2 align=center>
				<button type="submit" class="bt-green m-2"><?php echo $msgstr["save"]; ?></button>
			</td>
		</tr>
		</table>
</div>
</div>

<div style="display:table-cell;width:42% ;">
	<?php
		if ($cuenta > 0) {
	?>
		<table class="table striped">
	<?php
			echo "<tr><td colspan=3>";
			echo "<strong>" . $base . "/data/" . $base . ".fst</strong><br><br></td></tr>";
			foreach ($fp_campos as $value) {
				if (trim($value) != "") {
					$v = explode(' ', $value, 3);
					echo "<tr><td>" . $v[0] . "</td><td>" . $v[1] . "</td><td>" . $v[2] . "</td></tr>\n";
				}
			}
			echo "</table>";
		}
		echo "</div></div>";
		echo "</form></div>";
	}
	?>


</div>

<?php include("../../common/footer.php"); ?>