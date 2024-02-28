<?php
include ("conf_opac_top.php");
$wiki_help="OPAC-ABCD_Apariencia#Agregar_enlaces_al_men.C3.BA_desplegable_izquierdo";
include "../../common/inc_div-helper.php";
?>

<script>
var idPage="apariencia";
</script>


<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
			<?php include("conf_opac_menu.php");?>
	</div>
	<div class="formContent col-9 m-2">
   	

<?php
//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; //die;

$link=array();
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	$archivo=$db_path."opac_conf/$lang/".$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			$x=explode('_',$var);
			if ($x[0]=="side"){
				$side_bar[$x[2]]=trim($value);
				$sec=$x[2];
			}
			if (isset($sec) and $x[0]=="lk"){
				$link[$sec][$x[3]][$x[1]][$x[2]]=$value;
			}


		}
	}
	//ksort($link);
	foreach ($link as $sec=>$value){
		fwrite($fout,"[SECCION]".$side_bar[$sec]."\n");
		$salida="";
		foreach ($value as $l){
			$salida=$l["nombre"][$sec]."|".$l["link"][$sec]."|";
			if (isset($l["nw"][$sec]) and $l["nw"][$sec]=="Y")
				$salida.=$l["nw"][$sec];
			if ($salida!="") fwrite($fout,$salida."\n");
		}
	}

	fclose($fout);
	?>
    <h2 class="color-green"><?php echo "opac_conf/".$lang."/".$_REQUEST["file"]." ".$msgstr["updated"];?></h2>
	<?php
}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){
	$file="side_bar.info";
	$path_file=$db_path."opac_conf/".$_REQUEST["lang"]."/".$file;
?>
	<h3><?php echo $msgstr["sidebar_menu"];?> (<small><?php echo $path_file;?></small>)</h3>
<?php
	echo "<form name=side"."Frm method=post xonSubmit=\"return checkform()\">\n";
	echo "<input type=hidden name=db_path value=".$db_path.">";
	echo "<input type=hidden name=Opcion value=Guardar>\n";
   	echo "<input type=hidden name=file value=\"$file\">\n";
   	echo "<input type=hidden name=lang value=\"$lang\">\n";
   	if (isset($_REQUEST["conf_level"])){
		echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	}
	if (file_exists($path_file)){
		$fp=file($path_file);
		if (!isset($fp[0]) or $fp[0]!="[SECCION]") $fp[]="[SECCION]";
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
	}else{
		$fp=array();
		$fp[]="[SECCION]";
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]="[SECCION]";
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]="[SECCION]";
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
	}
	$ix=0;
	$ixsec=0;

	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$sec_name="";
			if (substr($value,0,9)=="[SECCION]"){
				$sec_name=substr($value,9);
				if ($ixsec!=0){
					$ix=$ix+1;
					AgregarLineas($ix,$ixsec);
					echo "</table><br><hr><br>";
					$ix=0;
				}
				?>
				<table class="table striped">
				<?php
				$ixsec=$ixsec+1;
				echo "<tr style=\"height:20px;\"><th colspan=2 align=left><strong>".$msgstr["title_sec"]."</strong>&nbsp ";
				echo "<input type=text name=side_sec_$ixsec"."_0 size=20 value=\"$sec_name\"></th></tr>";
				echo "<tr><th>".$msgstr["nombre"]."</th><th>".$msgstr["link"]."</th><th>".$msgstr["new_w"]."</th></tr>";
			}else{
                $ix=$ix+1;
				$x=explode('|',$value);
				echo "<tr><td><input type=text size=20 name=lk_nombre_$ixsec"."_$ix value=\"".$x[0]."\"></td>";
				echo "<td><input type=text size=80 name=lk_link_$ixsec"."_$ix value=\"".$x[1]."\"></td>";
				echo "<td>&nbsp; &nbsp; &nbsp; <input type=checkbox name=lk_nw_$ixsec"."_$ix value=\"Y\"";
				if (isset($x[2]) and $x[2]=="Y") echo " checked";
				echo "></td>";
				echo"</tr>";
			}
		}
	}
?>
		
		</table>
		<button type="submit" class="bt-green m-2"><?php echo $msgstr["save"]; ?></button>
	
	</form>

	<?php } ?>


</div>    
</div>    

<?php include ("../../common/footer.php"); ?>

<?php
function AgregarLineas($ix,$ixsec){
	for ($i=0;$i<4;$i++){
		$ix=$ix+1;
		echo "<tr><td><input type=text size=20 name=lk_nombre_$ixsec"."_$ix value=\"\"></td>";
		echo "<td><input type=text size=80 name=lk_link_$ixsec"."_$ix value=\"\"></td>";
				echo "<td>&nbsp; &nbsp; &nbsp; <input type=checkbox name=lk_nw_$ixsec"."_$ix value=\"Y\"";
				echo "></td>";
				echo"</tr>";
	}
}