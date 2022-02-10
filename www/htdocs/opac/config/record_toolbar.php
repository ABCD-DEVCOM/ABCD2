<?php
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_Barra_de_Herramientas";
$wiki_trad="wiki.abcdonline.info/OPAC-ABCD_Barra_de_Herramientas";
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
?>

<div id="page" style="min-height:400px";>
    <h3>
<?php
	echo $msgstr["rtb"]." &nbsp;";
	if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){

    }else{
    	include("wiki_help.php");
	}

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
	echo "<strong><font face=courier size=4>".$_REQUEST["archivo"]."=%path_database%"."opac_conf/".$_REQUEST["archivo"]."</font></strong><br>";
}else{
	echo "<form name=forma1 method=post>\n";
	echo "<input type=hidden name=Opcion value=Guardar>\n";
	echo "<input type=hidden name=archivo value=\"select_record.pft\">";
	echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">";	$archivo="select_record.pft";
	$fp=file($archivo);
	echo "<div style=\"border:1px solid;\">";
	echo "<font face=courier>";
	echo "<xmp>";
	foreach ($fp as $value){
		echo "$value";
	}
	echo "</xmp>";
	echo "<p><input type=submit value=\"".$msgstr["save"]." opac_conf/select_record.pft\"></td></tr>";
	echo "</form>";
	echo "</div>";}

include ("../php/footer.php");
?>
</div>
</div>
</body
</html>