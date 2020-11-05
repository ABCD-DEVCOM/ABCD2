<?php
//VERIFICAR SI EL ../php/config_opac.php apunta correctamente al config.php de ABCD
echo "<font face=arial>\n";
$lang="en";
$config_php="";
$db_path="";
$abcd_scripts="";
$url="";
$no_err=0;
$fp=file("../php/config_opac.php");
$msg_err="";
$primera_vez="";
foreach ($fp as $value){	if ($config_php!="" and $abcd_scripts!="" and $url!="") break;	$value=trim($value);
	if ($value!=""){		if (substr($value,0,7)=="include" and $config_php==""){			if ($config_php==""){				$ix=strpos($value,'"');
				$config_php=substr($value,$ix+1);
				$ix=strpos($config_php,'"');
				$config_php=substr($config_php,0,$ix);
				if (file_exists($config_php)){					$msg_err= "<br>Path to <strong>config.php</strong> of ABCD is OK<br>";
					$no_err=$no_err+1;
				}else{					$msg_err= "<br>Error. Script not found <strong>$config_php</strong>. Please check the <strong>include</strong> path in /php/config_opac.php<br>";
				}
				continue;
			}
		}

	}}
include("../php/config_opac.php");
echo "<h1>"."php/config_opac.php verification &nbsp; &nbsp;";
echo  "<font color=blue size=2><a href='http://wiki.abcdonline.info/OPAC-ABCD_Tutorial_de_configuraci%C3%B3n' target=_blank>HELP</a></font></h1>";
echo $msg_err;
echo "<br>Please check the parameter <strong><a href=$server_url target=_blank>server_url</a></strong><p>";
if (is_dir($ABCD_scripts_path)){
	echo "path to <strong>$ABCD_scripts_path</strong> is ok<br>";
	$no_err=$no_err+1;
}else{
	echo "Error. Path not found <strong>$ABCD_scripts_path</strong>. ".'Please check the parameter <strong>$ABCD_scripts_path</strong> in /php/config_opac.php <br>';
}
$archivo=$ABCD_scripts_path."central/dataentry/wxis/opac";
if (!is_dir($archivo)){	echo "<h2><font color=red>Fatal error. <font color=black>dataentry/wxis/opac<font color=red> folder not found";
	die;}else{
    $no_err=$no_err+1;	echo "<br><strong>dataentry/wxis/opac</strong> folder OK";}
if ($no_err<>3){
	echo "<h2><font color=red>Fatal error. Verification ended</h2>";
	die;
}
?>
<html>
<meta http-equiv="content-type" content="text/html; charset=<?php echo $charset?>" />
<body>

<?php
$opac_conf="";
$err="";
//check the opac_conf

echo "<h2>Checking <strong>$db_path"."opac_conf</strong> folder</h2>";
$opac_conf=$db_path."opac_conf";
if (!is_dir($opac_conf)){	echo   "Error. Missing $db_path"."opac_conf folder";
	$opac_conf="";
}
$dir_arr=array();
if ($opac_conf!=""){

	if (!file_exists($opac_conf."/opac_abcd.def")){		echo "Error. opac_abcd.def missing<br>";	}else{		echo "opac_abcd.def OK<br>";	}
	if (!file_exists($opac_conf."/select_record.pft")){
		echo "Error. select_record.pft missing (".$msgstr["rtb"].")<br>";
	}else{
		echo "select_record.pft (".$msgstr["rtb"].") OK<br>";
	}	$handle=opendir($opac_conf);
	$arr_dir=readdir($handle);
	while (false !== ($entry = readdir($handle))) {		if (is_dir($opac_conf."/$entry")){
			if ($entry!="." and $entry!="..")
				$dir_arr[]=$entry;		}
	}
}
if (count($dir_arr)==0){	echo "Error: No languages defined";
	$err="S";}
foreach ($dir_arr as $lang){	echo "<h3>Checking <strong><font color=red>$lang</font></strong> folder</h3>";
	if (!file_exists($opac_conf."/$lang/lang.tab")){		echo "Error. <strong>lang.tab</strong> missing<br>";
		$err="S";	}else{		echo "<p><strong>lang.tab</strong><br>";
		$fp=file($opac_conf."/$lang/lang.tab");
		foreach ($fp as $lang_dat){
			echo "$lang_dat";
			$l=explode("=",$lang_dat);
			if (!is_dir($opac_conf."/".$l[0])){				echo "&nbsp; &nbsp; &nbsp; Error. Missing folder $opac_conf/".$l[0];			}
			echo "<br>";
		}	}
	if (!file_exists($opac_conf."/$lang/bases.dat")){		echo "Error. <strong>bases.dat</strong> missing<br>";
		$err="S";
	}else{		echo "<p><strong>bases.dat</strong><br>";
		$fp=file($opac_conf."/$lang/bases.dat");		foreach ($fp as $base_dat){			echo "$base_dat<br>";
		}
		foreach ($fp as $base_dat){			$b=explode('|',$base_dat);
			$base=$b[0];
			$base_desc=$b[1];
			//Se lee el archivo .par
			$par_array=array();
			$archivo=$db_path."par/$base.par";
			if (!file_exists($archivo)){
				echo "Error: missing $archivo<br>";
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
			echo "<p><font color=blue><strong>Checking $base ($base_desc)</strong></font><br>";
			$archivo=$opac_conf."/$lang/$base".".def";
			if (!file_exists($archivo)){
				echo "Error. File <strong>$base".".def</strong> not found<br>";
				$err="S";
			}else{
				echo "File $base".".def OK<br>";
			}
			$archivo=$opac_conf."/$lang/$base"."_libre.tab";
			if (!file_exists($archivo)){
				echo "Error. File <strong>$base"."_libre.tab</strong> (".$msgstr["free_search"].") not found<br>";
				$err="S";
			}else{
				echo "File $base"."_libre.tab (".$msgstr["free_search"].")  OK<br>";
			}
			$archivo=$opac_conf."/$lang/$base"."_avanzada.tab";
			if (!file_exists($archivo)){				echo "Error. File <strong>$base"."_avanzada.tab (".$msgstr["buscar_a"].")</strong> not found<br>";
				$err="S";			}else{				echo "File $base"."_avanzada.tab (".$msgstr["buscar_a"].") OK<br>";			}
			$archivo=$opac_conf."/$lang/$base"."_formatos.dat";
			if (!file_exists($archivo)){
				echo "Error. File <strong>$base"."_formatos.dat</strong> (".$msgstr["select_formato"].") not found<br>";
				$err="S";
			}else{
				echo "File $base"."_formatos.dat (".$msgstr["select_formato"].")  OK<br>";
				echo "<strong>Checking formats in $base.par</strong><br>";
				$pfts=file($archivo);
				$pfts[]="autoridades_opac|";
				$pfts[]="select_record|";
				echo "<table border=1 cellpadding=5>";
				echo "<tr><th>Format </th><th>$base.par</th><th>Format path</th></tr>";
				foreach ($pfts as $linea){					$linea=trim($linea);
					if ($linea!=""){
						echo "<tr>";						$p=explode('|',$linea);
						echo "<td>".$p[0]." - ".$p[1]."</td>";						if (!isset($par_array[$p[0].".pft"])){							echo "<td><font color=red>Missing in $base.par</font></td><td></td>";						}else{							echo "<td>".$par_array[$p[0].".pft"]."</td>";
							$path=str_replace('%path_database%',$db_path,$par_array[$p[0].".pft"]);
							$path=str_replace('%lang%',$lang,$path);
							echo "<td>$path";
							if (!file_exists($path)){								echo "<br><font color=red>Missing file $path</font>";							}
							echo "</td>";						}
						echo "</tr>\n";					}				}
			}
			echo "</table>";		}	}}
echo "<a href=http://wiki.abcdonline.info/OPAC-ABCD_Tutorial_de_configuraci%C3%B3n target=_blank>HELP</a><p>";
?>