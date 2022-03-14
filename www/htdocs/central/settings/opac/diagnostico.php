<?php
$wiki_help="OPAC-ABCD_Detalles_de_la_configuraci%C3%B3n#Verificar_la_configuraci.C3.B3n";

$config_php="";
$db_path="";
$abcd_scripts="";
$url="";
$no_err=0;

$fp=file("../../config_opac.php");
if (isset($_REQUEST["db_path"])) $db_path=$_REQUEST["db_path"];
if (isset($_REQUEST["lang"])) $lang=$_REQUEST["lang"];
$msg_err="";
$primera_vez="";

foreach ($fp as $value){

	if ($config_php!="" and $abcd_scripts!="" and $url!="") break;
	$value=trim($value);


	if ($value!=""){

		if (substr($value,0,8)=="include" and $config_php==""){
			if ($config_php==""){
				$ix=strpos($value,'"');
				$config_php=substr($value,$ix+1);
				$ix=strpos($config_php,'"');
				$config_php=substr($config_php,0,$ix);
				if (!file_exists($config_php)){
					$dir= $_SERVER['PHP_SELF'];
					$ix=strpos($dir,'/index.php');
					$dir=substr($dir,0,$ix);
					header('Content-Type: text/html; charset="utf-8">');
					echo "<html>";
					echo "<body>";
				
					echo "<font color=red face=arial size=4>Error. Script not found <strong>config_php</strong> in <strong>ABCD central folder</strong>.<br><br>";
					echo "Please check the <strong>include</strong> path in <strong><font color=black>central/config_opac.php</font></strong> ";
					echo "(Actual include path: $config_php)<br><br>The <strong>include</strong> Must contain the full path to ABCD config.php script";
					echo "<br><br><strong>See tutorial, item 5</strong>";
					echo "<div id=\"help_01\" style=\"display:block;margin:auto;width:100%;xheight:150px; position:relative;border:1px solid black;\">
					    <iframe style=\"width:100%; height:350px; border:0\" src=http://wiki.abcdonline.info/OPAC-ABCD_Tutorial_de_configuraci%C3%B3n>

						</iframe>
					</div>";
					echo "</body></html>";
					die;
				}
			}
		}

	}
}

if ($no_err>0) die;

$no_err=0;
$diagnostico="S";
include ("tope_config.php");

	include "../../common/inc_div-helper.php";
?>


<div class="middle form">

   <h3>Diagnosis of OPAC settings</h3>

	<div class="formContent">

<div id="page">

	<h4><?php echo $msgstr['cfg_chk'];?> config_opac.php</h4>

	<p><?php echo $msgstr['cfg_click'] ?><strong> <a href="<?php echo $server_url;?>" target="_blank">$server_url</a></strong></p>


<?php
if (is_dir($ABCD_scripts_path)){
	echo "<p>".$msgstr['cfg_pathto']." <strong>$ABCD_scripts_path</strong>  <i class=\"fas fa-check color-green\"></i></p>";

}else{
	echo "<p>".$msgstr['cfg_errorpath']." <strong>".$ABCD_scripts_path."</strong>".$msgstr['cfg_chk_param']."<strong>$ABCD_scripts_path</strong> in /php/config_opac.php </p>";
	$no_err=$no_err+1;
}

$archivo=$ABCD_scripts_path."central/dataentry/wxis/opac";

if (!is_dir($archivo)){
	echo "<p class='color-red'><b>".$msgstr['cfg_fatal']." dataentry/wxis/opac folder not found</b></p>";
	die;
}else{
    echo "<p><strong>dataentry/wxis/opac</strong> <i class=\"fas fa-check color-green\"></i></p>";
}
if ($no_err<>0){
	echo "<p class='color-red'><b>".$msgstr['cfg_fatal']." ".$msgstr['cfg_ended']."</b></p>";
	die;
}
$opac_conf="";
$err="";

echo "<hr><h3>".$msgstr['cfg_chk_folder']." ".$db_path."opac_conf </h3><p>";
$opac_conf=$db_path."opac_conf";
if (!is_dir($opac_conf)){
	echo   "Error. Missing $db_path"."opac_conf folder<br>";
	$opac_conf="";
}
$dir_arr=array();
if ($opac_conf!=""){
    if (!file_exists($opac_conf."/opac.def")){
		echo "Error. opac.def missing<br>";
	}else{
		echo "opac.def <i class=\"fas fa-check color-green\"></i><br>";
	}
	if (!file_exists($opac_conf."/select_record.pft")){
		echo "Error. select_record.pft missing (".$msgstr["rtb"].")<br>";
	}else{
		echo "select_record.pft (".$msgstr["rtb"].") <i class=\"fas fa-check color-green\"></i><br>";
	}
	$handle=opendir($opac_conf);
	$arr_dir=readdir($handle);
	while (false !== ($entry = readdir($handle))) {
		if (is_dir($opac_conf."/$entry")){
			if ($entry!="." and $entry!="..")
				$dir_arr[]=$entry;
		}
	}
}
if (count($dir_arr)==0){
	echo "Error: No languages defined<br>";
	$err="S";
}
foreach ($dir_arr as $lang){
	echo "<br><h3>".$msgstr['cfg_chk_folder']." <strong><font color=red>$lang</font></strong></h3>";
	if (!file_exists($opac_conf."/$lang/lang.tab")){
		echo "Error. <strong>lang.tab</strong> missing<br>";
		$err="S";
	}else{
		echo "<p><strong>lang.tab</strong><br>";
		$fp=file($opac_conf."/$lang/lang.tab");
		foreach ($fp as $lang_dat){
			echo "$lang_dat";
			$l=explode("=",$lang_dat);
			if (!is_dir($opac_conf."/".$l[0])){
				echo "&nbsp; &nbsp; &nbsp; Error. Missing folder $opac_conf/".$l[0];
			}
			echo "<br>";
		}
	}
	if (!file_exists($opac_conf."/$lang/bases.dat")){
		echo "Error. <strong>bases.dat</strong> missing<br>";
		$err="S";
	}else{
		echo "<p><strong>bases.dat</strong><br>";
		$fp=file($opac_conf."/$lang/bases.dat");
		foreach ($fp as $base_dat){
			if (trim($base_dat)!="")
				echo "$base_dat<br>";
		}
		foreach ($fp as $base_dat){
            $base_dat=trim($base_dat);
            if ($base_dat=="") continue;
			$b=explode('|',$base_dat);
			$base=$b[0];

			$base_desc=$b[1];
			//Se lee el archivo .par
			$par_array=array();
			$archivo=$db_path."par/$base.par";
			if (!file_exists($archivo)){
				echo "Error: ".$msgstr["missing"]." $archivo<br>";
			}else{
				$par=file($archivo);
				foreach($par as $value) {
					$value=trim($value);
					if ($value!=""){
						$p=explode('=',$value);
						$par_array[$p[0]]=$p[1];
					}
				}
			}
			echo "<hr><h3><font color=blue>".$msgstr['cfg_chk']." ".$base ." (".$base_desc.") - ".$lang."</font></h3>";
			if (!is_dir($db_path.$base)){
	 			echo "<font color=red size=3><strong>".$msgstr["missing_folder"]." $base ".$msgstr["in"]." $db_path</strong></font><br>";
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
			}
			echo "<p><strong>".$msgstr['cfg_param_db']."</strong></p>";
			if (!isset($dr_parms["UNICODE"]))
				echo "<p class='color-red'>".$msgstr['cfg_empty_unicod']."</p>";
			else
				echo "UNICODE = ".$dr_parms["UNICODE"]."<BR>";
	        if (!isset($dr_parms["CISIS_VERSION"]))
				echo "<p class='color-red'>The CISIS_VERSION parameter is not set. Assumed 16-60</p>";
			else
				echo "CISIS_VERSION = ".$dr_parms["CISIS_VERSION"]."<BR>";
	        echo "<i>These parameters can be updated in the central module</i><br>";
			echo "<BR><strong>"."Verifying the database configuration</strong><br>";
			$archivo=$opac_conf."/$lang/$base".".def";
			if (!file_exists($archivo)){
				echo $msgstr['cfg_file']." <strong>$base".".def</strong> <i class=\"fas fa-times color-red\"></i><br>";
				$err="S";
			}else{
				echo $msgstr['cfg_file']." $base".".def <i class=\"fas fa-check color-green\"></i><br>";
			}
			$archivo=$opac_conf."/$lang/$base"."_libre.tab";
			if (!file_exists($archivo)){
				echo $msgstr['cfg_file']." <strong>$base"."_libre.tab</strong> (".$msgstr["free_search"].") <i class=\"fas fa-times color-red\"></i>";

					if ($_SESSION['lang']==$lang) {
						echo " <a href=javascript:SeleccionarProceso('busqueda_libre.php','$base')>".$msgstr['cfg_create']."</a>";
					}
				echo "</p>";	
				
				$err="S";
			}else{
				echo $msgstr['cfg_file']." $base"."_libre.tab (".$msgstr["free_search"].")  <i class=\"fas fa-check color-green\"></i><br>";
			}
			$archivo=$opac_conf."/$lang/$base"."_avanzada.tab";
			if (!file_exists($archivo)){
				echo $msgstr['cfg_file']." <strong>$base"."_avanzada.tab (".$msgstr["buscar_a"].")</strong> <i class=\"fas fa-times color-red\"></i>";

					if ($_SESSION['lang']==$lang) {
						echo " <a href=javascript:SeleccionarProceso('busqueda_avanzada.php','$base')>".$msgstr['cfg_create']."</a>";
					}
				echo "</p>";	
				$err="S";
			}else{
				echo $msgstr['cfg_file']." $base"."_avanzada.tab (".$msgstr["buscar_a"].") <i class=\"fas fa-check color-green\"></i><br>";
			}
			$archivo=$opac_conf."/$lang/$base"."_formatos.dat";
			if (!file_exists($archivo)){
				echo "File <strong>$base"."_formatos.dat</strong> (".$msgstr["select_formato"].") <i class=\"fas fa-times color-red\"></i><br>";
				$err="S";
			}else{
				echo "File $base"."_formatos.dat (".$msgstr["select_formato"].")  <i class=\"fas fa-check color-green\"></i><br>";
				echo "<p><strong>Checking formats in $base.par</strong><br>";
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

			echo "</table>";
			echo "<p><strong>Checking XML configuration</strong><p>" ;
			$archivo=$opac_conf."/marc_sch.xml";
			if (!file_exists($archivo)){
				echo "XML default marc schema not configured";
				die;
			}

		}
	}
}

?>
</div>
</div>
</div>

<?php include ("../../common/footer.php"); ?>