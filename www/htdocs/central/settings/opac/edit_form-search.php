<?php
/**
 * 20230305 rogercgui Adds the variable $actparfolder;
 * 20230305 rogercgui Fixes bug in the absence of the file camposbusqueda.tab;
*/

include ("tope_config.php");
$wiki_help="OPAC-ABCD_Configuraci%C3%B3n_de_bases_de_datos#B.C3.BAsqueda_Libre";
include "../../common/inc_div-helper.php";
?>

<div class="middle form">
   <h3><?php echo $msgstr["free_search"]?>
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
	
	$archivo_conf=$db_path.$_REQUEST['base']."/opac/$lang/".$_REQUEST["file"];

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
?>

<p class="color-green"><strong><?php echo $archivo_conf." ".$msgstr["updated"];?></strong></p>

<?php
	die;
}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){

	//DATABASES
	$archivo=$db_path."opac_conf/$lang/bases.dat";
	$fp=file($archivo);
	if ($_REQUEST["base"]=="META"){
		Entrada("MetaSearch",$msgstr["metasearch"],$lang,$_REQUEST['o_conf'].".tab","META");
	}else{
		foreach ($fp as $value){
			if (trim($value)!=""){
				$x=explode('|',$value);
				if ($_REQUEST["base"]!=$x[0])  continue;
				Entrada(trim($x[0]),trim($x[1]),$lang,trim($x[0])."_".$_REQUEST['o_conf'].".tab",$x[0]);
			}
		}
	}

	?>
	</div>
<?php
}

?>
</div>
</div>


<?php

function Entrada($iD,$name,$lang,$file,$base){
global $msgstr,$db_path, $archivo_conf;

echo "<strong>". $name;
	if ($base!="" and $base!="META") echo " ($base)";
	echo "</strong>";
	echo "<div  id='$iD' >\n";
	echo "<div style=\"display: flex;\">";
	$cuenta=0;
	$file_fieldsearch=$db_path.$base."/pfts/".$_REQUEST["lang"]."/camposbusqueda.tab";
	
	if (file_exists($file_fieldsearch)) {
		$fp_campos[$base]=file($file_fieldsearch);
	} else {
		 $fp_campos[$base]="";
	}

if ($base!="" and $base!="META"){
	    $cuenta=count($fp_campos);
	}

	if ($base!="" and $base=="META"){
    	$fpbases=file($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat");
    	foreach ($fpbases as $value) {
    		$v=explode('|',$value);
    		$b_0=$v[0];
    		$fpbb=file($db_path.$b_0."/pfts/".$_REQUEST["lang"]."/camposbusqueda.tab");
    		foreach ($fpbb as $campos) {
    			$fp_campos[$b_0][]=$campos;
    		}
    	}
    	$cuenta=count($fp_campos);
    	//echo "<pre>";print_r($fp_campos);die;
    }
    ?>


    <div style="flex: 0 0 50%;">
	<form name="<?php echo $iD;?>Frm" method="post">
	<input type="hidden" name="Opcion" value="Guardar">
    <input type="hidden" name="base" value="<?php echo $base;?>">
    <input type="hidden" name="file" value="<?php echo $file;?>">
    <input type="hidden" name="lang" value="<?php echo $lang;?>">

    <?php
    if (isset($_REQUEST["conf_level"])){
		echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	}
	echo "<strong>".$base."/opac/".$lang."/".$file."</strong><br>";
	$cuenta_00=0;

	if (file_exists($db_path.$base."/opac/$lang/$file")){
		$fp=file($db_path.$base."/opac/$lang/$file");
		$cuenta_00=count($fp);
		if ($cuenta_00==0) $fp=array('||');
	} else{
		$fp=array('||');
	}
$ix=3;	
  	echo "<table bgcolor=#cccccc cellpadding=5>\n";
	echo "<tr><th>".$msgstr["ix_nombre"]."</th><th>".$msgstr["ix_pref"]."</th></tr>";

if ($base!="" and $base!="META"){
	$file_av=$db_path.$base."/opac/$lang/$file";
} else {
	$file_av=$db_path."/opac_conf/$lang/$file";
}

if (file_exists($file_av)){
	$fp=file($file_av);
	
	foreach ($fp as $value){
		if (trim($value)!=""){
			$l=explode('|',$value);

			if ($_REQUEST['o_conf']=="libre") {
				$ix=0;
			} else {
			$ix=$ix+1;
			}
			
			echo "<tr><td><input type=text name=conf_lc_".$ix." size=30 value=\"".trim($l[0])."\"></td>";
			echo "<td><input type=text name=conf_ln_".$ix." size=5 value=\"".trim($l[1])."\"></td>";
			echo "</tr>";
		}
	}
}
if ($ix==5){
	$tope=8;
}else{
	$tope=$ix+9;
	$ix=9;
}
for ($i=$ix;$i<$tope;$i++){
	echo "<tr><td><input type=text name=conf_lc_".$i." size=30 value=\"\"></td>";
	echo "<td><input type=text name=conf_ln_".$i." size=5 value=\"\"></td>";
	echo "</tr>";
}
	echo "</table>\n";
	echo "<input class='bt-green' type=submit value=\"".$msgstr["save"]." ".$iD."_".$_REQUEST['o_conf'].".tab\"></td></tr>";
	echo "</div>\n";
	

	echo "<div style=\"flex: 1\">";

	if ($cuenta>0){
			foreach ($fp_campos as $key=>$value_campos){
				echo "<strong>$key/$lang/camposbusqueda.tab (central ABCD)</strong><br>";
				echo "<table bgcolor=#cccccc cellpadding=5>\n";
				echo "<tr><th>".$msgstr["ix_nombre"]."</th><th>".$msgstr["ix_pref"]."</th></tr>\n";
				if (!empty($value_campos)) 
				foreach ($value_campos as $value) {
					$v=explode('|',$value);
					echo "<tr><td>".$v[0]."</td><td>".$v[2]."</td></tr>\n";
				}
				echo "</table>";
			}
		}
	}

	
	echo "</div></div>";
	echo "</form>";

?>

</div>
</div>

<?php include ("../../common/footer.php"); ?>