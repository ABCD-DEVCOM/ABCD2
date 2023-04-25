<?php
include ("tope_config.php");
$wiki_help="OPAC-ABCD_Apariencia#Primera_p.C3.A1gina";
include "../../common/inc_div-helper.php";
?>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
			<?php include("menu_bar.php");?>
	</div>
	<div class="formContent col-9 m-2">
		<h3><?php echo $msgstr["first_page"];?></h3>

<?php

//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; //die;

if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	$file_request=$_REQUEST["file"];
	$archivo=$db_path."opac_conf/".$lang."/".$file_request;
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			$salida="";
			switch($var){
				case "home_link":
					$salida="[LINK]".$value;
					if (isset($_REQUEST["height_link"]) and trim($_REQUEST["height_link"])!="") $salida.='|||'.$_REQUEST["height_link"];
					break;
				case "home_mfn":
					$salida="[MFN]".$value;
					break;
				case "home_text":
					$salida="[TEXT]".$value;
					if (trim($value)!=""){
						if (!file_exists($db_path."opac_conf/$lang/$value") and trim($_REQUEST["editor1"])==""){
							echo "<font color=red size=4><strong>".$db_path."opac_conf/$lang/$value"." ".$msgstr["missing"]."</strong></font>"."<br>";
						}
						if ($_REQUEST["editor1"]!=""){
							$fck=fopen($db_path."opac_conf/".$_REQUEST["lang"]."/".$value,"w");
							fwrite($fck,$_REQUEST["editor1"]);
							fclose($fck);
						}
					}
					break;
			}
			if ($salida!="") fwrite($fout,$salida."\n");
		}
	}
	fclose($fout);
	?>
    <h2 class="color-green"><?php echo "opac_conf/".$lang."/".$_REQUEST["file"]." ".$msgstr["updated"];?></h2>
	<?php
}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){
	$file="sitio.info";
?>	

	<form name="homeFrm" method="post" onSubmit="return checkform()">
	<input type="hidden" name="db_path" value="<?php echo $db_path;?>">
	<input type="hidden" name="Opcion" value="Guardar">
	<input type="hidden" name="file" value="<?php echo $file;?>">
	<input type="hidden" name="lang" value="<?php echo $lang;?>">
  
<?php
    if (isset($_REQUEST["conf_level"])){
		echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	}
    $home_link="";
    $height_link="";
	$home_text="";
	if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/".$file)){
		$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/".$file);
		foreach ($fp as $value){
			$value=trim($value);
			if ($value!=""){
				if (substr($value,0,6)=="[LINK]") {
					$home_link=substr($value,6);
					$hl=explode('|||',$home_link);
					$home_link=$hl[0];
					if (isset($hl[1]))
						$height_link=$hl[1];
					else
						$height_link=800;
				}
				if (substr($value,0,6)=="[TEXT]") $home_text=substr($value,6);
			}
		}
	}
?>
	<h4><?php echo $msgstr["sel_one"];?></h4>

	<div class="formRow">
		<label><?php echo $msgstr["base_home_link"];?><small>Ex: https://abcd-community.org</small></label>
		<input type="text" name="home_link" size="70" value="<?php echo $home_link;?>">
	</div>

	<div class="formRow">
		<label><?php echo $msgstr["frame_h"];?></label>
		<input type="text" name="height_link" size="5" value="<?php echo $height_link;?>">px
	</div>

	<div class="w-10 p-2">
		<label class="w-10"><?php echo $msgstr["base_home_text"];?><small> <br>(<?php echo $db_path."opac_conf/".$_REQUEST["lang"];?>)</small></label>
		<input type="text" size="100" name="home_text" value="<?php echo $home_text;?>">
	</div>

	<div class="formRow" id="ckeditorFrm">
	<?php 
		$home_html="";
		if ($home_text!=""){
			if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/".$home_text)){
				$home_html=file($db_path."opac_conf/".$_REQUEST["lang"]."/".$home_text);
				$home_html=implode($home_html);
			}
		}

		echo "<script src=\"$server_url/".$app_path."/ckeditor/ckeditor.js\"></script>";

	?>
	<textarea cols="80" id="editor1" name="editor1" rows="10" <?php echo $home_html?>></textarea>
	<script>
		CKEDITOR.replace('editor1', {
		height: 260,
		width: 800,
		});
	</script>
	</div>

	<button type="submit" class="bt-green"><?php echo $msgstr["save"]; ?></button>
</form>

<?php } ?>
</div>    
</div>    

<?php include ("../../common/footer.php"); ?>




<script>
function checkform(){
	cuenta=0;
	if (Trim(document.homeFrm.home_link.value)!="")
		cuenta=cuenta+1
	if (Trim(document.homeFrm.home_text.value)!="")
		cuenta=cuenta+1
	if (cuenta>1){
		alert("<?php echo $msgstr["sel_one"]?>")
		return false
	}
	return true

}
</script>