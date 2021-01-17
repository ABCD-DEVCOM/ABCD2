<?php
$url_back="procesos_base.php?base=".$_REQUEST["base"].'&';
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=help&title=OPAC-ABCD_formatos#Formatos_para_la_presentación_de_los_resultados";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_formatos#Formatos_para_la_presentación_de_los_resultados";
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";

if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){	$lang=$_REQUEST["lang"];
	$archivo=$db_path."opac_conf/$lang/".$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			if (substr($var,0,9)=="conf_base"){				$x=explode('_',$var);
				if ($x[3]==0)
					if (substr($value,strlen($value)-4)==".pft") $value=substr($value,0,strlen($value[0])-5) ;
				$linea[$x[2]][$x[3]]=$value;
			}
		}
	}
	$ix=0;
	foreach ($linea as $value){		$ix=$ix+1;
		$salida=$value[0].'|'.$value[1];
		if (isset($_REQUEST["consolida"])){
			if ($ix==$_REQUEST["consolida"])
				$salida.='|Y';
			else
				$salida.='|';
		}else{			$salida.='|';		}
		fwrite($fout,$salida."\n");
	}

	//fclose($fout);
    echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</font>";
    echo "<p><h3>".$msgstr["add_topar"];
    if ($_REQUEST["base"]!="META") echo " (".$_REQUEST["base"].".par)";
    echo "</h3>";
	echo "<br><br>";
	if ($_REQUEST["base"]=="META"){		$msg="<i>[dbn]</i>";
	}else{
		$msg=$_REQUEST["base"];	}
	foreach ($linea as $value){
		echo "<strong><font face=courier size=4>".$value[0].".pft=%path_database%".$msg."/pfts/%lang%/".$value[0].".pft</font></strong><br>";
    }
    include ("../php/footer.php");
    die;
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
    echo $msgstr["select_formato"]." &nbsp ";
    include("wiki_help.php");

//DATABASES
$archivo=$db_path."opac_conf/$lang/bases.dat";
$fp=file($archivo);
if ($_REQUEST["base"]=="META"){
	Entrada("MetaSearch",$msgstr["metasearch"],$lang,"formatos.dat","META");}else{
	foreach ($fp as $value){		if (trim($value)!=""){
			$x=explode('|',$value);
			if ($x[0]!=$_REQUEST["base"]) continue;
			echo "<p>";
			Entrada(trim($x[0]),trim($x[1]),$lang,trim($x[0])."_formatos.dat",$x[0]);
			break;
		}	}
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
<form name=copiarde method=post>
<input type=hidden name=db>
<input type=hidden name=archivo>
<input type=hidden name=Opcion value=copiarde>
<input type=hidden name=lang_copiar>
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
	echo "<br>copiar de: ";
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
	echo "</select><br>";
}
function Entrada($iD,$name,$lang,$file,$base){
global $msgstr,$db_path;
	echo "<strong>". $name;
	If ($base!="" and $base!="META") echo  " ($base)";
	echo "</strong>";
	echo "<div  id='$iD' style=\"border:1px solid; display:block;\">\n";
	echo "<div style=\"display: flex;\">";
	$cuenta=0;
	if ($base!="" and $base!="META"){
	    $fp_campos=file($db_path.$base."/pfts/".$_REQUEST["lang"]."/formatos.dat");

	    $cuenta=count($fp_campos);
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
	echo "<font color=red><strong>".$msgstr["no_pft_ext"]."</strong></font><br>";
	$cuenta_00=0;

		if (file_exists($db_path."opac_conf/$lang/$file")){
			$fp=file($db_path."opac_conf/$lang/$file");
			$cuenta_00=count($fp);
		}

    $rows=$cuenta-$cuenta_00+3;
    if ($rows<3) $rows=3;
    for ($i=0;$i<$rows;$i++)
		$fp[]='||';
	echo "<table bgcolor=#cccccc cellpadding=5>\n";
	echo "<tr><th>Pft</th><th>".$msgstr["nombre"]."</th><th>".$msgstr["pft_meta"]."</th></tr>\n";
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
				if ($ix>1) break;
				echo "<td bgcolor=white>";
		 		if ($ix==0)
		 			$size=8;
				else
					$size=30;
			 	echo "<input type=text name=conf_base_".$row."_".$ix." value=\"$var\" size=$size>";

			 	if ($size==30) {			 		echo "</td><td>";
			 		echo "<input type=radio name=consolida value=$row";
			 		if (isset($v[2]) and $v[2]=="Y") echo " checked";
			 		echo ">\n";
			 		echo "</td><td>";
				}
			 	if ($size==30 and trim($v[0])!=""){			 		echo  " &nbsp; <a href=javascript:EditarPft('".$v[0]."')>".$msgstr["edit"]."</a>";			 	}
				echo "</td>\n";
			}
			echo "</tr>\n";
		}
	}
	echo "<tr><td colspan=2 align=center> ";
	echo "<p><input type=submit value=\"".$msgstr["save"]." ".$iD."\"></td></tr>";
	echo "</table>\n";
	echo "</div>\n";
	echo "<div style=\"flex: 1\">";
	if ($cuenta>0){
		echo "<strong>$base/$lang/formatos.dat</strong><br>";
		echo "<table bgcolor=#cccccc cellpadding=5>\n";
		echo "<tr><th>Pft</th><th>".$msgstr["nombre"]."</th></tr>\n";
		foreach ($fp_campos as $value) {			$value=trim($value);
			if ($value!=""){
				$v=explode('|',$value);
				echo "<tr><td>".$v[0]."</td><td>".$v[1]."</td></tr>\n";
			}
		}
		echo "</table>";
	}
	echo "</div></div>";
	echo "</form></div><p>";
}
?>
<script>
function EditarPft(Pft){	params ="scrollbars=auto,resizable=yes,status=no,location=no,toolbar=no,menubar=no,width=800,height=600,left=0,top=0"
	msgwin=window.open("editar_pft.php?Pft="+Pft+"&base=<?php echo $_REQUEST["base"]."&lang=".$_REQUEST["lang"]."&db_path=".$_REQUEST["db_path"];?>",'pft',params)
	msgwin.focus()}
</script>