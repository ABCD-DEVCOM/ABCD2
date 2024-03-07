<?php
include ("conf_opac_top.php");
$wiki_help="OPAC-ABCD_configuraci%C3%B3n_avanzada#Extracci.C3.B3n_de_claves_para_presentar_el_.C3.ADndice";
include "../../common/inc_div-helper.php";
?>

<script>
var idPage="db_configuration";
</script>


<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
			<?php include("conf_opac_menu.php");?>
	</div>
	<div class="formContent col-9 m-2">

	<?php include("menu_dbbar.php");  ?>

	<h3><?php echo $msgstr["aut_opac"];?></h3>

<?php

//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){

	$archivo=$db_path.$_REQUEST["base"]."/pfts/".$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			if ($var=="conf_autoridades"){
				fwrite($fout,$value."\n");
				fclose($fout);
				echo "<p><br><font color=red>". $_REQUEST["base"]."/pfts/".$_REQUEST["file"]." ".$msgstr["updated"]."</font><p>";
            }
		}
	}
	echo "<p><h3>".$msgstr["add_topar"]."<br>";
	echo "<strong><font face=courier size=4>autoridades_opac.pft=%path_database%".$_REQUEST["base"]."/pfts/autoridades_opac.pft</font></strong><br>";

}else{
	$base=$_REQUEST["base"];
	$archivo=$db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat";
	$fp=file($archivo);
	foreach ($fp as $value){
		if (trim($value)!=""){
			$x=explode('|',$value);
			if ($x[0]!=$_REQUEST["base"]) continue;
			echo "<p>";
			$x=explode('|',$value);
			Entrada(trim($x[0]),trim($x[1]),$lang,"autoridades_opac.pft",$x[0]);
		}
	}
}


?>

<?php
function ConstruirPft($db_path,$base){
//A TRAVES DEL PREFIJO DEFINIDO PARA CADA INDICE (DBN.IX) SE LEE LA FST PARA DETERMINAR QUE CAMPOS A UTILIZAR
//PARA LA ELABORACION DE AUTORIDADES_OPAC.PFT
	$autoridades_pft="";
	$archivo=$db_path.$base."/opac/".$_REQUEST["lang"]."/$base.ix";
	if (!file_exists($archivo)) {
	}else{
		$fp=file($archivo);
		foreach ($fp as $value) {
			$value=trim($value);
			if ($value!=""){
				$v=explode('|',$value);
				$prefijo[$v[1]]=$v[1];
			}
		}
	}
	if ($base!=""){
	    $fp_campos=file($db_path.$base."/data/$base.fst");
	    $cuenta=count($fp_campos);
    }
	if ($cuenta>0){
        $index_str=array();
		foreach ($fp_campos as $value) {
			if (trim($value)!=""){
				$v=explode(' ',$value,3);
				if (isset($prefijo))
				foreach ($prefijo as $pref){
					if (strpos($value,$pref)!==false){
						if (isset($index_str[$pref])){
							$index_str[$pref].="^^^^".$value;
						}else{
							$index_str[$pref]=$value;
						}
					}
				}
			}
		}
	}
	foreach ($index_str as $key=>$value){
		$linea=explode('^^^^',$value);
		foreach ($linea as $fst){
			$cols=explode(" ",$fst,3);
			$autoridades[$cols[0]]=$cols[2];
			$format=$cols[2];
			$ixpref=strpos($format,$key);
			$format=substr($format,$ixpref-2);
			$format=str_ireplace("mpu,","",$format);
			$format=str_ireplace("mpl,","",$format);
			$format=str_ireplace("mdu","mdl",$format);
			$format=str_ireplace("mhu","mhl",$format);

			$format=str_ireplace("(|","|",$format);
			$format=str_ireplace('%',"",$format);
			$format=str_ireplace('""',"",$format);
			$format=str_ireplace("''","",$format);
			$format=str_ireplace('/)',"",$format);
			$format=str_ireplace($key,'',$format);
			$format=str_ireplace("'//'","",$format);
			$format=str_ireplace("||","",$format);
			$format=str_ireplace("(v","v",$format);
			$format=trim($format);
			$ix=stripos($format,'v');
			$format=substr($format,$ix);
			$cuenta1=substr_count($format,"if");
			$cuenta2=substr_count($format,"fi");
			if ($cuenta2>$cuenta1){
				$ix=stripos($format,"fi",strlen($format)-5);
				$format=substr($format,0,$ix);
			}
			$ix=strpos($format,'/');
			if ($ix!==false)
				$format=substr($format,0,$ix);
			$format="case ".$cols[0].": $format";
			if ($autoridades_pft=="")
				$autoridades_pft="   ".$format;
			else
				$autoridades_pft.="\n"."   ".$format;
		}
	}
	$autoridades_pft="select e3\n".$autoridades_pft."\nendsel";
	return array($autoridades_pft);
}

function Entrada($iD,$name,$lang,$file,$base){
global $msgstr,$db_path;
	echo "<strong>". $name."</strong>";
	echo "<div  id='$iD' style=\" display:block;\">\n";
	echo "<div style=\"display: flex;\">";
	echo "<div style=\"flex: 0 0 40%;\">";
	echo "<form name=$iD"."Frm method=post>\n";
	echo "<input type=hidden name=Opcion value=Guardar>\n";
    echo "<input type=hidden name=base value=$iD>\n";
    echo "<input type=hidden name=file value=\"$file\">\n";
    echo "<input type=hidden name=lang value=\"$lang\">\n";
    if (isset($_REQUEST["conf_level"])){
		echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	}
	echo "<strong>$file</strong><br>";
	$row=1;
	$ix=1;
	$new="";
	//echo $db_path.$base."/".$file;
	if (file_exists($db_path.$base."/pfts/autoridades_opac.pft")){
		//echo $base."/pfts/autoridades_opac.pft";
		$fp=file($db_path.$base."/pfts/autoridades_opac.pft");
	}else{
		if (file_exists($db_path.$base."/".$file)){
			$fp=file($db_path.$base."/".$file);
			//echo $$base."/autoridades_opac.pft";
		}else{
			$fp=ConstruirPft($db_path,$base);
            echo "<strong>".$msgstr["edit_ir"]."</strong>";
       }
	}

	echo "<textarea name=conf_autoridades rows=20 cols=90>";
	$ixcuenta=0;
	foreach ($fp as $value){
		echo $value;
	}
	echo "</textarea>";
	echo  "<div><input type=submit value=\"".$msgstr["save"]." ".$iD."/pfts/autoridades_opac.pft\" class=\"bt-green\"></div>";;
	echo "</form>";

	echo "</div>";

	echo "<div style=\"display: block-inline; border=1px solid\">";
	$archivo=$db_path.$base."/opac/".$_REQUEST["lang"]."/$base.ix";
	$ar=$base."/opac/".$_REQUEST["lang"]."/$base.ix";
	if (!file_exists($archivo)){
		echo "<font color=red>".$msgstr["missing"]."$ar</font><p>";
	}
	if (file_exists($archivo)){
		$fp=file($archivo);
		echo "<h4>".$msgstr["indice_alfa"]. " (".$base.".ix)</h4>";
		echo "<br><table class=\"table striped\" width=100%>\n";
		echo "<tr><th>".$msgstr["ix_nombre"]."</th><th>".$msgstr["ix_pref"]."</th><th>".$msgstr["ix_cols"]."</th><th>".$msgstr["ix_postings"]."</th></tr>\n";
		$row=0;
		foreach ($fp as $value) {
			$value=trim($value);
			if ($value!=""){
				$value.='|';
				$v=explode('|',$value);

				echo "<tr>";
				echo "<td>".$v[0]."</td><td>".$v[1]."</td>"."<td>".$v[3]."</td><td>".$v[4]."</td>";
				echo "</tr>\n";
			}
		}
		echo "</table>";
		if ($base!=""){
	    	$fp_campos=file($db_path.$base."/data/$base.fst");
	    	$cuenta=count($fp_campos);
    	}
		if ($cuenta>0){
			echo "<br><table class=\"table striped\" width=100%>\n";
        	echo "<tr><th colspan=3>";
        	echo "<strong>$base/data/$base.fst</strong></th></tr>";
			foreach ($fp_campos as $value) {
				if (trim($value)!=""){
					$v=explode(' ',$value,3);
					echo "<tr><td>".$v[0]."</td><td>".$v[1]."</td><td>".$v[2]."</td></tr>\n";
				}
			}
			echo "</table>";
		}
		echo "</div></div>";

	}
}
?>

	</div>
	</div>
	</div>

<?php include ("../../common/footer.php"); ?>