<?php
include ("tope_config.php");
$wiki_help="OPAC-ABCD_Apariencia#Pie_de_p.C3.A1gina";
include "../../common/inc_div-helper.php";

?>

<div class="middle form">
   <h3><?php echo $msgstr["footer"];?>
	</h3>
	<div class="formContent">

<div id="page">

<?php

if (!isset($_SESSION["db_path"])){
	echo "Session expired";die;
}
if (isset($_REQUEST["lang"])) $_SESSION["lang"]=$_REQUEST["lang"];

//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; //die;

/////////////////////////////////////////////////////////////////////


$lang=$_REQUEST["lang"];

if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	$file_request=$_REQUEST["file"];
	$archivo=$db_path."opac_conf/$lang/".$file_request;
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			$salida="";
			switch($var){
				case "home_link":
					$salida="[LINK]".$value;
					break;
				case "home_text":
					$salida="[TEXT]".$value;
					if (trim($value)!=""){
						if (!file_exists($db_path."opac_conf/$lang/$file_request") and trim($_REQUEST["editor1"])==""){
							echo "<font color=red size=4><strong>".$db_path."opac_conf/$lang/$file_request"." ".$msgstr["missing"]."</strong></font>"."<br>";
						}

					}
						break;
					case "editor1":
					$salida="[HTML]".$value;
					if (trim($value)!=""){
						if (!file_exists($db_path."opac_conf/$lang/$file_request") and trim($_REQUEST["editor1"])==""){
							echo "<font color=red size=4><strong>".$db_path."opac_conf/$lang/$file_request"." ".$msgstr["missing"]."</strong></font>"."<br>";
						}
						//if ($_REQUEST["editor1"]!=""){
							//$fck=fopen($db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["file"],"w");
							//fwrite($fck,$value);
							//fclose($fck);
						//}
					}
					break;


			}
			if ($salida!="") 
				fwrite($fout,$salida."\n");
		}
	}
	fclose($fout);
    echo "<h2 class='color-green'>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</h2>";
}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){
	$file="footer.info";
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
	if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/$file")){
		$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/$file");
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
				if (substr($value,0,6)=="[TEXT]") { 
						$footer_file=substr($value,6);
			} else {
					$footer_file="";
				}
				if (substr($value,0,6)=="[HTML]") { 
					$content_html=substr($value,5);
				} 
			}
		}
	}

?>

<table>
<tr>
	<td colspan=2>
		<font color=darkred size=3>
			<strong><?php echo $msgstr["sel_one"];?></strong>
		</font>
	</td>
</tr>
<tr>
	<td valign=top nowrap><?php echo $msgstr["base_home_link"];?>
	<br>Ex: https://abcd-community.org
</td>
<td>
	<input type="text" name="home_link" size=70 value="<?php echo $home_link;?>">
&nbsp; <?php echo $msgstr["frame_h"];?>
	<input type="text" name="height_link" size=5 value="<?php echo $height_link;?>">px
</td>
</tr>
<tr>
	<td valign=top>
		<?php echo $msgstr["base_home_text"];?>
	</td>
	<td>
		<input type="text" size="100" name="home_text" value="<?php echo $footer_file;?>" ><br><br>
<?php

	$footer_html="";
	if (isset($content_html)){
		if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/".$file)){
			$footer_html=file($db_path."opac_conf/".$_REQUEST["lang"]."/".$file);
			$footer_html=implode($footer_html);
		}
	}
	echo "<div style=\"position:relative;display:block;\" id=ckeditorFrm> ";
	echo "<script src=\"$server_url/".$app_path."/ckeditor/ckeditor.js\"></script>";

?>
<textarea cols="80" id="editor1" name="editor1" rows="10"><?php echo substr($footer_html,8);?></textarea>
	  <script>
	    CKEDITOR.replace('editor1', {
	      height: 260,
	      width: 800,
	    });
	  </script>

		</div>
	</td>
</tr>
<tr>
	<td colspan=2 align=center> 
		<input type="submit" value="<?php echo $msgstr["save"]; ?>">
	</td>
</tr>
</table>
</form>

<?php

}
?>
</div>    
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
	if (Trim(document.homeFrm.home_text.value)!=""){
		if (trim(documen.homeFrm.edit1.value)==""){
			alert("Debe suministrar el texto del archivo")
			return false
		}
	}
	return true

}
function Editar(){

	if (Trim(document.homeFrm.home_text.value)=="") {
		alert("<?php echo $msgstr["miss_fn"]?>")
		return
	}
	Ctrl=document.getElementById("ckeditorFrm")
	Ctrl.style.display="block"
}
</script>