<?php
include ("tope_config.php");
$wiki_help="OPAC-ABCD_Barra_de_Herramientas";
include "../../common/inc_div-helper.php";
?>


<div class="middle form">

   <h3><?php echo $msgstr["rtb"]." &nbsp;";?></h3>

	<div class="formContent">

<div id="page">

<?php
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
	

if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	$fp=file($_REQUEST["archivo"]);
	$archivo=$db_path."opac_conf/".$_REQUEST["archivo"];
	$fout=fopen($archivo,"w");
	foreach ($fp as $value){
		fwrite($fout,$value);

	}
	fclose($fout);

	echo "<p><font color=red>". $archivo." ".$msgstr["updated"]."</font><p>";
   
    echo "<p><h3>".$msgstr["add_topar"]." (".$msgstr["in_all"].")</h3>";
	
	echo "<br><br>";
	
	echo "<strong><font face=courier size=4>".$_REQUEST["archivo"]."=%path_database%"."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["archivo"]."</font></strong><br>";
}else{

	echo "<form name=forma1 method=post>\n";
	echo "<input type=hidden name=Opcion value=Guardar>\n";
	echo "<input type=hidden name=archivo value=\"select_record.pft\">";
	echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">";
	$archivo="select_record.pft";
	$fp=file($archivo);
?>

	<textarea class="col-12" readonly cols=100 rows=10>
<?php
	foreach ($fp as $value){
		echo "$value";
	}
?>
	</textarea>

<?php
}
?>

<input type="submit" class="bt-green" value="<?php echo $msgstr["save"]; ?> opac_conf/<?php echo $_REQUEST["lang"];?>/select_record.pft">

</form>
	</div>

</div>
</div>

<?php include ("../../common/footer.php"); ?>