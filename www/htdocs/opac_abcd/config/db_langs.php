<?php
include("tope_config.php");
?>
<div id="page">
	<p>
    <h3><?php echo $msgstr["avail_db_lang"]?> &nbsp;<a href=http://wiki.abcdonline.info/OPAC-ABCD_configuraci%C3%B3n_avanzada#Juego_de_caracteres_disponibles target=_blank><img src=../images_config/helper_bg.png></a></h3><p>

    <p>
<?php
/*echo "<pre>";
foreach ($_REQUEST as $var=>$value) echo "$var=>$value \n";
echo "</pre>";
*/
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Actualizar"){
	foreach ($_REQUEST as $var=>$value){
		if (trim($value)!=""){			$code=explode("_",$var);
			if ($code[0]=="conf"){				switch ($code[1]){					case "lc":
						if (!isset($cod_lang[$code[2]])){							$cod_lang[$code[2]]=$value;
						}						break;					case "ln":						if (!isset($collation[$code[2]])){
							$collation[$code[2]]=$value;
						}
						break;

				}			}
		}	}    foreach ($cod_lang as $key=>$value){
		$fout=fopen($db_path."opac_conf/alpha/$charset/$value.tab","w");
		fwrite($fout, $collation[$key]);
		fclose($fout);
		echo "<h2>"."alpha/$charset/$value.tab ".$msgstr["updated"]."</h2>";
	}
	die;
}
?>

<form name=actualizar method=post>
<?php
$ix=0;
echo "opac_conf/alpha/$charset";
echo "<table>";

if (is_dir($db_path."opac_conf/alpha/$charset")){	$handle=opendir($db_path."opac_conf/alpha/$charset");
	while (false !== ($entry = readdir($handle))) {
		if (!is_file($db_path."opac_conf/alpha/$charset/$entry")) continue;
		$file = basename($entry, ".tab");
		$ix=$ix+1;
		echo "<tr><th>".$msgstr["lang_name"]."</th><th>".$msgstr["lang_order"]."<br>".$msgstr["uno_por_linea"]."</th></tr>";
		echo "<tr><td valign=top><input type=text name=conf_lc_".$ix." size=25 value=\"$file\"></td>";
		$fp=file($db_path."opac_conf/alpha/$charset"."/$entry");
		echo "<td align=center><textarea cols=10 rows=30  name=conf_ln_".$ix." >";
		foreach ($fp as $value){			if (trim($value)!=""){			    echo $value;			}		}
		echo "</textarea></td></tr>\n";
		echo "<td colspan=2><hr></td></tr>\n";
	}
}
if ($ix==0)
	$tope=5;
else
	$tope=$ix+4;
$ix=$ix+1;
for ($i=$ix;$i<$tope;$i++){
	echo "<tr><th>".$msgstr["lang_name"]."</th><th>".$msgstr["lang_order"]."<br>".$msgstr["uno_por_linea"]."</th></tr>";	echo "<tr><td valign=top><input type=text name=conf_lc_".$i." size=25 value=\"\"></td>";
	echo "<td align=center><textarea cols=10 rows=30  name=conf_ln_".$i." ></textarea></td>";
	echo "</tr>";
	echo "<td colspan=2><hr></td></tr>\n";}echo "</table>";
echo "<input type=submit value=\"".$msgstr["save"]."\">";
echo "<input type=hidden name=lang value=".$_REQUEST["lang"].">\n";
echo "<input type=hidden name=Opcion value=Actualizar>";
?>
</form>
</div>
<?php

include ("../php/footer.php");
?>

</body
</html>