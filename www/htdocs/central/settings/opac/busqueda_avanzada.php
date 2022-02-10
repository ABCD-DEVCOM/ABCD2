<?php
$url_back="procesos_base.php?base=".$_REQUEST["base"].'&';
include ("tope_config.php");
$wiki_help="wiki.abcdonline.info/index.php?desde=ayuda&title=OPAC-ABCD_Configuraci%C3%B3n_de_bases_de_datos#B.C3.BAsqueda_Avanzada";
$wiki_trad="wiki.abcdonline.info/index.php?title=OPAC-ABCD_Configuraci%C3%B3n_de_bases_de_datos#B.C3.BAsqueda_Avanzada";
if (isset($_SESSION["showhelp"]) and $_SESSION["showhelp"]=="Y"){
	$showhelp="block";
}else
    $showhelp="none";
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (!isset($_SESSION["db_path"])){	echo "Session expired";die;}
$db_path=$_SESSION["db_path"];
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

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){?>
	<div id="page" style="min-height:400px";>
	    <h3>
<?php
	    echo $msgstr["buscar_a"]." &nbsp;";
        include("wiki_help.php");

	//DATABASES
	$archivo=$db_path."opac_conf/$lang/bases.dat";
	$fp=file($archivo);
	if ($_REQUEST["base"]=="META"){		Entrada("MetaSearch",$msgstr["metasearch"],$lang,"avanzada.tab","META");	}else{
		foreach ($fp as $value){
			if (trim($value)!=""){
				echo "<p>";				$x=explode('|',$value);
				if ($_REQUEST["base"]!=$x[0])  continue;
				Entrada(trim($x[0]),trim($x[1]),$lang,trim($x[0])."_avanzada.tab",$x[0]);
			}		}
	}

	?>
	</div>
<?php
}
include ("../php/footer.php");
?>
</div>
</div>
</body
</html>
<?php

function Entrada($iD,$name,$lang,$file,$base){
global $msgstr,$db_path;

	echo "<strong>". $name;
	if ($base!="" and $base!="META") echo " ($base)";
	echo "</strong>";
	echo "<div  id='$iD' style=\"border:1px solid;\">\n";
	echo "<div style=\"display: flex;\">";
	$cuenta=0;
	if ($base!="" and $base!="META"){
	    $fp_campos[$base]=file($db_path.$base."/pfts/".$_REQUEST["lang"]."/camposbusqueda.tab");

	    $cuenta=count($fp_campos);
    }
    if ($base!="" and $base=="META"){    	$fpbases=file($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat");
    	foreach ($fpbases as $value) {
    		$v=explode('|',$value);
    		$b_0=$v[0];    		$fpbb=file($db_path.$b_0."/pfts/".$_REQUEST["lang"]."/camposbusqueda.tab");
    		foreach ($fpbb as $campos) {    			$fp_campos[$b_0][]=$campos;    		}
    	}
    	$cuenta=count($fp_campos);
    	//echo "<pre>";print_r($fp_campos);die;    }
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
	$cuenta_00=0;
	if (file_exists($db_path."opac_conf/$lang/$file")){
		$fp=file($db_path."opac_conf/$lang/$file");
		$cuenta_00=count($fp);
	}
    $rows=$cuenta-$cuenta_00+8;
    $rows=$rows+6;
    for ($i=0;$i<$rows;$i++)
		$fp[]='||';
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
	echo "<p><input type=submit value=\"".$msgstr["save"]." ".$iD."\"></td></tr>";
	echo "</table>\n";
	echo "</div>\n";
	echo "<div style=\"flex: 1\">";
	if ($cuenta>0){
		foreach ($fp_campos as $key=>$value_campos){
			echo "<strong>$key/$lang/camposbusqueda.tab (central ABCD)</strong><br>";
			echo "<table bgcolor=#cccccc cellpadding=5>\n";
			echo "<tr><th>".$msgstr["ix_nombre"]."</th><th>".$msgstr["ix_pref"]."</th></tr>\n";
			foreach ($value_campos as $value) {
				$v=explode('|',$value);
				echo "<tr><td>".$v[0]."</td><td>".$v[2]."</td></tr>\n";
			}
			echo "</table>";
		}
	}
	echo "</div></div>";
	echo "</form></div><p>";

}
?>

