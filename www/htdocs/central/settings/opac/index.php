<?php
//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>";
if (isset($_REQUEST["conf_level"])) unset($_REQUEST["conf_level"]);
include ("conf_opac_top.php");

$wiki_help="OPAC-ABCD_Detalles_de_la_configuraci%C3%B3n#Men.C3.BA_de_configuraci.C3.B3n";
include "../../common/inc_div-helper.php";
?>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
		<?php include("conf_opac_menu.php");?>
	</div>
	<div class="formContent col-9 m-2">
		<?php include("whats_new.php");?>
	</div>
</div> 
<?php include ("../../common/footer.php"); ?>

<form name=forma1 method=post>
	<?php if (isset($_REQUEST["conf_level"])){ ?>
	<input type="hidden" name="conf_level" value="<?php echo $_REQUEST["conf_level"];?>" >
	<?php } ?>
	<input type="hidden" name="base">
	<input type="hidden" name="lang" value="<?php echo $lang;?>" >
	<input type="hidden" name="db_path" value="<?php echo $_REQUEST["db_path"]?>" >
</form>