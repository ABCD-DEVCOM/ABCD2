<?php
include ("tope_config.php");
$wiki_help="OPAC-ABCD_configuraci%C3%B3n_avanzada#.C3.8Dndices_alfab.C3.A9ticos";
include "../../common/inc_div-helper.php";

?>

<div class="middle form">
   <h3><?php echo $msgstr["indice_alfa"];?>
	</h3>
	<div class="formContent">

<div id="page">


<form name=indices method=post>
<input type=hidden name=db_path value=<?php echo $db_path;?>>


<?php

	if (!isset($_SESSION["db_path"])){
		echo "Session expired";die;
	}



foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){

	$archivo=$db_path."opac_conf/$lang/".$_REQUEST["file"];

	foreach ($_REQUEST as $var=>$value){
		if (trim($value)!=""){
			$code=explode("_",$var);
			if ($code[0]=="conf"){
				if ($code[1]=="lc"){
					if (!isset($field_ix[$code[2]])) {
						$field_ix[$code[2]]=$value;
					}
				} elseif ($code[1]=="lp") {
						if (!isset($pref_ix[$code[2]])) {
						$pref_ix[$code[2]]=$value;
					}
				} elseif ($code[1]=="ln")  {
					if (!isset($ln[$code[2]])) {
						$ln[$code[2]]=$value;
					} else {
						$ln[$code[2]]="1";
					}
				} elseif ($code[1]=="df")  {
					if (!isset($display[$code[2]])) {
						$display[$code[2]]=$value;
					} else {
						$display[$code[2]]="";
					}
				}
			}
		}
	}

    $fout=fopen($archivo,"w");
	foreach ($field_ix as $key=>$value){
		if (isset($pref_ix[$key])) { 
			$prefix=$pref_ix[$key];
		} else {
			$prefix="";
		}
		
		if (isset($ln[$key])) { 
			$ncols=$ln[$key];
		} else {
			$ncols="";
		}

		if (isset($display[$key])) {
			$d_all=$display[$key];
		} else {
			$d_all="";
		}

		fwrite($fout,$value."|".$prefix."|".$ncols."|".$d_all."\n");

		//echo $value."|".$pref_ix[$key]."|".$ln[$key]."|".$display[$key]."<br>";
	}
	fclose($fout);
    echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</font>";
	die;


//fclose($fout);
    echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["file"]." ".$msgstr["updated"]."</font>";
    echo "<p><h3>".$msgstr["add_topar"];
    if ($_REQUEST["base"]!="META") echo " (".$_REQUEST["base"].".par)";
    echo "</h3>";
	echo "<br><br>";
	if ($_REQUEST["base"]=="META"){
		$msg="<i>[dbn]</i>";
	}else{
		$msg=$_REQUEST["base"];
	}
	foreach ($linea as $value){
		echo "<strong><font face=courier size=4>".$value[0].".pft=%path_database%".$msg."/pfts/%lang%/".$value[0].".pft</font></strong><br>";
    }
    die;
}



if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="copiarde"){
	$archivo=$db_path."opac_conf/".$_REQUEST["lang_copiar"]."/".$_REQUEST["archivo"];
	copy($archivo,$db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["archivo"]);
	echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["archivo"]." ".$msgstr["copiado"]."</font>";
}

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]==""){
	//DATABASES
	if ($_REQUEST["base"]=="META"){
		Entrada("MetaSearch",$msgstr["metasearch"],$lang,"indice.ix","META");
	}else{
		$archivo=$db_path."opac_conf/$lang/bases.dat";
		$fp=file($archivo);
		foreach ($fp as $value){
			if (trim($value)!=""){
	  			$x=explode('|',$value);
				if ($_REQUEST["base"]!=$x[0])  continue;
				Entrada(trim($x[0]),trim($x[1]),$lang,trim($x[0]).".ix",$x[0]);
			}
		}
	}
}
//METASEARCH
//;
?>


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
	ln=eval("document."+db+"Frm.lang_copy")
	document.copiarde.lang_copiar.value=ln.options[ln.selectedIndex].value
	document.copiarde.db.value=db
	document.copiarde.archivo.value=file
	document.copiarde.submit()
	//ln=document.bibloFrm.getElementById("lang_copy")
	//alert(ln.name)
}
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
	echo "<div  id='$iD' >\n";
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
		$ix=0;	
	
	$row=0;
	foreach ($fp as $value) {
	$row=$row+1;

		if (trim($value)!=""){
			$l=explode('|',$value);
			$ix=$ix+1;
			echo "<tr><td><input type=text name=conf_lc_".$ix." size=5 value=\"".trim($l[0])."\"></td>";
			echo "<td><input type=text name=conf_lp_".$ix." size=30 value=\"".trim($l[1])."\"></td>";
			echo "<td><input type=text name=conf_ln_".$ix." size=30 value=\"".trim($l[2])."\"></td>";
	 		echo "<td>";
			echo "<input type=checkbox name=conf_df_".$ix." value=ALL";
			 if (isset($l[3]) and trim($l[3])=="ALL") echo " checked";
			echo ">\n";
			echo "</td>";
			echo "</tr>";
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
	}else{

		if ($base=="META"){
			$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat");
			foreach ($fp as $value){
				$v=explode("|",$value);
				$bd_ix=$v[0];
				if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/$bd_ix.ix")){
					echo "<p><strong><font color=darkred>".$msgstr["indice_alfa"]." &nbsp$bd_ix.ix</font></strong>";
					echo "<table bgcolor=#cccccc cellpadding=5>\n";
					echo "<tr><th>".$msgstr["ix_nombre"]."</th><th>".$msgstr["ix_pref"]."</th><th>".$msgstr["ix_cols"]."</th><th>".$msgstr["ix_postings"]."</th></tr>\n";
					$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/$bd_ix.ix");
					foreach($fp as $linea){
						$l=explode('|',$linea);
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
					echo "</table>";
				}else{
					echo "<font color=red><strong>".$msgstr["missing"]." ".$msgstr["indice_alfa"]." &nbsp$bd_ix.ix</strong></font><p>";
				}
			}
		}
	}
	echo "</div></div>";
	echo "</form></div><p>";

}
?>


</div>
</div>
</div>

<?php include ("../../common/footer.php"); ?>