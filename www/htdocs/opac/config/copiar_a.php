<?php
include ("tope_config.php");
//foreach ($_REQUEST as $var=>$value) echo "$var=>$value<br>";
if (isset($_REQUEST["actualizar"]) and $_REQUEST["actualizar"]=="Actualizar"){
	ActualizarArchivos();
}
if (!isset($_REQUEST["actualizar"])){
	echo "<h4>";
	echo $msgstr["copiar_de"]." &nbsp; <font color=red>". $_REQUEST["lang_from"]."</font>";
	echo "<br>";
	echo $msgstr["copiarconf_a"]." &nbsp;  <font color=red>". $_REQUEST["lang_to"]."</font>";
	echo "<br>";
	echo $msgstr["sustituir_archivos"]." &nbsp;  <font color=red>". $_REQUEST["replace_a"]."</font>";
	echo "</h4>";
	if (!is_dir($db_path."opac_conf/".$_REQUEST["lang_to"])){		echo  "<h4><font color=red>",$msgstr["missing_folder"]. " &nbsp;opac_conf/".$_REQUEST["lang_to"]."</font></h4>";
    	die;	}
?>
<form name=copiar method=post>
<?php
foreach ($_REQUEST as $var=>$value){	echo "<input type=hidden name=$var value=$value>\n";}
echo "<input type=hidden name=actualizar value=Actualizar>\n";
echo "<input type=submit name=copiar value=".$msgstr["copiar"].">\n";
echo "</form>\n";
}
include ("../php/footer.php");
?>
</div>
</div>
</body
</html>
<?php
function ActualizarArchivos(){global $db_path,$msgstr;
	if ($handle = opendir($db_path."/opac_conf/".$_REQUEST["lang_from"])) {
		while (false !== ($entry = readdir($handle))) {			if ($entry!="." and $entry!=".."){				$from[$entry]=$entry;
        	}
    	}
    	closedir($handle);
	}
	if ($handle = opendir($db_path."/opac_conf/".$_REQUEST["lang_to"])) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry!="." and $entry!=".."){
				if (isset($from[$entry]) and $_REQUEST["replace_a"]=="N") unset($from[$entry]);
        	}
    	}
    	closedir($handle);
	}
	foreach ($from as $key=>$value){		copy($db_path.'opac_conf/'.$_REQUEST["lang_from"]."/$key", $db_path.'opac_conf/'.$_REQUEST["lang_to"]."/$key");
		echo $key." ".$msgstr["copiado"]."<br>";	}
   if (count($from)==0){
   		echo "<h4><font color=red>".$msgstr["no_files"]."</font></h4>";   }
}
?>