<?php
include ("conf_opac_top.php");
$wiki_help="OPAC-ABCD_Barra_de_Herramientas";
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
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";

if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	//$fp=file($_REQUEST["archivo"]);
	$archivo=$db_path."opac_conf/".$lang."/".$_REQUEST["archivo"];

	if (file_exists($archivo)){
		$fp=file($archivo);
		$file_edit=$archivo;
	} else {
		$fp=file($_REQUEST["archivo"]);
		$file_edit=$_REQUEST["archivo"];
	}

	echo $archivo;
	$fout=fopen($archivo,"w");
	fwrite($fout,$_REQUEST["content"]);
	fclose($fout);
?>
	<h2 class="color-green"><?php echo $file_edit." ".$msgstr["updated"];?></h2>
   
    <h3><php echo $msgstr["add_topar"]." (".$msgstr["in_all"].")";?></h3>
	
	<br><br>

	<strong><font face=courier size=4><?php echo $_REQUEST["archivo"]."=%path_database%"."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["archivo"]."</font></strong>";

}else{
?>
	<form name="forma1" method="post">
	<input type="hidden" name="Opcion" value="Guardar">
	<input type="hidden" name="archivo" value="select_record.pft">
	<input type="hidden" name="lang" value="<?php echo $_REQUEST["lang"];?>">

<?php
	$archivo="select_record.pft";
	$file_edit=$db_path."opac_conf/".$lang."/".$archivo;

	if (file_exists($file_edit)){
		$fp=file($file_edit);
	} else {
		$fp=file($archivo);
		$file_edit=$archivo;
	}
?>	

   	<h3><?php echo $msgstr["rtb"];?></h3>
	<p><?php echo $file_edit;?></p>

	<textarea class="col-12" cols="100" rows="10" name="content">
<?php
	foreach ($fp as $value){
		echo "$value";
	}
?>
	</textarea>

	<button type="submit" class="bt-green"><?php echo $msgstr["save"]; ?></button>

<?php } ?>
</form>

</div>

</div>


<?php include ("../../common/footer.php"); ?>