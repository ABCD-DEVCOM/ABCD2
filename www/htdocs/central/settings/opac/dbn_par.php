<?php
/*
20230305 rogercgui Adds the variable $actparfolder;

*/

include ("tope_config.php");
$wiki_help="OPAC-ABCD_Configuraci%C3%B3n_de_bases_de_datos#Edici.C3.B3n_del_dbn.par";
include "../../common/inc_div-helper.php";

?>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
			<?php include("menu_bar.php");?>
	</div>
	<div class="formContent col-9 m-2">
	<h3><?php  echo $msgstr["dbn_par"];?></h3>

<?php

//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";

if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	$archivo=$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			if ($var=="conf_dbnpar"){
				fwrite($fout,$value."\n");
				fclose($fout);
			?>
				<p class="color-green"><strong><?php echo $archivo." ".$msgstr["updated"];?></strong></p>
			<?php
			}
		}
	}

}else{
	$base=$_REQUEST["base"];
	$archivo=$db_path.$actparfolder."$base.par";
	if (!file_exists($archivo)){
		echo "Error: missing $archivo<br>";
	}else{
		$pft_noinc=array();
		$par=file($archivo);
		foreach($par as $value) {
			$value=trim($value);
			if ($value!=""){
				$p=explode('=',$value);
				$par_array[$p[0]]=$p[1];
			}
		}
		$archivo=$db_path.$base."/opac/$lang/$base"."_formatos.dat";
		if (!file_exists($archivo)){
			echo "Error. File <strong>$base"."_formatos.dat</strong> (".$msgstr["select_formato"].") not found<br>";
			$err="S";
		}else{
			echo "File $base"."_formatos.dat (".$msgstr["select_formato"].")  OK<br>";
			echo "<p><strong>Checking formats in $base.par</strong><br>";
			$pfts=file($archivo);
			$pfts[]="autoridades_opac|";
			$pfts[]="select_record|";
			echo "<table border=1 cellpadding=5>";
			echo "<tr><th>".$base."_formatos.dat</th><th>$base.par</th><th>Format path</th></tr>";

			foreach ($pfts as $linea){
				$linea=trim($linea);
				if ($linea!=""){
					echo "<tr>";
					$p=explode('|',$linea);
					echo "<td>".$p[0].".pft - ".$p[1]."</td>";
					$pft_name=$p[0];
					if (!isset($par_array[$pft_name.".pft"])){
						echo "<td><font color=red>Missing in $base.par</font>";
						$pft_noinc[]=$pft_name;
						if ($pft_name=="autoridades_opac"){
							echo "<br>Is required in the advanced configuration";
						}
						echo "</td>";
						if ($pft_name=="select_record")
							$path=$db_path."opac_conf/$lang/$pft_name.pft";
						else
							if ($pft_name=="autoridades_opac")
							    $path=$db_path.$base."/pfts/autoridades_opac.pft";
							else
								$path=$db_path.$base."/pfts/$lang/$pft_name.pft";
					}else {
						$path=str_replace('%path_database%',$db_path,$par_array[$p[0].".pft"]);
						$path=str_replace('%lang%',$lang,$path);
						echo "<td>".$pft_name.".pft"."</td>";
					}

					echo "<td>$path";
					if (!file_exists($path)){
						echo "<br><font color=red>Missing file $path</font>";
        			}
					echo "</td>";
					echo "</tr>\n";
				}
			}
			echo "</table>";
		}
		if (count($pft_noinc)>0){
			echo "<hr><h4>Adding missing files to $base.par</h4>";
			foreach ($pft_noinc as $value){
				$value=trim($value);
				if ($value!=""){
					if ($value=="select_record"){
						$par_array[$value.".pft"]="%path_database%opac_conf/%lang%/$value.pft";
					}else{
						if ($value=="autoridades_opac")
							$par_array[$value.".pft"]="%path_database%$base/pfts/$value.pft";
						else
							$par_array[$value.".pft"]="%path_database%$base/pfts/%lang%/$value.pft";
					}
					echo $value.".pft=".$par_array[$value.".pft"]. " added<br>";
				}
			}
			echo "<hr>";
		}
		$file=$db_path.$actparfolder."$base.par";
		echo "<strong>".$msgstr["edit"].": ". $file."</strong>";
		echo "<div  style=\"display:block;\">\n";
		echo "<form name=savepar"."Frm method=post>\n";
		echo "<input type=hidden name=Opcion value=Guardar>\n";
    	echo "<input type=hidden name=base value=$base>\n";
    	echo "<input type=hidden name=file value=\"$file\">\n";
    	echo "<input type=hidden name=lang value=\"$lang\">\n";
    	if (isset($_REQUEST["conf_level"])){
			echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
		}
		echo "<textarea name=conf_dbnpar rows=20 cols=100>";
		foreach ($par_array as $key=>$value){
			echo "$key=$value\n";
		}
		echo "</textarea>";
		echo "<p><input class='bt-green' type=submit value=\"".$msgstr["save"]." "."\">";
		echo "</form></div>";
	}

?>

</div>
</div>

<?php include ("../../common/footer.php"); ?>

<?php	
}
die;
?>



