<?php 
include("conf_opac_top.php"); 
include "../../common/inc_div-helper.php";
?>

<script>
var idPage="charset_cnf";
</script>

<div class="middle form row m-0">
	<div class="formContent col-2 m-2">
			<?php include("conf_opac_menu.php");?>
	</div>
	<div class="formContent col-9 m-2">

<?php
/*echo "<pre>";
foreach ($_REQUEST as $var=>$value) echo "$var=>$value \n";
echo "</pre>";
*/
if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="Actualizar"){
	foreach ($_REQUEST as $var=>$value){
		if (trim($value)!=""){
			$code=explode("_",$var);
			if ($code[0]=="conf"){
				switch ($code[1]){
					case "lc":
						if (!isset($cod_lang[$code[2]])){
							$cod_lang[$code[2]]=$value;
						}
						break;
					case "ln":
						if (!isset($collation[$code[2]])){
							$collation[$code[2]]=$value;
						}
						break;

				}
			}
		}
	}

	?>

    <div class="alert success" onload="setTimeout(function () { window.location.reload(); }, 10)" >
		<?php echo $msgstr["updated"];?>

	<pre><code>
<?php

    foreach ($cod_lang as $key=>$value){
		$fout=fopen($db_path."opac_conf/alpha/$charset/$value.tab","w");
		fwrite($fout, $collation[$key]);
		fclose($fout);
		echo "alpha/$charset/$value.tab ".$msgstr["updated"]."\n";
	}
	echo "</code></pre></div>";
	die;
}
?>



<form name="actualizar" method="post">
<?php
$ix=0;




if (is_dir($db_path."opac_conf/alpha/$charset")){
	$handle=opendir($db_path."opac_conf/alpha/$charset");
	while (false !== ($entry = readdir($handle))) {
		if (!is_file($db_path."opac_conf/alpha/$charset/$entry")) continue;
		$file = basename($entry, ".tab");
		$ix=$ix+1;

		$f_entry=$db_path."opac_conf/alpha/".$charset."/".$entry;
		$fp=file($f_entry);

		echo "<p>".$f_entry."</p>";
		

		echo "<table>";
		echo "<tr><th>".$msgstr["lang_name"]."</th><th>".$msgstr["lang_order"]."<br>".$msgstr["uno_por_linea"]."</th></tr>";
		echo "<tr><td valign=top><input type=text name=conf_lc_".$ix." size=25 value=\"$file\"></td>";


		echo "<td align=center><textarea cols=10 rows=23  name=conf_ln_".$ix." >";
		foreach ($fp as $value){
			if (trim($value)!=""){
			    echo $value;
			}
		}
		echo "</textarea></td></tr>\n";
		echo "<td colspan=2></td></tr>\n";
		echo "</table><hr>";
	}
}
if ($ix==0)
	$tope=5;
else
	$tope=$ix+4;
$ix=$ix+1;
for ($i=$ix;$i<$tope;$i++){
	echo "<table>";
	echo "<tr><th>".$msgstr["lang_name"]."</th><th>".$msgstr["lang_order"]."<br>".$msgstr["uno_por_linea"]."</th></tr>";
	echo "<tr><td valign=top><input type=text name=conf_lc_".$i." size=25 value=\"\"></td>";
	echo "<td align=center><textarea cols=10 rows=30  name=conf_ln_".$i." ></textarea></td>";
	echo "</tr>";
	echo "<td colspan=2></td></tr>\n";
	echo "</table><hr>";
}
?>

	<input type="hidden" name="lang" value="<?php echo $_REQUEST["lang"];?>">
	<input type="hidden" name="Opcion" value="Actualizar">
	
	<button type="submit" class="bt-green"><?php echo $msgstr["save"]; ?></button>
	</form>

</div>
</div>
</div>

<?php include ("../../common/footer.php"); ?>
