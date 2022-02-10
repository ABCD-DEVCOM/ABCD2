<?php
$url_back="procesos_base.php?base=".$_REQUEST["base"].'&';
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_configuraci%C3%B3n_avanzada#Tipos_de_registro";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_configuraci%C3%B3n_avanzada#Tipos_de_registro";
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
	foreach ($linea as $value){		ksort($value);
		$salida=$value[0].'|'.$value[1].'|'.$value[2];
		fwrite($fout,$salida."\n");
	}

	fclose($fout);
    echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</font>";

}

?>
<form name=indices method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>
<div id="page">
    <h3>
    <?php
    echo $msgstr["tipos_registro"]." &nbsp";
    include("wiki_help.php")?></h3>
   <br>
<?php

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){
	$archivo=$db_path."opac_conf/$lang/bases.dat";
	$fp=file($archivo);
	foreach ($fp as $value){		if (trim($value)!=""){
			echo "<p>";			$x=explode('|',$value);
			if ($x[0]!=$_REQUEST["base"])  continue;
			Entrada(trim($x[0]),trim($x[1]),$lang,trim($x[0])."_colecciones.tab",$x[0]);
			break;
		}	}
}
?>
</div>
</form>
<?php
include ("../php/footer.php");
?>
</div>
</div>
</body
</html>

<?php
function Entrada($iD,$name,$lang,$file,$base){
global $msgstr,$db_path;
	echo "<strong>". $name."</strong>";
	echo "<div  id='$iD' style=\"border:1px solid; display:block;\">\n";
	echo "<div style=\"display: flex;\">";
	if ($base!=""){
		if (file_exists($db_path.$base."/def/".$_REQUEST["lang"]."/typeofrecord.tab")){
	    	$fp_campos=file($db_path.$base."/def/".$_REQUEST["lang"]."/typeofrecord.tab");
       	    $cuenta=count($fp_campos);
      	}else{
      		$cuenta=0;
      	}
    }

	echo "<div style=\"flex: 0 0 50%;\">";
	echo "<form name=$iD"."Frm method=post>\n";
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
		for ($i=0;$i<8;$i++){
			$fp[]="||";
		}
	}else{
		$fp=file($db_path."opac_conf/$lang/$file");
		$fp[]='||';
		$fp[]='||';
		$fp[]='||';
	}
	echo "<table bgcolor=#cccccc cellpadding=5>\n";
	echo "<tr><th>".$msgstr["id"]."</th><th>".$msgstr["nombre"]."</th><th>".$msgstr["ix_pref"]."</th></tr>\n";
	$row=0;
	foreach ($fp as $value) {
		$value=trim($value);
		if ($value!=""){
			$ix=-1;
			$row=$row+1;
			$v=explode('|',$value);
			echo "<tr>";
			foreach ($v as $var){
				$ix=$ix+1;
				if ($ix>2) break;
				echo "<td bgcolor=white>";
		 		if ($ix==1)
		 			$size=30;
				else
					$size=8;
			 	echo "<input type=text name=conf_base_".$row."_".$ix." value=\"$var\" size=$size>";
				echo "</td>\n";
			}
			echo "</tr>\n";
		}
	}
	echo "<tr><td colspan=2 align=center> ";
	echo "<p><input type=submit value=\"".$msgstr["save"]." ".$iD."\"></td></tr>";
	echo "</table>\n";
	echo "</form></div><p>";

	if ($cuenta>0){
		echo "<div style=\"flex: 1\">";
		echo "<strong>$base/$lang/typeofrecord.tab</strong><br>";
		echo "<table bgcolor=#cccccc cellpadding=5>\n";
		echo "<tr><th>".$msgstr["id"]."</th><th>".$msgstr["nombre"]."</th></tr>\n";
		foreach ($fp_campos as $value) {
			if (trim($value)!=""){
				$v=explode('|',$value);
				if (count($v)<2) continue;
				echo "<tr><td>".$v[1].$v[2]."</td><td>".$v[3]."</td></tr>\n";
			}
		}
		echo "</table>";
		echo "</div>" ;
	}
	echo "</div></div>";
}
?>
