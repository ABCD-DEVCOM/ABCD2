<?php

$lang=$_SESSION["lang"];
unset($_SESSION["Browse_Expresion"]);
//PARA ELIMINAR LAS VARIABLES DE SESSION DEL DIRTREE
unset($_SESSION["root_base"]);
unset($_SESSION["dir_base"]);
unset($_SESSION["Folder_Name"]);
unset($_SESSION["Folder_Type"]);
unset($_SESSION["Opened_Folder"]);
unset($_SESSION["Father"]);
unset($_SESSION["Numfile"]);
unset($_SESSION["File_Date"]);
unset($_SESSION["Last_Node"]);
unset($_SESSION["Level_Tree"]);
unset($_SESSION["Levels_Fixed_Path"]);
unset($_SESSION["Numbytes"]);
unset($_SESSION["Children_Files"]);
unset($_SESSION["Children_Subdirs"]);
unset($_SESSION["Maxfoldersize"]);
unset($_SESSION["Last_Level_Node"]);
unset($_SESSION["Total_Time"]);
unset($_SESSION["Server_Path"]);


$base = $_REQUEST['base'];
?>
<nav>

<ul class="nav">
	<li><a href="#">Pesquisa</a>
		<ul>
			<li><a href="javascript:SeleccionarProceso('edit_form-search.php','<?php echo $base?>','libre')"><?php echo $msgstr["free_search"];?></a></li>
			<li><a href="javascript:SeleccionarProceso('edit_form-search.php','<?php echo $base?>','avanzada')"><?php echo $msgstr["buscar_a"];?></a></li>
			<li><a href="javascript:SeleccionarProceso('facetas_cnf.php','<?php echo $base?>')"><?php echo $msgstr["facetas"];?></a></li>
		</ul>
	</li>
	<?php if ($base!="META") { ?>	
	<li><a href="javascript:SeleccionarProceso('formatos_salida.php','<?php echo $base?>')"><?php echo $msgstr["select_formato"];?></a></li>
	<?php  }?>
	<?php if ($base!="META") { ?>	
	<li><a href="#"><?php echo $msgstr["export_xml"]?></a>
		<ul>
			<li><a href="javascript:SeleccionarProceso('xml_dc.php','<?php echo $base?>')"><?php echo $msgstr["dc_step2"];?></a></li>
			<li><a href="javascript:SeleccionarProceso('xml_marc.php','<?php echo $base?>')"><?php echo $msgstr["xml_step2"];?></a></li>
		</ul>
	</li>
	<?php  }?>


	<li><a href="#"><?php echo $msgstr["conf_a"]?></a>
		<ul>
			<li><a href="javascript:SeleccionarProceso('alpha_ix.php','<?php echo $base?>')"><?php echo $msgstr["indice_alfa"];?></a></li>

			<?php if ($base!="META") { ?>	
			<li><a href="javascript:SeleccionarProceso('autoridades.php','<?php echo $base?>')"><?php echo $msgstr["aut_opac"];?></a></li>
			<li><a href="javascript:SeleccionarProceso('tipos_registro.php','<?php echo $base?>')"><?php echo $msgstr["tipos_registro"];?></a></li>
			<li><a href="javascript:SeleccionarProceso('busqueda_avanzada_tr.php','<?php echo $base?>')"><?php echo $msgstr["buscar_a"]." - ". $msgstr["tipos_registro"];?></a></li>
			<li><a href="javascript:SeleccionarProceso('presentacion_base.php','<?php echo $base?>')"><?php echo $msgstr["base_home"];?></a></li>
			<?php  }?>
		</ul>
	</li>
	<?php if ($base!="META") { ?>	
	<li><a href="javascript:SeleccionarProceso('dbn_par.php','<?php echo $base?>')"><?php echo $msgstr["dbn_par"];?></a></li>
	<?php  }?>

</ul>

</nav>
