<?php
$url_back="procesos_base.php?base=".$_REQUEST["base"].'&';
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=ayuda&title=OPAC-ABCD_configuraci%C3%B3n_avanzada#.C3.8Dndices_alfab.C3.A9ticos";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_configuraci%C3%B3n_avanzada#.C3.8Dndices_alfab.C3.A9ticos";
?>
<form name=indices method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>
<div id="page">
    <h3>
<?php
	if (!isset($_SESSION["db_path"])){
		echo "Session expired";die;
	}
	echo $msgstr["indice_alfa"]." &nbsp";
    if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar")
		include("wiki_help.php");
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";


if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){	$lang=$_REQUEST["lang"];
	$archivo=$db_path."opac_conf/$lang/".$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	$linea=array();
	foreach ($_REQUEST as $var=>$value){		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			if (substr($var,0,9)=="conf_base"){				$x=explode('_',$var);
				if (count($x)==4)
					$linea[$x[2]][$x[3]]=$value;
			}
		}
	}
	foreach ($linea as $value){		if (!isset($value[2])) $value[2]="";
		if (!isset($value[3])) $value[3]="1";
		if (!isset($value[4])) $value[4]="";

		$salida=$value[0].'|'.$value[1].'|'.$value[2].'|'.$value[3].'|'.$value[4];
		echo $salida."<br>";
		fwrite($fout,$salida."\n");
	}

	fclose($fout);
    echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</font>";
    if ($_REQUEST["base"]!="META")echo "<h4>".$msgstr["ira"]." <a href=\"javascript:SeleccionarProceso('autoridades.php','".$_REQUEST["base"]."')\">".$msgstr["aut_opac"]."</a></H4>";
}

if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="copiarde"){	$archivo=$db_path."opac_conf/".$_REQUEST["lang_copiar"]."/".$_REQUEST["archivo"];
	copy($archivo,$db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["archivo"]);
	echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["archivo"]." ".$msgstr["copiado"]."</font>";}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]==""){
	//DATABASES
	if ($_REQUEST["base"]=="META"){		Entrada("MetaSearch",$msgstr["metasearch"],$lang,"indice.ix","META");	}else{		$archivo=$db_path."opac_conf/$lang/bases.dat";
		$fp=file($archivo);
		foreach ($fp as $value){			if (trim($value)!=""){
	  			$x=explode('|',$value);
				if ($_REQUEST["base"]!=$x[0])  continue;
				Entrada(trim($x[0]),trim($x[1]),$lang,trim($x[0]).".ix",$x[0]);
			}
		}	}
}
//METASEARCH
//;
?>

</div>
<?php
include ("../php/footer.php");
?>
</div>
</div>
</body
</html>
<form name=copiarde method=post>
<input type=hidden name=db>
<input type=hidden name=archivo>
<input type=hidden name=Opcion value=copiarde>
<input type=hidden name=lang_copiar>
<input type=hidden name=lang value=<?php echo $_REQUEST["lang"]?>>
</form>

<form name=forma1 method=post>
<?php if (isset($_REQUEST["conf_level"])){
	echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
}?>
<input type=hidden name=base>
<input type=hidden name=lang value=<?php echo $_REQUEST["lang"]?>>
</form>

<script>
function Copiarde(db,db_name,lang,file){
	ln=eval("document."+db+"Frm.lang_copy")	document.copiarde.lang_copiar.value=ln.options[ln.selectedIndex].value
	document.copiarde.db.value=db
	document.copiarde.archivo.value=file
	document.copiarde.submit()
	//ln=document.bibloFrm.getElementById("lang_copy")
	//alert(ln.name)}
</script>

<?php
function CopiarDe($iD,$name,$lang,$file){
global $db_path;
	echo "<select name=lang_copy onchange='Copiarde(\"$iD\",\"$name\",\"$lang\",\"$file\")' id=lang_copy > ";
	echo "<option></option>\n";
	$fp=file($db_path."opac_conf/$lang/lang.tab");
	foreach ($fp as $value){
		if (trim($value)!=""){
			$a=explode("=",$value);
			echo "<option value=".$a[0];
			echo ">".trim($a[1])."</option>";
		}
	}
	echo "</select>";
}
function Entrada($iD,$name,$lang,$file,$base){
global $msgstr,$db_path;
	echo "<strong>". $name."</strong></a>";
	echo "<div  id='$iD' style=\"border:1px solid;\">\n";
	echo "<div style=\"display: flex;\">";
	$cuenta_00=0;
	if (!file_exists($db_path."opac_conf/$lang/$file")){
		$fp=array();
		for ($i=0;$i<5;$i++)
			$fp[]='|||';
		$ix="N";
	}else{
		$fp=file($db_path."opac_conf/$lang/$file");
		for ($i=0;$i<5;$i++)
			$fp[]='|||';
		$ix="Y";
	}
    echo "<div style=\"flex: 0 0 50%;\">";
	echo "<form name=$iD"."Frm method=post>\n";
	echo "<input type=hidden name=Opcion value=Guardar>\n";
    echo "<input type=hidden name=base value=$base>\n";
    echo "<input type=hidden name=file value=\"$file\">\n";
    echo "<input type=hidden name=lang value=\"$lang\">\n";
    if (isset($_REQUEST["conf_level"])){
		echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	}
	echo "<strong>opac_conf/$lang/$file</strong><br>";

	echo "<table bgcolor=#cccccc cellpadding=5>\n";
	echo "<tr><th>".$msgstr["ix_nombre"]."</th><th>".$msgstr["ix_pref"]."</th><th>".$msgstr["ix_cols"]."</th><th>".$msgstr["ix_postings"]."</th></tr>\n";
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
				if ($ix!=2){
					echo "<td bgcolor=white>";
				 	if ($ix!=4){
				 		if ($ix==0)
				 			$size=30;
						else
							$size=8;
				 		echo "<input type=text name=conf_base_".$row."_".$ix." value=\"$var\" size=$size>";
					}else{
						echo "<input type=checkbox name=conf_base_".$row."_".$ix." value=ALL";
						if ($var=="ALL") echo " checked";
						echo ">";
			 		};
					echo "</td>\n";
				}
			}
			echo "</tr>\n";
		}
	}
	echo "<tr><td colspan=4 align=center> ";
	echo "<p><input type=submit value=\"".$msgstr["save"]." ".$iD." (opac_conf/$lang/$file)\"></td></tr>";
	echo "</table>\n";
	echo "</div>";
	echo "<div style=\"flex: 1\">";
	$cuenta=0;
	if ($base!="" and $base!="META"){
	    $fp_campos=file($db_path.$base."/data/$base.fst");
	    $cuenta=count($fp_campos);
		if ($cuenta>0){
			echo "<table bgcolor=#cccccc cellpadding=2 width=100%>\n";
        	echo "<tr><td colspan=3>";
        	echo "<strong>$base/data/$base.fst</strong><br><br></td></tr>";
			foreach ($fp_campos as $value) {
				if (trim($value)!=""){
					$v=explode(' ',$value,3);
					echo "<tr><td bgcolor=white>".$v[0]."</td><td bgcolor=white>".$v[1]."</td><td bgcolor=white>".$v[2]."</td></tr>\n";
				}
			}
			echo "</table>";
		}
	}else{		if ($base=="META"){			$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat");
			foreach ($fp as $value){				$v=explode("|",$value);
				$bd_ix=$v[0];
				if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/$bd_ix.ix")){					echo "<p><strong><font color=darkred>".$msgstr["indice_alfa"]." &nbsp$bd_ix.ix</font></strong>";
					echo "<table bgcolor=#cccccc cellpadding=5>\n";
					echo "<tr><th>".$msgstr["ix_nombre"]."</th><th>".$msgstr["ix_pref"]."</th><th>".$msgstr["ix_cols"]."</th><th>".$msgstr["ix_postings"]."</th></tr>\n";					$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/$bd_ix.ix");
					foreach($fp as $linea){						$l=explode('|',$linea);
						if (count($l)!=5) $l[]="";
						echo "<tr>";
						$ix=-1;
						foreach ($l as $var_l){
							$ix=$ix+1;

							if ($ix!=2){
								echo "<td bgcolor=white>";
								if ($ix!=4){
				 					echo $var_l;

								}else{
									echo "<input type=checkbox name=check_b value=ALL";
									if ($var_l=="ALL") echo " checked";
									echo ">";
			 					}
								echo "</td>\n";
							}
						}
						echo "</tr>\n";
					}
					echo "</table>";				}else{					echo "<font color=red><strong>".$msgstr["missing"]." ".$msgstr["indice_alfa"]." &nbsp$bd_ix.ix</strong></font><p>";				}			}		}	}
	echo "</div></div>";
	echo "</form></div><p>";

}
?>
