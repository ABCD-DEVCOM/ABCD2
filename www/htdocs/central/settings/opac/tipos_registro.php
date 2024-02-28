<?php
include ("conf_opac_top.php");
$wiki_help="OPAC-ABCD_configuraci%C3%B3n_avanzada#Tipos_de_registro";
include "../../common/inc_div-helper.php";

?>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
			<?php include("conf_opac_menu.php");?>
	</div>
	<div class="formContent col-9 m-2">
	<h3><?php echo $msgstr["tipos_registro"];?></h3>

<?php
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";

if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	$archivo=$db_path.$_REQUEST['base']."/opac/$lang/".$_REQUEST["file"];
	foreach ($_REQUEST as $var=>$value){
		if (trim($value)!=""){
			$code=explode("_",$var);
			if ($code[0]=="conf"){
				if ($code[1]=="lc"){
					if (!isset($id[$code[2]])){
						$id[$code[2]]=$value;
					}
				} elseif ($code[1]=="ln"){
					if (!isset($nom_idioma[$code[2]])){
						$name_type[$code[2]]=$value;
					}

				} else {
					if (!isset($pref[$code[2]])){
						$pref[$code[2]]=$value;
						
					}
				}
			}
		}
	}

    $fout=fopen($archivo,"w");
    $ix=0;
	foreach ($id as $key=>$value){
	$ix=$ix+1;
	//$salida=$value[$key];
	fwrite($fout,$value."|".$name_type[$key]."|".$pref[$key]."\n");
	}


	fclose($fout);
    echo "<h4 class='color-green'>".$archivo." ".$msgstr["updated"]."</h4>";
	die;
}
?>
<form name=indices method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>

<?php

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){
	$archivo=$db_path."opac_conf/$lang/bases.dat";
	$fp=file($archivo);
	foreach ($fp as $value){
		if (trim($value)!=""){
			echo "<p>";
			$x=explode('|',$value);
			if ($x[0]!=$_REQUEST["base"])  continue;
			Entrada(trim($x[0]),trim($x[1]),$lang,trim($x[0])."_colecciones.tab",$x[0]);
			break;
		}
	}
}
?>
</div>
</form>



<?php
function Entrada($iD,$name,$lang,$file,$base){
global $msgstr,$db_path;
	echo "<strong>". $name."</strong>";
	echo "<div  id='$iD' style=\"display:block;\">\n";
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
	if (!file_exists($db_path.$_REQUEST['base']."/opac/$lang/$file")){
		$fp=array();
		for ($i=0;$i<8;$i++){
			$fp[]="||";
		}
	}else{
		$fp=file($db_path.$_REQUEST['base']."/opac/$lang/$file");
		$fp[]='||';
		$fp[]='||';
		$fp[]='||';
	}

	echo "<br><table class=\"table\" width=100%>\n";
	echo "<tr><th>".$msgstr["id"]."</th><th>".$msgstr["nombre"]."</th><th>".$msgstr["ix_pref"]."</th></tr>\n";
	$ix=0;	
	$row=0;	

	foreach ($fp as $value) {

	$row=$row+1;


		if (trim($value)!=""){
			$l=explode('|',$value);
			$ix=$ix+1;
			echo "<tr><td><input type=text name=conf_lc_".$ix." size=5 value=\"".trim($l[0])."\"></td>";
			echo "<td><input type=text name=conf_ln_".$ix." size=30 value=\"".trim($l[1])."\"></td>";
			echo "<td><input type=text name=conf_lp_".$ix." size=10 value=\"".trim($l[2])."\"></td>";
			echo "</tr>";
		}




	}
	echo "<tr><td colspan=2 align=center> ";
	echo "<p><input type=submit value=\"".$msgstr["save"]." ".$iD."\"></td></tr>";
	echo "</table>\n";
	echo "</form></div><p>";

	if ($cuenta>0){
		echo "<div style=\"flex: 1\">";
		echo "<strong>$base/$lang/typeofrecord.tab</strong><br>";
		echo "<br><table class=\"table striped\" width=100%>\n";
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
</div>
</div>

<?php include ("../../common/footer.php"); ?>