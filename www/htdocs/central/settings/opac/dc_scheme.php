<?php
include ("conf_opac_top.php");
$wiki_help="OPAC-ABCD_MARCXML";
include "../../common/inc_div-helper.php";
?>

<script>
var idPage="meta_schema";
</script>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
			<?php include("conf_opac_menu.php");?>
	</div>
	<div class="formContent col-9 m-2">
   <h3><?php 
   		echo "<h3>".$msgstr["xml_dc"]."&nbsp;";
		echo "<br>".$msgstr["xml_step1"]." &nbsp;";
		?>
	</h3>

<?php

//foreach ($_REQUEST as $var=>$value) echo "<xmp>$var=$value</xmp><br>";
if (!isset($_SESSION["db_path"])){
	echo "Session expired";die;
}
$db_path=$_SESSION["db_path"];
?>

	<form name="dc_scheme" method="post">
	<input type="hidden" name="lang" value="<?php echo $_REQUEST["lang"];?>">
	<input type="hidden" name="db_path" value="<?php echo $db_path;?>">
	<input type="hidden" name="Opcion" value="Guardar">
	<input type="hidden" name="file" value="dc_sch.xml">

<?php
	$archivo=$db_path."opac_conf/dc_sch.xml";
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	echo "</h3>";
	$lang=$_REQUEST["lang"];
	$fout=fopen($archivo,"w");
	$salida=str_replace(PHP_EOL,"#####",$_REQUEST["conf_dc"]);
	$esquema=explode('#####',$salida);
	foreach ($esquema as $value){
		$value=trim($value);
		$value=trim($value)."\n";
		fwrite($fout,$value);
	}
	fclose($fout);
    echo "<h3><font color=red>". "opac_conf/".$_REQUEST["file"]." ".$msgstr["updated"]."</font></h3>";
    die;
}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){
	//DATABASES
	echo "<p>".$archivo."</p>";
	echo "<div style=\"margin-left:40px;\">";
	$archivo="dc.xml";
	$fp=file($archivo);

?>

	<textarea class="col-12" name=conf_dc rows=20 cols=100>
<?php
	foreach ($fp as $value){
		if (trim($value)!=""){
			if (strpos($value,"subfield")>0)
				echo "       ";
			echo "$value";
		}
	}
    echo "</textarea>" ;
}
?>
	<button type="submit" class="bt-green"><?php echo $msgstr["save"]; ?></button>
	</form>

</div>
</div>
</div>

<?php include ("../../common/footer.php"); ?>