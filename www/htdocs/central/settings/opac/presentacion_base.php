<?php
include ("conf_opac_top.php");
$wiki_help="OPAC-ABCD_configuraci%C3%B3n_avanzada#P.C3.A1gina_de_inicio_de_la_base_de_datos";
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
	<h3><?php echo $msgstr["base_home"];?></h3>

<?php

/*
/*
if (!isset($_REQUEST["db_path"])){
	$_REQUEST["db_path"]=$db_path;
	$_REQUEST["db_path_desc"]="$db_path";
}
if (isset($_REQUEST["db_path"])) {
	$_SESSION["db_path"]=$_REQUEST["db_path"];
	$_SESSION["db_path_desc"]=$_REQUEST["db_path_desc"];
}
*/
if (isset($_REQUEST["lang"])) $_SESSION["lang"]=$_REQUEST["lang"];


//foreach ($_REQUEST AS $var=>$value) echo "$var=$value<br>"; //die;

/////////////////////////////////////////////////////////////////////

if (!isset($_SESSION["permiso"])){
	session_destroy();
	$msg=$msgstr["invalidright"]." ".$msgstr[$_REQUEST["startas"]];
	echo "
	<html>
	<body>
	<form name=err_msg action=error_page.php method=post>
	<input type=hidden name=error value=\"$msg\">
	";
	echo "
	</form>
	<script>
		document.err_msg.submit()
	</script>
	</body>
	</html>
	";
   	session_destroy();
   	die;
 }
$lang=$_REQUEST["lang"];
$Permiso=$_SESSION["permiso"];
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Guardar"){
	echo "<h3>".$msgstr["base_home"]."</h3>";


	$archivo=$db_path."opac_conf/$lang/".$_REQUEST["file"];
	$fout=fopen($archivo,"w");
	foreach ($_REQUEST as $var=>$value){
		$value=trim($value);
		if ($value!=""){
			$var=trim($var);
			$salida="";
			switch($var){
				case "home_link":
					$salida="[LINK]".$value;
					break;
				case "home_mfn":
					$salida="[MFN]".$value;
					break;
				case "home_text":
					$salida="[TEXT]".$value;
					if (!file_exists($db_path."opac_conf/$lang/$value")){
						echo "<font color=red size=2><strong>".$db_path."opac_conf/$lang/$value"." ".$msgstr["missing"]."</strong></font>"."<br>";
					}
					break;
			}
			if ($salida!="") fwrite($fout,$salida."\n");
		}
	}
	fclose($fout);
	?>
    <h2 class="color-green">opac_conf/<?php echo $lang;?>/<?php echo $_REQUEST["file"];?>  <?php echo $msgstr["updated"];?> </h2>
	<?php
}
?>

<div id="page"  class="w-10">


<?php

if (!isset($_REQUEST["Opcion"]) or $_REQUEST["Opcion"]!="Guardar"){

	$base="";
	if (!file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat")){
		echo "<font color=red>".$msgstr["missing"]."opac_conf/".$_REQUEST["lang"]."/bases.dat";
	}else{
		$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/bases.dat");
		foreach ($fp as $value){
			if (trim($value)!=""){
				$x=explode('|',$value);
				if ($_REQUEST["base"]!=$x[0]) continue;
				$nombre_base=$x[1];
				$base=$x[0];
				echo "<h2>".$_REQUEST["base"]." - ".$nombre_base."</h2><br>";
			}
		}
	}
	if ($base!=""){
		$file=$base."_home.info";
?>
	<form name="homeFrm" method="post" onSubmit="return checkform()">
		<input type="hidden" name="db_path" value="<?php echo $db_path;?>">
		<input type="hidden" name="Opcion" value="Guardar">
    	<input type="hidden" name="base" value="<?php echo $base;?>" >
    	<input type="hidden" name="file" value="<?php echo $file;?>" >
    	<input type="hidden" name="lang" value="<?php echo $lang;?>" >
<?php
    	if (isset($_REQUEST["conf_level"])){
			echo "<input type=hidden name=conf_level value=".$_REQUEST["conf_level"].">\n";
		}
       	$home_link="";
		$home_mfn="";
		$home_text="";
		if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/$file")){
			$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/$file");
			foreach ($fp as $value){
				$value=trim($value);
				if ($value!=""){
					if (substr($value,0,6)=="[LINK]") $home_link=substr($value,6);
					if (substr($value,0,5)=="[MFN]")  $home_mfn=substr($value,5);
					if (substr($value,0,6)=="[TEXT]") $home_text=substr($value,6);
				}
			}
		}
?>		
		<h3><strong><?php echo $msgstr["sel_one"];?></strong></h3>

		<div class="w-10" style="display: flex;" >
			<div class="w-4 p-3">
				<label class="w-3 p-2" ><?php echo $msgstr["base_home_link"];?><small>Ex: https://abcd-community.org</small></label>
				<input type="text" name="home_link" size="100" value="<?php echo $home_link;?>" > 
			</div>
		</div>

		<div class="w-10" style="display: flex;" >
			<div class="w-5 p-3">
				
				<input type="checkbox" name="home_mfn" value="Y" <?php if ($home_mfn!="" and $home_mfn=="Y") echo " checked";?> >
				<label class="w-3 p-2" ><?php echo $msgstr["base_home_records"];?></label>
			</div>
		</div>

		<div class="w-10" style="display: flex;" >
			<div class="w-4 p-3">
				<label class="w-3 p-2" ><?php echo $msgstr["base_home_text"];?></label>
				<input type="text" size="100" name="home_text" value="<?php echo $home_text;?>" >
			</div>
		</div>

		<div class="w-10" style="display: flex;" >
			<div class="w-4 p-3">
				<input class="bt bt-green" type="submit" value="<?php echo $msgstr["save"];?>">
			</div>
		</div>
		</form>
<?php		
	}
}
?>
</div>
</div>
</div>
</div>

<?php include ("../../common/footer.php"); ?>



<script>
function checkform(){
	cuenta=0;
	if (Trim(document.homeFrm.home_link.value)!="")
		cuenta=cuenta+1
	if (document.homeFrm.home_mfn.checked){
		cuenta=cuenta+1
	}

	if (Trim(document.homeFrm.home_text.value)!="")
		cuenta=cuenta+1
	if (cuenta>1){
		alert("<?php echo $msgstr["sel_one"]?>")
		return false
	}
	return true

}
</script>