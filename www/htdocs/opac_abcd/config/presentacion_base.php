<?php
$url_back="procesos_base.php?base=".$_REQUEST["base"].'&';
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_configuraci%C3%B3n_avanzada#P.C3.A1gina_de_inicio_de_la_base_de_datos";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_configuraci%C3%B3n_avanzada#P.C3.A1gina_de_inicio_de_la_base_de_datos";
/*
/*
if (!isset($_REQUEST["db_path"])){	$_REQUEST["db_path"]=$db_path;
	$_REQUEST["db_path_desc"]="$db_path";}
if (isset($_REQUEST["db_path"])) {	$_SESSION["db_path"]=$_REQUEST["db_path"];
	$_SESSION["db_path_desc"]=$_REQUEST["db_path_desc"];
}
*/
if (isset($_REQUEST["lang"])) $_SESSION["lang"]=$_REQUEST["lang"];


//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; //die;

/////////////////////////////////////////////////////////////////////

if (!isset($_SESSION["permiso"])){
	session_destroy();
	$msg=$msgstr["invalidright"]." ".$msgstr[$_REQUEST["startas"]];
	echo "
	<html>
	<body>
	<form name=err_msg action=error_page.php method=post>
	<input type=hidden name=error value=\"$msg\">
	";
	echo "
	</form>
	<script>
		document.err_msg.submit()
	</script>
	</body>
	</html>
	";
   	session_destroy();
   	die;
 }
$lang=$_REQUEST["lang"];
$Permiso=$_SESSION["permiso"];
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	echo "<h3>".$msgstr["base_home"]."</h3>";


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
				case "home_mfn":
					$salida="[MFN]".$value;
					break;
				case "home_text":
					$salida="[TEXT]".$value;
					if (!file_exists($db_path."opac_conf/$lang/$value")){						echo "<font color=red size=2><strong>".$db_path."opac_conf/$lang/$value"." ".$msgstr["missing"]."</strong></font>"."<br>";					}
					break;			}
			if ($salida!="") fwrite($fout,$salida."\n");
		}
	}
	fclose($fout);
    echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</font>";
}
?>

<div id="page">
<br>
<?php

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){	echo "<h3>".$msgstr["base_home"]." ";
	include("wiki_help.php");
	$base="";
	if (!file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat")){		echo "<font color=red>".$msgstr["missing"]."opac_conf/".$_REQUEST["lang"]."/bases.dat";	}else{		$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat");
		foreach ($fp as $value){			if (trim($value)!=""){				$x=explode('|',$value);
				if ($_REQUEST["base"]!=$x[0]) continue;				$nombre_base=$x[1];
				$base=$x[0];
				echo "<h2>".$_REQUEST["base"]." - ".$nombre_base."</h2><br>";			}		}
	}
	if ($base!=""){
		$file=$base."_home.info";
		echo "<form name=home"."Frm method=post onSubmit=\"return checkform()\">\n";
		echo "<input type=hidden name=db_path value=".$db_path.">";
		echo "<input type=hidden name=Opcion value=Guardar>\n";
    	echo "<input type=hidden name=base value=$base>\n";
    	echo "<input type=hidden name=file value=\"$file\">\n";
    	echo "<input type=hidden name=lang value=\"$lang\">\n";
    	if (isset($_REQUEST["conf_level"])){
			echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
		}
       	$home_link="";
		$home_mfn="";
		$home_text="";
		if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/$file")){			$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/$file");
			foreach ($fp as $value){				$value=trim($value);
				if ($value!=""){					if (substr($value,0,6)=="[LINK]") $home_link=substr($value,6);
					if (substr($value,0,5)=="[MFN]")  $home_mfn=substr($value,5);
					if (substr($value,0,6)=="[TEXT]") $home_text=substr($value,6);				}			}
		}
		echo "<table cellpadding=5>";
		echo "<tr><td colspan=2>"."<font color=darkred size=3><strong>".$msgstr["sel_one"]."</strong></font></td></tr>";
		echo "<tr><td>".$msgstr["base_home_link"]."</td>";
		echo "<td>"."<input type=text name=home_link size=100 value=\"$home_link\"> Ex:http://abcdonline.info</td></tr>";
		echo "<tr><td>".$msgstr["base_home_records"]."</td>";
		echo "<td>"."<input type=checkbox name=home_mfn value=Y ";
		if ($home_mfn!="" and $home_mfn=="Y") echo " checked";
		echo "></td></tr>";
		echo "<tr><td>".$msgstr["base_home_text"]."</td>";
		echo "<td>"."<input type=text size=100 name=home_text value=\"$home_text\"";
		echo "></td></tr>";
		echo "<tr><td colspan=2 align=center> ";
	   	echo "<p><input type=submit value=\"".$msgstr["save"]."\"></td></tr>";
		echo "</table>";
		echo "</form>";
	}
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
	if (document.homeFrm.home_mfn.checked){		cuenta=cuenta+1	}

	if (Trim(document.homeFrm.home_text.value)!="")
		cuenta=cuenta+1
	if (cuenta>1){		alert("<?php echo $msgstr["sel_one"]?>")
		return false	}
	return true
}
</script>