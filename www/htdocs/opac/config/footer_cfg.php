<?php
include ("tope_config.php");
if (!isset($_SESSION["db_path"])){
	echo "Session expired";die;
}
if (isset($_REQUEST["lang"])) $_SESSION["lang"]=$_REQUEST["lang"];
$wiki_help="wiki.abcdonline.info/index.php?desde=ayuda&title=OPAC-ABCD_Apariencia#Pie_de_p.C3.A1gina";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_Apariencia#Pie_de_p.C3.A1gina";

//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; //die;

/////////////////////////////////////////////////////////////////////


$lang=$_REQUEST["lang"];
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	$archivo=$db_path."opac_conf/$lang/".$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			$salida="";
			switch($var){				case "home_link":
					$salida="[LINK]".$value;
					break;
				case "home_text":
					$salida="[TEXT]".$value;
					if (trim($value)!=""){
						if (!file_exists($db_path."opac_conf/$lang/$value") and trim($_REQUEST["editor1"])==""){							echo "<font color=red size=4><strong>".$db_path."opac_conf/$lang/$value"." ".$msgstr["missing"]."</strong></font>"."<br>";						}
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
    echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</font>";
}
?>

<div id="page" style="margin-top:10px;padding:10px;">
<h3><?php echo $msgstr["footer"]." &nbsp; ";
include("wiki_help.php");
echo "<p>";

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){
	$file="footer.info";
	echo "<form name=home"."Frm method=post onSubmit=\"return checkform()\">\n";
	echo "<input type=hidden name=db_path value=".$db_path.">";
	echo "<input type=hidden name=Opcion value=Guardar>\n";
    echo "<input type=hidden name=file value=\"$file\">\n";
    echo "<input type=hidden name=lang value=\"$lang\">\n";
    if (isset($_REQUEST["conf_level"])){
		echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	}
    $home_link="";
    $height_link="";
	$home_text="";
	if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/$file")){		$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/$file");
		foreach ($fp as $value){			$value=trim($value);
			if ($value!=""){				if (substr($value,0,6)=="[LINK]") {					$home_link=substr($value,6);
					$hl=explode('|||',$home_link);
					$home_link=$hl[0];
					if (isset($hl[1]))
						$height_link=$hl[1];
					else
						$height_link=800;
				}
				if (substr($value,0,6)=="[TEXT]") $home_text=substr($value,6);			}		}
	}
	echo "<table cellpadding=5>";
	echo "<tr><td colspan=2>"."<font color=darkred size=3><strong>".$msgstr["sel_one"]."</strong></font></td></tr>";
	echo "<tr><td valign=top nowrap>".$msgstr["base_home_link"]."<br>Ex:http://www.abcdonline.info</td>";
	echo "<td>"."<input type=text name=home_link size=70 value=\"$home_link\">";
	echo "&nbsp; ".$msgstr["frame_h"]." <input type=text name=height_link size=5 value=\"$height_link\">px</td></tr>";
	echo "<tr><td valign=top>".$msgstr["base_home_text"]."</td>";
	echo "<td>"."<input type=text size=100 name=home_text value=\"$home_text\"";
	echo "><br><br>";
	$footer_html="";
	if ($home_text!=""){		if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/".$home_text)){
			$footer_html=file($db_path."opac_conf/".$_REQUEST["lang"]."/".$home_text);
			$footer_html=implode($footer_html);
		}	}

	echo "<div style=\"position:relative;display:block;\" id=ckeditorFrm> ";
	echo "<script src=\"$server_url/".$app_path."/ckeditor/ckeditor.js\"></script>";

?>
<textarea cols="80" id="editor1" name="editor1" rows="10" <?php echo $footer_html?>></textarea>
  <script>
    CKEDITOR.replace('editor1', {
      height: 260,
      width: 800,
    });
  </script>
<?php

	echo "</div>";
	echo "</td></tr>";
	echo "<tr><td colspan=2 align=center> ";
	echo "<p><input type=submit value=\"".$msgstr["save"]."\"></td></tr>";
	echo "</table>";
	echo "</form>";
}
?>
</div>

<br>
<br>
<?php
include ("../php/footer.php");
?>
</div>
</div>
</body
</html>
<script>
function checkform(){
	cuenta=0;
	if (Trim(document.homeFrm.home_link.value)!="")
		cuenta=cuenta+1
	if (Trim(document.homeFrm.home_text.value)!="")
		cuenta=cuenta+1
	if (cuenta>1){		alert("<?php echo $msgstr["sel_one"]?>")
		return false	}
	if (Trim(document.homeFrm.home_text.value)!=""){
		if (trim(documen.homeFrm.edit1.value)==""){			alert("Debe suministrar el texto del archivo")
			return false		}	}
	return true
}
function Editar(){
	if (Trim(document.homeFrm.home_text.value)=="") {		alert("<?php echo $msgstr["miss_fn"]?>")
		return	}
	Ctrl=document.getElementById("ckeditorFrm")
	Ctrl.style.display="block"}
</script>