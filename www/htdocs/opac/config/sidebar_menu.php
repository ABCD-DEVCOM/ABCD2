<?php
include ("tope_config.php");
 if (!isset($_SESSION["db_path"])){
	echo "Session expired";die;
}
if (isset($_REQUEST["lang"])) $_SESSION["lang"]=$_REQUEST["lang"];
$wiki_help="wiki.abcdonline.info/index.php?desde=ayuda&title=OPAC-ABCD_Apariencia#Agregar_enlaces_al_men.C3.BA_desplegable_izquierdo";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_Apariencia#Agregar_enlaces_al_men.C3.BA_desplegable_izquierdo";


//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; //die;

/////////////////////////////////////////////////////////////////////

?>
<div id="page" style="margin-top:10px;padding:10px;">
<h3><?php echo $msgstr["sidebar_menu"]." &nbsp; ";
include("wiki_help.php");
echo "<p>";
$lang=$_REQUEST["lang"];
$link=array();
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	$archivo=$db_path."opac_conf/$lang/".$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			$x=explode('_',$var);
			if ($x[0]=="side"){
				$side_bar[$x[2]]=trim($value);
				$sec=$x[2];
			}
			if (isset($sec) and $x[0]=="lk"){				$link[$sec][$x[3]][$x[1]][$x[2]]=$value;			}


		}
	}
	//ksort($link);
	foreach ($link as $sec=>$value){		fwrite($fout,"[SECCION]".$side_bar[$sec]."\n");
		$salida="";
		foreach ($value as $l){
			$salida=$l["nombre"][$sec]."|".$l["link"][$sec]."|";
			if (isset($l["nw"][$sec]) and $l["nw"][$sec]=="Y")
				$salida.=$l["nw"][$sec];
			if ($salida!="") fwrite($fout,$salida."\n");
		}	}

	fclose($fout);
    echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</font>";
}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){
	$file="side_bar.info";
	echo "<form name=side"."Frm method=post xonSubmit=\"return checkform()\">\n";
	echo "<input type=hidden name=db_path value=".$db_path.">";
	echo "<input type=hidden name=Opcion value=Guardar>\n";
   	echo "<input type=hidden name=file value=\"$file\">\n";
   	echo "<input type=hidden name=lang value=\"$lang\">\n";
   	if (isset($_REQUEST["conf_level"])){
		echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	}
	if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/$file")){
		$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/$file");
		if (!isset($fp[0]) or $fp[0]!="[SECCION]") $fp[]="[SECCION]";
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
	}else{
		$fp=array();
		$fp[]="[SECCION]";
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]="[SECCION]";
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]="[SECCION]";
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
		$fp[]='|||';
	}
	$ix=0;
	$ixsec=0;

	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			$sec_name="";			if (substr($value,0,9)=="[SECCION]"){				$sec_name=substr($value,9);				if ($ixsec!=0){
					$ix=$ix+1;					AgregarLineas($ix,$ixsec);					echo "</table><br><hr size=2 color=darkblue><br>";
					$ix=0;				}
				echo "<table cellpadding=5>";
				$ixsec=$ixsec+1;				echo "<tr style=\"height:20px;\"><th colspan=2 align=left><strong>".$msgstr["title_sec"]."</strong>&nbsp ";
				echo "<input type=text name=side_sec_$ixsec"."_0 size=20 value=\"$sec_name\"></th></tr>";
				echo "<tr><th>".$msgstr["nombre"]."</th><th>".$msgstr["link"]."</th><th>".$msgstr["new_w"]."</th></tr>";
			}else{                $ix=$ix+1;
				$x=explode('|',$value);
				echo "<tr><td><input type=text size=20 name=lk_nombre_$ixsec"."_$ix value=\"".$x[0]."\"></td>";
				echo "<td><input type=text size=80 name=lk_link_$ixsec"."_$ix value=\"".$x[1]."\"></td>";
				echo "<td>&nbsp; &nbsp; &nbsp; <input type=checkbox name=lk_nw_$ixsec"."_$ix value=\"Y\"";
				if (isset($x[2]) and $x[2]=="Y") echo " checked";
				echo "></td>";
				echo"</tr>";			}		}	}
	echo "<tr><td colspan=3 align=center><br><hr size=2 color=darkblue><br><input type=submit value=\"".$msgstr["send"]."\"></td></tr>";
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

</body
</html>
<?php
function AgregarLineas($ix,$ixsec){	for ($i=0;$i<4;$i++){		$ix=$ix+1;		echo "<tr><td><input type=text size=20 name=lk_nombre_$ixsec"."_$ix value=\"\"></td>";
		echo "<td><input type=text size=80 name=lk_link_$ixsec"."_$ix value=\"\"></td>";
				echo "<td>&nbsp; &nbsp; &nbsp; <input type=checkbox name=lk_nw_$ixsec"."_$ix value=\"Y\"";
				echo "></td>";
				echo"</tr>";	}}