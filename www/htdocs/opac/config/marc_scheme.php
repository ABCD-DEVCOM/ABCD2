<?php
$url_back="menu.php?";
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_MARCXML";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_MARCXML";
//foreach ($_REQUEST as $var=>$value) echo "<xmp>$var=$value</xmp><br>";
if (!isset($_SESSION["db_path"])){	echo "Session expired";die;}
$db_path=$_SESSION["db_path"];
echo "<form name=marc_scheme method=post>\n";
echo "<div id=\"page\" style=\"min-height:400px\";>";
echo "<h3>".$msgstr["xml_marc"]."&nbsp;";
echo "<br>".$msgstr["xml_step1"]." &nbsp;";
echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">\n";
echo "<input type=hidden name=db_path value=".$db_path.">\n";
echo "<input type=hidden name=Opcion value=Guardar>\n";
echo "<input type=hidden name=file value=marc_sch.xml>";
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){	echo "</h3>";	$lang=$_REQUEST["lang"];
	$archivo=$db_path."opac_conf/marc_sch.xml";
	$fout=fopen($archivo,"w");
	$salida=str_replace(PHP_EOL,"#####",$_REQUEST["conf_marc"]);
	$esquema=explode('#####',$salida);
	foreach ($esquema as $value){		$value=trim($value);
		$value=trim($value)."\n";
		fwrite($fout,$value);
	}
	fclose($fout);
    echo "<h3><font color=red>". "opac_conf/".$_REQUEST["file"]." ".$msgstr["updated"]."</font></h3>";
    die;
}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){    include("wiki_help.php");
	//DATABASES
	echo "<div style=\"margin-left:40px;\">";
	$archivo="marc.xml";
	$fp=file($archivo);
	echo "<textarea name=conf_marc rows=20 cols=100>";
	foreach ($fp as $value){
		if (trim($value)!=""){
			if (strpos($value,"subfield")>0)
				echo "       ";
			echo "$value";		}
	}
    echo "</textarea>" ;
    echo "<p>";
	echo "<div><img src=../images/arrow.jpg style=\"margin-top:-7px;vertical-align: middle;\"> &nbsp;<input type=submit name=guardar value=\" ".$msgstr["save"]." opac_conf/marc_sch.xml \" style=\"font-size:15px;\"></div>";
	echo "</form>";
	echo "</div>";
}
include ("../php/footer.php");
?>
</div>
</div>
</body
</html>
