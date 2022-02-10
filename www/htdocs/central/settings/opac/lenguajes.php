<?php
include("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=ayuda&title=OPAC-ABCD_configuraci%C3%B3n#Idiomas_disponibles";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_configuraci%C3%B3n#Idiomas_disponibles";
?>
<div id="page">
	<p>
    <h3>
<?php
    echo $msgstr["available_languages"]." &nbsp;";
    if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Actualizar"){

    }else{
    	include("wiki_help.php");
	}
	echo "<p>";
//foreach ($_REQUEST as $var=>$value) echo "$var=>$value<br>";

if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Actualizar"){
	foreach ($_REQUEST as $var=>$value){		if (trim($value)!=""){			$code=explode("_",$var);
			if ($code[0]=="conf"){				if ($code[1]=="lc"){					if (!isset($cod_idioma[$code[2]])){						$cod_idioma[$code[2]]=$value;					}				}else{					if (!isset($nom_idioma[$code[2]])){
						$nom_idioma[$code[2]]=$value;
					}				}			}
		}	}    $fout=fopen($db_path."opac_conf/".$_REQUEST["lang"]."/lang.tab","w");
	foreach ($cod_idioma as $key=>$value){		fwrite($fout,$value."=".$nom_idioma[$key]."\n");
		echo $value."=".$nom_idioma[$key]."<br>";	}
	fclose($fout);
	echo "<h2>".$_REQUEST["lang"]."/lang.tab"." ".$msgstr["updated"]."</h2>";
	die;
}
?>

<form name=actualizar method=post>
<?php
$ix=0;
echo "<table>";
echo "<tr><th>".$msgstr["lang"]."</th><th>".$msgstr["lang_n"]."</th></tr>";
if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/lang.tab")){	$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/lang.tab");
	foreach ($fp as $value){		if (trim($value)!=""){			$l=explode('=',$value);
			$ix=$ix+1;
			echo "<tr><td><input type=text name=conf_lc_".$ix." size=5 value=\"".trim($l[0])."\"></td>";
			echo "<td><input type=text name=conf_ln_".$ix." size=30 value=\"".trim($l[1])."\"></td>";
			echo "</tr>";		}	}
}
if ($ix==0)
	$tope=5;
else
	$tope=$ix+4;
$ix=$ix+1;
for ($i=$ix;$i<$tope;$i++){	echo "<tr><td><input type=text name=conf_lc_".$i." size=5 value=\"\"></td>";
	echo "<td><input type=text name=conf_ln_".$i." size=30 value=\"\"></td>";
	echo "</tr>";}echo "</table>";
echo "<input type=submit value=\"".$msgstr["save"]."\">";
echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">\n";
echo "<input type=hidden name=Opcion value=Actualizar>";
?>
</form>
</div>

    <p>
<?php

//include ("../php/footer.php");
?>

</body
</html>