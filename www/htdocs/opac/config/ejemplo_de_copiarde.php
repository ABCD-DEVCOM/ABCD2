if (isset($_REQUEST["Opcion"]) and $_REQUEST["Opcion"]=="copiarde"){
	$archivo=$db_path."opac_conf/".$_REQUEST["lang_copiar"]."/".$_REQUEST["archivo"];
	copy($archivo,$db_path."opac_conf/".$_REQUEST["lang"]."/".$_REQUEST["archivo"]);
	echo "<p><font color=red>". "opac_conf/$lang/".$_REQUEST["archivo"]." ".$msgstr["copiado"]."</font>";
}

function CopiarDe($iD,$name,$lang,$file){
global $db_path;
	echo "<br>copiar de: ";
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
	echo "</select><br>";
}

<form name=copiarde method=post>
<input type=hidden name=db>
<input type=hidden name=archivo>
<input type=hidden name=Opcion value=copiarde>
<input type=hidden name=lang_copiar>
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
