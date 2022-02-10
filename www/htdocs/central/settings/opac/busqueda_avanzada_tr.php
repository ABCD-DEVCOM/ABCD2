<?php
$url_back="procesos_base.php?base=".$_REQUEST["base"].'&';
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_configuraci%C3%B3n_avanzada#B.C3.BAsqueda_avanzada_-_Tipos_de_registro";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_configuraci%C3%B3n_avanzada#B.C3.BAsqueda_avanzada_-_Tipos_de_registro";
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){	$lang=$_REQUEST["lang"];
	$archivo=$db_path."opac_conf/$lang/".$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			if (substr($var,0,9)=="conf_base"){				$x=explode('_',$var);
				$linea[$x[2]][$x[3]]=$value;
			}
		}
	}
	foreach ($linea as $value){		if (!isset($value[1])) $value[1]="";

		ksort($value);
		$salida=$value[0].'|'.$value[1].'|'.$value[2];
		fwrite($fout,$salida."\n");
	}

	fclose($fout);
    echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</font>";

}
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="copiarde"){	$archivo=$db_path."opac_conf/".$_REQUEST["lang_copiar"]."/".$_REQUEST["archivo"];
	copy($archivo,$db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["archivo"]);
	echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["archivo"]." ".$msgstr["copiado"]."</font>";}


?>
<form name=indices method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>
<div id="page">
    <h3>
    <?php
    echo $msgstr["buscar_a"]." - ".$msgstr["tipos_registro"]." &nbsp";
    if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar")
    	include("wiki_help.php")
	?>
   <br>
<?php
//DATABASES
$archivo=$db_path."opac_conf/$lang/bases.dat";
$fp=file($archivo);
foreach ($fp as $value){	if (trim($value)!=""){
		echo "<p>";		$x=explode('|',$value);
		if ($_REQUEST["base"]!=$x[0]) continue ;
		if(!file_exists($db_path."opac_conf/$lang/".$x[0]."_colecciones.tab")){
			echo "<h4>".$msgstr["nrt_defined"]." ".$x[0]."</h4><br>";
			continue;
		}
		if(file_exists($db_path."opac_conf/$lang/".$x[0]."_colecciones.tab")){
			$fpTm=file($db_path."opac_conf/$lang/".$x[0]."_colecciones.tab");
			echo "<strong>".$x[1]."</strong><p>";
			foreach ($fpTm as $coleccion){				if (trim($coleccion)!=""){					$c=explode('|',$coleccion);
					$TM=$c[0];
					Entrada(trim($x[0]),trim($x[1]),$lang,trim($x[0])."_avanzada_$TM.tab",$c[1],$TM,$x[0]);				}			}

		}
	}
}
?>
</div>
<?php
include ("../php/footer.php");
?>
</div>
</div>
</body
</html>
<?php
function Entrada($iD,$name,$lang,$file,$nombre_c,$TM,$base){
global $msgstr,$db_path;
	echo "<strong>". $name." - ".$nombre_c."</strong></a>";
	echo "<div  id='$iD$TM' style=\"border:1px solid; display:block;\">\n";
	echo "<form name=$iD$TM"."Frm method=post>\n";
	echo "<input type=hidden name=Opcion value=Guardar>\n";
    echo "<input type=hidden name=base value=$iD>\n";
    echo "<input type=hidden name=file value=\"$file\">\n";
    echo "<input type=hidden name=lang value=\"$lang\">\n";
    if (isset($_REQUEST["conf_level"])){
		echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	}
	echo "<strong>opac_conf/$lang/$file</strong><br>";
	if (!file_exists($db_path."opac_conf/$lang/$file")){
		$fp=array();
		for ($i=0;$i<10;$i++){
			$fp[]="||";
		}
	}else{
		$fp=file($db_path."opac_conf/$lang/$file");
		$fp[]='||';
		$fp[]='||';
		$fp[]='||';
	}
	echo "<table bgcolor=#cccccc cellpadding=5>\n";
	echo "<tr><th>".$msgstr["ix_nombre"]."</th><th>".$msgstr["ix_pref"]."</th></tr>\n";
	$row=0;
	foreach ($fp as $value) {
		$value=trim($value);
		if ($value!=""){
			$ix=-1;
			$row=$row+1;
			$v=explode('|',$value);
			if (count($v)!=5) $v[]="";
			echo "<tr>";
			foreach ($v as $var){
				$ix=$ix+1;
				if ($ix>2) break;
				if ($ix!=1){
					echo "<td bgcolor=white>";
			 		if ($ix==0)
			 			$size=30;
					else
						$size=8;
			 		echo "<input type=text name=conf_base_".$row."_".$ix." value=\"$var\" size=$size>";
					echo "</td>\n";
				}
			}
			echo "</tr>\n";
		}
	}
	echo "<tr><td colspan=2 align=center> ";
	echo "<p><input type=submit value=\"".$msgstr["save"]." ".$iD." - ".$TM."\"></td></tr>";
	echo "</table>\n";
	echo "</form></div><br><br><p>";
}

?>
<form name=forma1 method=post>
<?php if (isset($_REQUEST["conf_level"])){
	echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
}?>
<input type=hidden name=base>
<input type=hidden name=lang value=<?php echo $_REQUEST["lang"]?>>
</form>
</body>
</html>