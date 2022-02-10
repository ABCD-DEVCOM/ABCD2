<?php
include ("tope_config.php");
if (isset($_REQUEST["conf_level"]) and $_REQUEST["conf_level"]=="basic" or !isset($_REQUEST["conf_level"])){
	$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_Configuración_de_bases_de_datos#Configuraci.C3.B3n_b.C3.A1sica";
	$wiki_trad="wiki.abcdonline.info/OPAC-ABCD_Configuraci%C3%B3n_de_bases_de_datos";
}else{
	$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_Configuraci%C3%B3n_de_bases_de_datos#Configuraci.C3.B3n_avanzada";
	$wiki_trad="wiki.abcdonline.info/OPAC-ABCD_Configuraci%C3%B3n_de_bases_de_datos#Configuraci.C3.B3n_avanzada";
}
include("../php/leer_bases.php");
?>
<style>
	#wwrapper {
  		display: flex;
	}
	#wleft {
  		flex: 0 0 50%;
	}
	#wright {
  		flex: 1;
  		margin: auto;
	}
</style>
<script>
	function EnviarCopia(){
		if (document.copiar_a.lang_to.options[document.copiar_a.lang_to.selectedIndex].value=="<?php echo $_REQUEST["lang"]?>"){			alert("<?php echo $msgstr["sel_o_l"]?>")
			return false		}
		if (document.copiar_a.replace_a[0].checked || document.copiar_a.replace_a[1].checked ){			document.copiar_a.submit()		}else{			alert("<?php echo $msgstr["missing"]." ".$msgstr["sustituir_archivos"];?>")
			return false		}	}
</script>
<?php
if (!isset($_REQUEST["db_path"])){	$_REQUEST["db_path"]=$db_path;
	$_REQUEST["db_path_desc"]="$db_path";}
if ($_REQUEST["base"]!="META")
if (isset($_REQUEST["db_path"])) {	$_SESSION["db_path"]=$_REQUEST["db_path"];
	if ($_REQUEST["base"]!="META") $_SESSION["db_path_desc"]=$bd_list[$_REQUEST["base"]]["descripcion"];
}
if (isset($_REQUEST["lang"])) $_SESSION["lang"]=$_REQUEST["lang"];


//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; die;

/////////////////////////////////////////////////////////////////////
	if (!isset($_SESSION["permiso"])){
		session_destroy();
		$msg=$msgstr["invalidright"]." ".$msgstr[$_REQUEST["startas"]];
		echo "
		<html>
		<body>
		<form name=err_msg action=error_page.php method=post>
		<input type=hidden name=error value=\"$msg\">
		";
		echo "
		</form>
		<script>
			document.err_msg.submit()
		</script>
		</body>
		</html>
		";
    	session_destroy();
    	die;
    }
	$Permiso=$_SESSION["permiso"];



echo "<div id=\"page\">";
echo  "<h3>".$msgstr["db_configuration"]." &nbsp;";
include("wiki_help.php");
?>
	<div id="wwrapper">
  		<div id="wleft" style="margin-top:3px;padding:10px;">
			<?php
			if (!file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat")){				echo "<font color=red>".$msgstr["missing"]."opac_conf/".$_REQUEST["lang"]."/bases.dat";			}else{				$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat");
				$fp[]="META|".$msgstr["metasearch"];
				foreach ($fp as $value){					if (trim($value)!=""){						$x=explode('|',$value);
						if ($_REQUEST["base"]==$x[0]){							$nombre_base=$x[1];
							$base=$x[0];
							echo "<h3>".$_REQUEST["base"]." - ".$nombre_base."</h3>";						}					}				}
			}
			echo "<ul>";
			 if (isset($_REQUEST["conf_level"]) and $_REQUEST["conf_level"]=="basic" or !isset($_REQUEST["conf_level"])){
				echo "<h4>".$msgstr["conf_b"]."</h4>";
				?>
            	<li><a href="javascript:SeleccionarProceso('busqueda_libre.php','<?php echo $base?>')"><?php echo $msgstr["free_search"];?></li>
				<li><a href="javascript:SeleccionarProceso('busqueda_avanzada.php','<?php echo $base?>')"><?php echo $msgstr["buscar_a"];?></li>
		    	<?php
		    	if ($base!="META"){					echo "<li><a href=\"javascript:SeleccionarProceso('formatos_salida.php','$base')\">".$msgstr["select_formato"]."</a></li>";
					echo "<li><a href=\"javascript:SeleccionarProceso('dbn_par.php','$base')\">".$msgstr["dbn_par"]."</a></li>";		    	}
		    	?>
	<?php
				 if ($_REQUEST["base"]!="META"){
					ECHO	"<li>".$msgstr["export_xml"]."</li>";
					echo    "<ul>";
					ECHO	"<li><a href=\"javascript:SeleccionarProceso('xml_marc.php','".$base."')\">".$msgstr["xml_marc"]."</a></li>";
					ECHO	"<li><a href=\"javascript:SeleccionarProceso('xml_dc.php','".$base."')\">".$msgstr["xml_dc"]."</a></li>";
					echo    "</ul>";

			 	}
			}
 if (isset($_REQUEST["conf_level"]) and $_REQUEST["conf_level"]=="advanced"){ 	echo "<h4>".$msgstr["conf_a"]."</h4>";
?>
 	<li><a href="javascript:SeleccionarProceso('facetas_cnf.php','<?php echo $base?>')"><?php echo $msgstr["facetas"];?></a></li><?php 	if ($_REQUEST["base"]!="META"){
?>
			<li><a href="javascript:SeleccionarProceso('tipos_registro.php','<?php echo $base?>')"><?php echo $msgstr["tipos_registro"];?></a></li>
			<li><a href="javascript:SeleccionarProceso('busqueda_avanzada_tr.php','<?php echo $base?>')"><?php echo $msgstr["buscar_a"]." - ". $msgstr["tipos_registro"];?></a></li>
<?php }?>
			<li><a href="javascript:SeleccionarProceso('alpha_ix.php','<?php echo $base?>')"><?php echo $msgstr["indice_alfa"];?></a></li>
<?php
 	if ($_REQUEST["base"]!="META"){?>
			<li><a href="javascript:SeleccionarProceso('autoridades.php','<?php echo $base?>')"><?php echo $msgstr["aut_opac"];?></a></li>
			<li><a href="javascript:SeleccionarProceso('presentacion_base.php','<?php echo $base?>')"><?php echo $msgstr["base_home"];?></a></li>
<?php }?>

<?php } ?>
			</ul>
		</div>
		<div id="wright">
		<form name=copiar_a method=post action=copiar_a.php onsubmit="return false">
<?php
		echo "<input type=hidden name=lang_from value=".$_REQUEST["lang"].">\n";
		if (isset($_REQUEST["conf_level"]) and $_REQUEST["conf_level"]=="advanced")
			echo "<input type=hidden name=conf_level value=". $_REQUEST["conf_level"].">\n";
		echo $msgstr["copiarconf_a"]."&nbsp; &nbsp;";
		echo "<select name=lang_to>\n";
		$archivo=$db_path."opac_conf/$lang/lang.tab";
		if (file_exists($archivo)){
			$fp=file($archivo);
			foreach ($fp as $value){
				if (trim($value)!=""){
					$a=explode("=",$value);
					echo "<option value=".$a[0];
					if ($lang==$a[0]) echo " selected";
					echo ">".trim($a[1])."</option>";
				}
			}
			unset($fp);
		}else{
			echo "<option value=$lang selected>$lang</option>";
		}
		echo "</select>\n";
		echo "<br><br>".$msgstr["sustituir_archivos"]." &nbsp;" ;
		echo "<input type=radio value=Y name=replace_a>".$msgstr["y"]." &nbsp";
		echo "&nbsp<input type=radio value=N name=replace_a>".$msgstr["n"]." &nbsp";
		echo "<br><br><input type=submit value=".$msgstr["send"]." onclick=EnviarCopia()>\n";
?>
		</form>
		</div>
	</div>
</div>
<br>
<br>
<?php
if (!isset($_REQUEST["conf_level"])){
	echo "<dd><strong><a href=procesos_base.php?conf_level=advanced&base=".$_REQUEST["base"]."&lang=".$_REQUEST["lang"].">".$msgstr["conf_a"]."</a></strong></dd>";
}else{
	echo  "<dd><strong><a href=procesos_base.php?base=".$_REQUEST["base"]."&lang=".$_REQUEST["lang"].">". $msgstr["conf_b"]."</a><strong></dd>";
}
include ("../php/footer.php");
?>
</div>
</div>
</body
</html>
<form name=forma1 method=post>
<?php if (isset($_REQUEST["conf_level"])){	echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
}?>
<input type=hidden name=base>
<input type=hidden name=lang value=<?php echo $_REQUEST["lang"]?>>
</form>
