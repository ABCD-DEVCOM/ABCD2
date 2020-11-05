<?php
$url_back="menu.php?";
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_DCXML";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_DCXML";
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (!isset($_SESSION["db_path"])){	echo "Session expired";die;}
$db_path=$_SESSION["db_path"];
echo "<form name=dc_scheme method=post>\n";
echo "	<div id=\"page\" style=\"min-height:400px\";>
	    <h3>".$msgstr["xml_dc"]."&nbsp;";
echo "<br>".$msgstr["dc_step1"]." &nbsp;";

echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">\n";
echo "<input type=hidden name=db_path value=".$db_path.">\n";
echo "<input type=hidden name=Opcion value=Guardar>\n";
echo "<input type=hidden name=file value=dc_sch.xml>";
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){	echo "</h3>" ;	$lang=$_REQUEST["lang"];
	$archivo=$db_path."opac_conf/".$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	$salida=str_replace(PHP_EOL,"#####",$_REQUEST["conf_dc"]);
	$esquema=explode('#####',$salida);
	foreach ($esquema as $value){
		$value=trim($value);
		$value=trim($value)."\n";
		fwrite($fout,$value);
	}
	fclose($fout);
    echo "<h3><font color=red>". "opac_conf/dc_sch.xml ".$msgstr["updated"]."</font></h3>";
    die;
}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){    include("wiki_help.php");
	//DATABASES
	echo "<div style=\"margin-left:40px;\">";
	$archivo="dc.xml";
	$fp=file($archivo);
	echo "<textarea name=conf_dc rows=20 cols=30>";
	foreach ($fp as $value){
		if (trim($value)!=""){
			echo "$value";		}
	}
    echo "</textarea>" ;
    echo "<p>";
    echo "<div><img src=../images/arrow.jpg style=\"margin-top:-7px;vertical-align: middle;\"> &nbsp;<input type=submit name=guardar value=\" ".$msgstr["save"]." opac_conf/dc_sch.xml \" onclick=document.marcxml.submit() style=\"font-size:15px;\"></div>";
	echo "</form>";
	echo "</div>";
}
include ("../php/footer.php");
?>
</div>
</div>
</body
</html>
