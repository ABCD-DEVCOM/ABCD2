<?php
include ("conf_opac_top.php");
$wiki_help="OPAC-ABCD_Configuraci%C3%B3n_de_bases_de_datos#B.C3.BAsqueda_Libre";
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

	<h3><?php echo $msgstr["select_formato"];?></h3>

<?php
//foreach ($_REQUEST as $var=>$value) echo "$var=$value<br>";
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
    $ix=0;
	foreach ($cod_idioma as $key=>$value){
	$ix=$ix+1;
		if (isset($_REQUEST["consolida"])){
			if ($ix==$_REQUEST["consolida"])
				$salida ='|Y';
			else
				$salida ='|';
		} else {
			$salida ='|';
		}

		fwrite($fout,$value."|".$nom_idioma[$key].$salida."\n");

//		echo $value."|".$nom_idioma[$key].$salida."<br>";
	}
	fclose($fout);
?>
<p class="color-green"><strong><?php echo $archivo_conf." ".$msgstr["updated"];?></strong></p>

<?php
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
	$archivo_conf=$db_path.$base."/opac/".$_REQUEST["lang_copiar"]."/".$_REQUEST["archivo"];
	copy($archivo_conf,$db_path.$base."/opac/".$_REQUEST["lang"]."/".$_REQUEST["archivo"]);
	echo "<p><font color=red>".$db_path.$base."/opac/$lang/".$_REQUEST["archivo"]." ".$msgstr["copiado"]."</font>";
}


?>
<form name="indices" method="post">
<input type="hidden" name="db_path" value="<?php echo $db_path;?>">

<?php
//DATABASES
$archivo_conf=$db_path."opac_conf/".$lang."/bases.dat";
$fp=file($archivo_conf);
if ($_REQUEST["base"]=="META"){
	Entrada("MetaSearch",$msgstr["metasearch"],$lang,"formatos.dat","META");
}else{
	foreach ($fp as $value){
		if (trim($value)!=""){

			$x=explode('|',$value);
			if ($x[0]!=$_REQUEST["base"]) continue;
			echo "<p>";
			Entrada(trim($x[0]),trim($x[1]),$lang,trim($x[0])."_formatos.dat",$x[0]);
			break;
		}
	}
}
?>


<form name="copiarde" method="post">
<input type="hidden" name="db">
<input type="hidden" name="archivo">
<input type="hidden" name="Opcion" value="copiarde">
<input type="hidden" name="lang_copiar">
<input type="hidden" name="lang" value="<?php echo $_REQUEST["lang"]?>">
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
global $db_path, $archivo_conf;
	echo "<br>copiar de: ";
	echo "<select name=lang_copy onchange='Copiarde(\"$iD\",\"$name\",\"$lang\",\"$file\")' id=lang_copy > ";
	echo "<option></option>\n";
	$fp=file($db_path.$base."/opac/$lang/lang.tab");
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
	echo "<div  id='$iD' style=\" display:block;\">\n";
	echo "<div style=\"display: flex;\">";
	$cuenta=0;
	if ($base!="" and $base!="META"){

		$file_campos=$db_path.$base."/pfts/".$_REQUEST["lang"]."/formatos.dat";
	    
	    if(file_exists($file_campos)) {
			$fp_campos=file($file_campos);
		} else {
			$fp_campos=file($db_path.$base."/pfts/en/formatos.dat");	    	
		}

	    $cuenta=count($fp_campos);
    }
?>
    <div class="w-30">
		<form name="<?php echo $iD;?>Frm" method="post">
		<input type="hidden" name="Opcion" value=Guardar>
    	<input type="hidden" name="base" value=<?php echo $base;?>>
    	<input type="hidden" name="file" value="<?php echo $file;?>">
    	<input type="hidden" name="lang" value="<?php echo $lang;?>">
	<?php
    if (isset($_REQUEST["conf_level"])){
		echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
	}
	echo "<strong>".$base."/opac/".$lang."/".$file."</strong><br>";
	echo "<small>".$msgstr["no_pft_ext"]."</small><br>";
	$cuenta_00=0;

		if (file_exists($db_path.$base."/opac/$lang/$file")){
			$fp=file($db_path.$base."/opac/$lang/$file");
			$cuenta_00=count($fp);
		}

    $rows=$cuenta-$cuenta_00+3;
    if ($rows<3) $rows=3;
    for ($i=0;$i<$rows;$i++)
		$fp[]='||';
	$ix=0;	
	$row=0;	
	echo "<table cellpadding=5>\n";
	echo "<tr><th>Pft</th><th>".$msgstr["nombre"]."</th><th  width=50>".$msgstr["pft_meta"]."</th></tr>\n";

	foreach ($fp as $value) {

	$row=$row+1;

		if (trim($value)!=""){
			$l=explode('|',$value);
			$ix=$ix+1;
			echo "<tr><td><input type=text name=conf_lc_".$ix." size=5 value=\"".trim($l[0])."\"></td>";
			echo "<td><input type=text name=conf_ln_".$ix." size=30 value=\"".trim($l[1])."\"></td>";
	 		echo "<td>";
			echo "<input type=radio name=consolida value=$row";
			 if (isset($l[2]) and trim($l[2])=="Y") echo " checked";
			echo ">\n";
			echo "</td><td>";
			echo  "<a class='bt bt-blue' href=javascript:EditarPft('".$l[0]."')>".$msgstr["edit"]."</a>";
			echo "</td>\n";
			echo "</tr>";
		}
	}

	echo "<tr><td colspan=2 align=center> ";
	?>
	<button type="submit" class="bt-green m-2"><?php echo $msgstr["save"]; ?></button>
</form>
	
</table>

</div>
	
	<div class="w-20">

	<?php
	if ($cuenta>0){
		echo "<strong>".$base."/".$lang."/formatos.dat</strong><br>";
	?>

	<table class="table striped">
		<tr>
			<th>Pft</th>
			<th><?php echo $msgstr["nombre"];?></th>
		</tr>
		<?php
		foreach ($fp_campos as $value) {
			$value=trim($value);
			if ($value!=""){
				$v=explode('|',$value);
				echo "<tr><td>".$v[0]."</td><td>".$v[1]."</td></tr>\n";
			}
		}
	}
	?>
	</table>
		
	
	
	<?php } ?>

</div>
</div>
</div>
</div>
</div>

<?php include ("../../common/footer.php"); ?>

<script>
function EditarPft(Pft){
	params ="scrollbars=auto,resizable=yes,status=no,location=no,toolbar=no,menubar=no,width=800,height=600,left=0,top=0"
	msgwin=window.open("editar_pft.php?Pft="+Pft+"&base=<?php echo $_REQUEST["base"]."&lang=".$_REQUEST["lang"]."&db_path=".$_REQUEST["db_path"];?>",'pft',params)
	msgwin.focus()
}
</script>

