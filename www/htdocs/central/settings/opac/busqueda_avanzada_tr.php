<?php
include ("tope_config.php");
$wiki_help="index.php?desde=help&title=OPAC-ABCD_configuraci%C3%B3n_avanzada#B.C3.BAsqueda_avanzada_-_Tipos_de_registro";
include "../../common/inc_div-helper.php";

?>

<div class="middle form">
   <h3><?php echo $msgstr["buscar_a"]." - ".$msgstr["tipos_registro"];?>
	</h3>
	<div class="formContent">

<div id="page">
<?php
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (!isset($_SESSION["db_path"])){
	echo "Session expired";die;
}

$db_path=$_SESSION["db_path"];
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	
	$archivo_conf=$db_path."opac_conf/$lang/".$_REQUEST["file"];

	foreach ($_REQUEST as $var=>$value){
		if (trim($value)!=""){
			$code=explode("_",$var);
			if ($code[0]=="conf"){
				if ($code[1]=="lc"){
					if (!isset($cod_idioma[$code[2]])){
						$cod_idioma[$code[2]]=$value;
					}
				}else{

					if (!isset($nom_idioma[$code[2]])){
						$nom_idioma[$code[2]]=$value;
						
					}
				}
			}
		}
	}

    $fout=fopen($archivo_conf,"w");
	foreach ($cod_idioma as $key=>$value){
		fwrite($fout,$value."|".$nom_idioma[$key]."\n");
	//	echo $value."|".$nom_idioma[$key]."<br>";
	}
	fclose($fout);
    echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</font>";
	die;

}


?>
<form name=indices method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>
<div id="page">

<?php
//DATABASES
$archivo=$db_path."opac_conf/$lang/bases.dat";
$fp=file($archivo);
foreach ($fp as $value){
	if (trim($value)!=""){
		echo "<p>";
		$x=explode('|',$value);
		if ($_REQUEST["base"]!=$x[0]) continue ;
		if(!file_exists($db_path."opac_conf/$lang/".$x[0]."_colecciones.tab")){
			echo "<h4>".$msgstr["nrt_defined"]." ".$x[0]."</h4><br>";
			continue;
		}
		if(file_exists($db_path."opac_conf/$lang/".$x[0]."_colecciones.tab")){
			$fpTm=file($db_path."opac_conf/$lang/".$x[0]."_colecciones.tab");
			echo "<strong>".$x[1]."</strong><p>";
			foreach ($fpTm as $coleccion){
				if (trim($coleccion)!=""){
					$c=explode('|',$coleccion);
					$TM=$c[0];
					Entrada(trim($x[0]),trim($x[1]),$lang,trim($x[0])."_avanzada_$TM.tab",$c[1],$TM,$x[0]);
				}
			}

		}
	}
}
?>
</div>

</div>
</div>
</div>

<?php include ("../../common/footer.php"); ?>
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
$ix=3;	
	$row=0;
	foreach ($fp as $value){
		if (trim($value)!=""){
			$l=explode('|',$value);
			$ix=$ix+1;
			echo "<tr><td><input type=text name=conf_lc_".$ix." size=5 value=\"".trim($l[0])."\"></td>";
			echo "<td><input type=text name=conf_ln_".$ix." size=30 value=\"".trim($l[1])."\"></td>";
			echo "</tr>";
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
<input type=hidden name=lang value="<?php echo $lang;?>">
</form>