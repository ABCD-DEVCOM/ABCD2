<?php
$n_wiki_help="docs/es/6-opac/more-config";
$config_file="../../config_opac.php";

include "../../config_opac.php";
$no_err=0;
include ("conf_opac_top.php");
include "../../common/inc_div-helper.php";
?>

<script>
	var idPage="general";

function Update(Option){
	if (document.update_base.base.value==""){
		alert("<?php echo $msgstr["seldb"]?>")
		return
	}
	switch (Option){
		case "dr_path":
			document.update_base.Opcion.value="dr_path"
			document.update_base.action="../editar_abcd_def.php"
			break;
	}
	document.update_base.submit()
}


</script>





<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
			<?php include("conf_opac_menu.php");?>
	</div>
	<div class="formContent col-9 m-2">

   <h3>Diagnosis of OPAC settings</h3>
	
	<!--/central/config_opac.php-->
	<p>
		<?php echo $msgstr['cfg_chk']."...: ";
		$fp=file($config_file);
		if (file_exists($config_file)){
			echo "<b>".$config_file."</b> <i class=\"fas fa-check color-green\"></i>";
		}else{
			echo "Error. ".$config_file." missing";
		}

		foreach ($fp as $value){
			$value=trim($value);
			echo $value;
		}
		?>
	</p>

	<!--/ABCD2/www/bases/opac_conf -->
	<p>
		<?php
		$err="";
		echo $msgstr['cfg_chk_folder']." opac_conf: ";

		$opac_conf=$db_path."opac_conf";
		if (!is_dir($opac_conf)){
			echo   "Error. Missing $db_path"."opac_conf folder<br>";
			$opac_conf="";
		} else {
			echo "<b>".$db_path."opac_conf</b> <i class=\"fas fa-check color-green\"></i>";
		}
		?>
	</p>

	<!--/ABCD2/www/bases/opac_conf/opac.def -->
	<p>
	<?php
		$opac_def=$opac_conf."/opac.def";
		if (!file_exists($opac_def)){
			echo "Error. ".$opac_def." missing<br>";
		}else{
			echo "<p>opac.def: <b>".$opac_def."</b> <i class=\"fas fa-check color-green\"></i></p>";
		}
		?>
	</p>

	<!--opac.def -> OpacHttp -->
	<p>
		<?php echo $msgstr['cfg_click'] ?>: <b> $OpacHttp: <a href="<?php echo $opac_gdef['OpacHttp'];?>" target="_blank"><?php echo $opac_gdef['OpacHttp'];?></a></b>
	</p>

	<!--/htdocs/opac -->
	<p>
		<?php
		if (is_dir($ABCD_scripts_path.$opac_path)){
			echo $msgstr['cfg_pathto'].":  <b>".$ABCD_scripts_path.$opac_path."</b>  <i class=\"fas fa-check color-green\"></i>";
		}else{
			echo $msgstr['cfg_errorpath'].":  <b>".$ABCD_scripts_path."</b>".$msgstr['cfg_chk_param']."<b>".$ABCD_scripts_path.$opac_path."</b> in /php/config_opac.php";
			$no_err=$no_err+1;
		}
		?>
	</p>

	<!--/htdocs/central/dataentry/wxis/opac  -->
	<p>
		<?php
		$archivo=$xWxis."opac";
		if (!is_dir($archivo)){
			echo "<span class='color-red'><b>".$msgstr['cfg_fatal']." dataentry/wxis/opac folder not found</b></span>";
			die;
		}else{
			echo "WXIS Scripts: <b>dataentry/wxis/opac</b> <i class=\"fas fa-check color-green\"></i>";
		}
		?>
	</p>

	<?php
	echo "<br><p>".$msgstr["rtb"].": </p><ul>";

$dir_arr=array();
if ($opac_conf!=""){

	$handle=opendir($opac_conf);
	$arr_dir=readdir($handle);
	while (false !== ($entry = readdir($handle))) {
		//echo $opac_conf;
		if (is_dir($opac_conf."/$entry")){
			if (($entry!=".") and ($entry!="..") and ($entry!="alpha")){
				$dir_arr[]=$entry;
				$file_select=$opac_conf."/".$entry."/select_record.pft";
				if (!file_exists($file_select)){
					echo "<li>".$file_select. "</b> Error. select_record.pft missing</li>";
				}else{
					echo "<li>".$file_select."</b> <i class=\"fas fa-check color-green\"></i></li>";
				}
			}
		}
	}
}	
	echo "</ul>"
	?>


	<hr>


	<!--Actual bases.dat -->
	<p>
		<?php
		$opac_bases=$opac_conf."/".$lang."/bases.dat";
		echo "<p><b>".$opac_bases."</b></p>";
		$fp=file($opac_bases);
		foreach ($fp as $base_dat){
			if (trim($base_dat)!="")
				echo "<pre>$base_dat</pre>";
				$b=explode('|',$base_dat);
				$base=$b[0];
				$base_desc=$b[1];	
				$opac_db[$b[0]]=$db_path.$base."/opac/";	
		} // exibe lista de bases
		?>
	</p>

	<?php
	if (count($dir_arr)==0){
		echo "Error: No languages defined<br>";
		$err="S";
	}
	?>

<hr>

<?php 
	foreach ($dir_arr as $lang) { 
		$lang_tab=$opac_conf."/".$lang."/lang.tab";
	?>
 
	<p><?php echo $msgstr['cfg_chk_folder'];?><b> <?php echo $lang_tab;?></b></p>
	<?php
		
		if (!file_exists($lang_tab)){
			echo "Error. <b>lang.tab</b> missing<br>";
			$err="S";
		}else{
			$fp=file($opac_conf."/$lang/lang.tab");
			foreach ($fp as $lang_dat){
				echo "<p>".$lang_dat;
				$l=explode("=",$lang_dat);
				if (!is_dir($opac_conf."/".$l[0])){
					echo "<b class='color-red'>Error. Missing folder $opac_conf/".$l[0]."</b>";
				}
				echo "</p>";
			}
		}
		echo "<br><br>";
	}
	?>

<hr>
<h4>Checking for the existence of the bases.dat file - responsible for enabling the databases in each language.</h4>
<?php
 foreach ($dir_arr as $lang) { 
	$f_bases_dat=$opac_conf."/".$lang."/bases.dat";
	$fp=file($f_bases_dat);
	
	if (!file_exists($f_bases_dat)){
		echo "Error. <b>".$f_bases_dat."</b> missing<br>";
		$err="S";
	} else {
		echo "<p>".$lang." - ".$f_bases_dat."</p>";
	}	
 }
 ?>
<hr>
<h4>Databases in

<?php
 foreach ($dir_arr as $lang) { 
		$lang_tab=$opac_conf."/".$lang."/lang.tab";
		$lang_file=file($lang_tab);
		
		foreach ($lang_file as $lang_dat) {
		$lang_dat=trim($lang_dat);
           
		$blang=explode('=',$lang_dat);

		if (($lang==$blang[0]) and ($lang==$_REQUEST['lang']))  { 
			echo $blang[1].'</h4>'; 

		foreach ($fp as $base_dat) {
            $base_dat=trim($base_dat);
            if ($base_dat=="") continue;
			$b=explode('|',$base_dat);
			$base=$b[0];
			$base_desc=$b[1];

			//Se lee el archivo .par
			$par_array=array();
			$archivo=$db_path.$actparfolder."/".$base.".par";
			if (!file_exists($archivo)){
				echo "Error: ".$msgstr["missing"]." $archivo<br>";
			} else {
				$par=file($archivo);
				foreach($par as $value) {
					$value=trim($value);
					if ($value!=""){
						$p=explode('=',$value);
						$par_array[$p[0]]=$p[1];

					}
				}
			}

			$opac_db=$db_path.$base."/opac/";
			
			?>
			
			<h3><?php echo $base_desc." (".$base.")";?></h3>

			<?php
			if (!is_dir($db_path.$base)){
	 			echo "<font color=red size=3><b>".$msgstr["missing_folder"]." $base ".$msgstr["in"]." $db_path</b></font><br>";
	 		}

	 		$file_dr=$db_path.$base."/dr_path.def";
	 		$dr_parms=array();
			
			if (file_exists($file_dr)){
				$fp_dr=file($file_dr);

				foreach ($fp_dr as $dr_line) {
					$dr_line=trim($dr_line);

					if ($dr_line!=""){
						$drl=explode("=",$dr_line);
						$dr_parms[$drl[0]]=$drl[1];
					}

				}
			} else {
				echo '<a href="javascript:Update(\'dr_path\')"><h2 class="color-red">Attention! Create the file dr_path.def!</h1></a>';
			?>

			<form name=update_base onSubmit="return false" method=post>
			<input type=hidden name=Opcion value=update>
			<input type=hidden name=type value="">
			<input type=hidden name=modulo>
			<input type=hidden name=format>
			<input type=hidden name=base value=<?php echo $base;?>>
			<?php if (isset($arrHttp["encabezado"])) echo "<input type=hidden name=encabezado value=s>";?>
			</form>
			<?php
			}
			
			echo "<p><b>".$msgstr['cfg_param_db']."</b></p>";
			if (!isset($dr_parms["UNICODE"]))
				echo "<p class='color-red'>".$msgstr['cfg_empty_unicod']."</p>";
			else
				echo "UNICODE = ".$dr_parms["UNICODE"]."<BR>";
	        if (!isset($dr_parms["CISIS_VERSION"]))
				echo "<p class='color-red'>The CISIS_VERSION parameter is not set. Assumed 16-60</p>";
			else
				echo "CISIS_VERSION = ".$dr_parms["CISIS_VERSION"]."<br>";
	        echo "<i>These parameters can be updated in the central module</i><br>";
			?>

			<br><b><?php echo $msgstr['cfg_chk_folder']." ".$opac_db.$lang; ?></b>
			<?php
			$archivo=$opac_db.$lang."/".$base.".def";
						if (!file_exists($archivo)){
				echo $msgstr['cfg_file'].": ".$archivo ." <i class=\"fas fa-times color-red\"></i><br>";
				$err="S";
			} else {
					echo "<li>".str_replace($opac_db.$lang.'/','',$archivo) ." <i class=\"fas fa-check color-green\"></i></li>";
			}

			foreach (glob($opac_db.$lang."/".$base.'_libre*.*') as $filename) {
				$archivo=$filename;
				if (!file_exists($archivo)){
					echo $msgstr['cfg_file'].": ".$archivo ." (".$msgstr["free_search"].") <i class=\"fas fa-times color-red\"></i>";

						if ($_SESSION['lang']==$lang) {
							echo " <a href=javascript:SeleccionarProceso('edit_form_search.php','$base','libre')>".$msgstr['cfg_create']."</a>";
						}
					echo "</p>";	
					
					$err="S";
				}else{
					echo "<li>".str_replace($opac_db.$lang.'/','',$archivo) ." <i class=\"fas fa-check color-green\"></i></li>";
				}
			}

			foreach (glob($opac_db.$lang."/".$base.'_avanzada*.*') as $filename) {
				$archivo=$filename;
				if (!file_exists($archivo)){
					echo $msgstr['cfg_file'].": ".$archivo ." (".$msgstr["buscar_a"].")</b> <i class=\"fas fa-times color-red\"></i>";

						if ($_SESSION['lang']==$lang) {
							echo " <a href=javascript:SeleccionarProceso('edit_form_search.php','$base','avanzada')>".$msgstr['cfg_create']."</a>";
						}
					echo "</p>";	
					$err="S";
				}else{
					echo "<li>".str_replace($opac_db.$lang.'/','',$archivo) ." <i class=\"fas fa-check color-green\"></i></li>";
				}
			}

			foreach (glob($opac_db.$lang."/".$base.'*.ix') as $filename) {
				$archivo=$filename;
				if (!file_exists($archivo)){
					echo $msgstr['cfg_file'].": ".$archivo ." (".$msgstr["free_search"].") <i class=\"fas fa-times color-red\"></i>";

						if ($_SESSION['lang']==$lang) {
							echo " <a href=javascript:SeleccionarProceso('edit_form_search.php','$base','libre')>".$msgstr['cfg_create']."</a>";
						}
					echo "</p>";	
					
					$err="S";
				}else{
					echo "<li>".str_replace($opac_db.$lang.'/','',$archivo) ." <i class=\"fas fa-check color-green\"></i></li>";
				}
			}

			$archivo=$opac_db.$lang."/".$base."_formatos.dat";
			if (!file_exists($archivo)){
				echo $msgstr['cfg_file'].": ".$archivo ." (".$msgstr["select_formato"].") <i class=\"fas fa-times color-red\"></i><br>";
				$err="S";
			}else{
					echo "<li>".str_replace($opac_db.$lang.'/','',$archivo) ." <i class=\"fas fa-check color-green\"></i></li>";
				echo "<br><p><b>Checking formats in ".$actparfolder.$base.".par</b><br>";
				$pfts=file($archivo);
				$pfts[]="autoridades_opac|";
				$pfts[]="select_record|";
				echo '<table class="striped">';
				echo "<tr><th>Format </th><th>$base.par</th><th>Format path</th></tr>";
				foreach ($pfts as $linea){
					$linea=trim($linea);
					if ($linea!=""){
						echo "<tr>";
						$p=explode('|',$linea);
						echo "<td>".$p[0].".pft - ".$p[1]."</td>";
						if (!isset($par_array[$p[0].".pft"])){
							echo "<td><font color=red>Missing in $base.par</font>";
							if ($p[0]=="autoridades_opac"){
									echo "<br>Is required in the advanced configuration";
							}
							echo "</td><td></td>";
						}else{
							echo "<td>".$par_array[$p[0].".pft"]."</td>";
							$path=str_replace('%path_database%',$db_path,$par_array[$p[0].".pft"]);
							$path=str_replace('%lang%',$lang,$path);
							echo "<td>$path";
							if (!file_exists($path)){
								echo "<br><font color=red>Missing file $path</font>";

							}
							echo "</td>";
						}
						echo "</tr>\n";
					}
				}
			}
?>
			</table>

			<br><p><b>Checking XML configuration</b><p>
			<?php
			$archivo=$opac_db."marc_sch.xml";
			//echo $archivo;
			if (!file_exists($archivo)){
				echo $archivo." - XML default marc schema not configured";
			} else {
				echo $msgstr['cfg_file'].": ".$archivo ." <i class=\"fas fa-check color-green\"></i><br>";
			}
				echo "<hr>";

		}
		}
		

	}

 }
?>


</div>
</div>

<?php include ("../../common/footer.php"); ?>