<?php
include ("conf_opac_top.php");
$wiki_help="OPAC-ABCD_Apariencia#Agregar_enlaces_al_men.C3.BA_superior_horizontal";
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

 if (!isset($_SESSION["db_path"])){
	echo "Session expired";die;
}


if (isset($_REQUEST["lang"])) $_SESSION["lang"]=$_REQUEST["lang"];

//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; //die;
$lang=$_REQUEST["lang"];
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	$archivo=$db_path."opac_conf/$lang/".$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			$x=explode('_',$var);
			if ($x[0]=="lk"){
				$link[$x[2]][$x[1]]=$value;
			}


		}
	}
	ksort($link);
	foreach ($link as $l){
		$salida=$l["nombre"]."|".$l["link"]."|";
		if (isset($l["nw"]) and $l["nw"]=="Y")
			$salida.=$l["nw"];
		if ($salida!="") fwrite($fout,$salida."\n");
	}
	fclose($fout);
    ?>
    <h2 class="color-green"><?php echo "opac_conf/".$lang."/".$_REQUEST["file"]." ".$msgstr["updated"];?></h2>
	<?php
}
?>

<?php

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){
	$file="menu.info";
	$path_file=$db_path."opac_conf/".$_REQUEST["lang"]."/".$file;
?>
	   	<h3><?php echo $msgstr["horizontal_menu"];?> (<small><?php echo $path_file;?></small>)</h3>
<?php
	echo "<form name=home"."Frm method=post onSubmit=\"return checkform()\">\n";
	echo "<input type=hidden name=db_path value=".$db_path.">";
	echo "<input type=hidden name=Opcion value=Guardar>\n";
   	echo "<input type=hidden name=file value=\"$file\">\n";
   	echo "<input type=hidden name=lang value=\"$lang\">\n";
   	if (isset($_REQUEST["conf_level"])){
		echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	}
	?>
	<table class="table striped">
	<?php
	echo "<tr><th>".$msgstr["nombre"]."</th><th>".$msgstr["link"]."</th><th>".$msgstr["new_w"]."</th></tr>";
	if (file_exists($path_file)){
		$fp=file($path_file);
	}else{
		$fp=array();
		$fp[]='||';
		$fp[]='||';
		$fp[]='||';
		$fp[]='||';
		$fp[]='||';
	}
	$ix=0;
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$ix=$ix+1;
			$x=explode('|',$value);
			echo "<tr><td><input type=text size=20 name=lk_nombre_$ix value=\"".$x[0]."\"></td>";
			echo "<td><input type=text size=80 name=lk_link_$ix value=\"".$x[1]."\"></td>";
			echo "<td>&nbsp; &nbsp; &nbsp; <input type=checkbox name=lk_nw_$ix value=\"Y\"";
			if (isset($x[2]) and $x[2]=="Y") echo " checked";
			echo "></td>";
			echo"</tr>";
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