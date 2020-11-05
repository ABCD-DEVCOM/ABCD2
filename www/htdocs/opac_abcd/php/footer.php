				<!-- end #content -->

	<div style="clear: both;">&nbsp;</div>
	</div>
<a name=final>
</div>

<!--ESTO SE CAMBIO PARA PODER INSERTAR EL NUEVO FOOTER -->
<?php
if (file_exists($db_path."opac_conf/".$_REQUEST["lang"]."/footer.info")){	$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/footer.info");
	foreach ($fp as $value){		$value=trim($value);
		if ($value!=""){
			if (substr($value,0,6)=="[LINK]") {
				$home_link=substr($value,6);
				$hl=explode('|||',$home_link);
				$home_link=$hl[0];
				if (isset($hl[1]))
					$height_link=$hl[1];
				else
					$height_link=800;
				$footer="LINK";
			}
			if (substr($value,0,6)=="[TEXT]") {				$home_text=substr($value,6);
				$footer="TEXT";			}

		}	}
	switch($footer){		case "LINK":?>
			<div>
			<iframe src="<?php echo $home_link?>" frameborder="0" scrolling="no"  width=100% height="<?php echo $height_link?>" />
			</iframe>
			</div>
<?php		break;
		case "TEXT":
			$fp=file($db_path."opac_conf/".$_REQUEST["lang"]."/$home_text");
			foreach ($fp as $v) echo $v;
			break;
	}
}else{	echo "<div id=\"footer\">\n";
	echo $footer;
	echo "</div>\n";}
?>
<!-- end #footer -->
</body>
</html>
<?php
if (!isset($_REQUEST["modo"])) $_REQUEST["modo"]="";
if (basename($_SERVER["SCRIPT_FILENAME"])=="index.php")
	$dir="php/";

else
	$dir="";

?>

<form name="buscar" action="buscar_integrada.php" method="post">
<input type=hidden name=cookie>
<input type=hidden name=LastKey>
<input type=hidden name=resaltar>
<input type=hidden name=pagina>
<input type=hidden name=sendto>
<input type=hidden name=Accion>
<?php
echo "<input type=hidden name=facetas value=\"";
if (isset($_REQUEST["facetas"]))  	 echo $_REQUEST["facetas"];
echo "\">\n";
if (isset($_REQUEST["db_path"]))     echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
if (isset($_REQUEST["alcance"]))     echo "<input type=hidden name=alcance value=".$_REQUEST["alcance"].">\n";
if (isset($_REQUEST["integrada"]))   echo "<input type=hidden name=integrada value=\"".$_REQUEST["integrada"]."\">";
if (isset($_REQUEST["modo"]))        echo "<input type=hidden name=modo value=\"".$_REQUEST["modo"]."\">";
echo "<input type=hidden name=indice_base value=\"";
if (isset($_REQUEST["indice_base"])) echo $_REQUEST["indice_base"];
echo "\">\n";
if (isset($_REQUEST["lista_bases"])) echo "<input type=hidden name=lista_bases value=\"".$_REQUEST["lista_bases"]."\">\n";
if (isset($_REQUEST["diccionario"])) echo "<input type=hidden name=diccionario value=DICCIONARIO>\n";
if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"".$_REQUEST["Formato"]."\">\n";
?>
<input type=hidden name=base value="<?php if (isset($_REQUEST["base"])) echo $_REQUEST["base"]?>">
<input type=hidden name=Opcion value="<?php if (isset($_REQUEST["Opcion"])) echo $_REQUEST["Opcion"]?>">
<input type=hidden name=Expresion value="<?php if (isset($_REQUEST["Expresion"])) echo urlencode($_REQUEST["Expresion"])?>">
<?php
echo  "<input type=hidden name=desde value=\"";
if (isset($proximo)) echo $proximo;
echo "\">\n";
echo  "<input type=hidden name=count value=\"";
if (isset($count)) echo $count;
echo "\">\n";
if (isset($_REQUEST["resaltar"])) echo "<input type=hidden name=resaltar value=\"". $_REQUEST["resaltar"]."\">\n";
if (isset($_REQUEST["Incluir"])) echo "<input type=hidden name=Incluir value=".$_REQUEST["Incluir"].">\n";
if (isset($_REQUEST["titulo"])) echo "<input type=hidden name=titulo value=".$_REQUEST["titulo"].">\n";
if (isset($_REQUEST["Diccio"])) echo "<input type=hidden name=Diccio value=".$_REQUEST["Diccio"].">\n";
echo "<input type=hidden name=prefijo value=";if (isset($_REQUEST["prefijo"])) echo $_REQUEST["prefijo"]; echo ">\n";
if (isset($_REQUEST["prefijoindice"])) echo "<input type=hidden name=prefijoindice value=".$_REQUEST["prefijoindice"].">\n";
if (isset($_REQUEST["iden"])) echo "<input type=hidden name=iden value=".$_REQUEST["iden"].">\n";
if (isset($_REQUEST["Campos"])) echo "<input type=hidden name=Campos value=\"".$_REQUEST["Campos"]."\">\n";
if (isset($_REQUEST["Operadores"])) echo "<input type=hidden name=Operadores value=\"".$_REQUEST["Operadores"]."\">\n";
echo "<input type=hidden name=Sub_Expresion value=\"";
if (isset($_REQUEST["Sub_Expresion"])) echo urlencode($_REQUEST["Sub_Expresion"]);
echo "\">\n";
echo "<input type=hidden name=coleccion value=\"";
if (isset($_REQUEST["coleccion"])) echo $_REQUEST["coleccion"];
echo "\">\n";
if (isset($_REQUEST["prefijoindice"])){
	echo "<input type=hidden name=letra value=\"";
	if (isset($_REQUEST["letra"])) {
		echo $_REQUEST["letra"];
	}
	echo "\">\n";
	echo "<input type=hidden name=columnas value=".$_REQUEST["columnas"].">\n";
	echo "<input type=hidden name=posting value=".$_REQUEST["posting"].">\n";
if (isset($_REQUEST["cipar"]))
	echo "<input type=hidden name=cipar value=\"".$_REQUEST["cipar"]."\">\n";
}

if (isset($_REQUEST["Pft"]))
	echo "<input type=hidden name=Pft value=\"".$_REQUEST["Pft"]."\">\n";
if (isset($_REQUEST["lang"]))
	echo "<input type=hidden name=lang value=\"".$_REQUEST["lang"]."\">\n";
?>
</form>
<?php
if (isset($_REQUEST["prefijo"])){
	echo "<form name=indice action=alfabetico.php method=post>\n";
	foreach ($_REQUEST as $var=>$value){
		if ($var!="letra" and $var!="count")
			echo "<input type=hidden name=$var value=\"$value\">\n";
	}
    echo "<input type=hidden name=count value=25>";
	echo "<input type=hidden name=letra value=\"";
	if (isset($_REQUEST["Expresion"]) and isset($_REQUEST["letra"])) {
		echo str_replace($_REQUEST["prefijo"],"",$_REQUEST["letra"]);
	}
	echo "\">\n";
	if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]=="integrado"){	}else{		if (isset($_REQUEST["base"]))     echo "<input type=hidden name= value=base".$_REQUEST["base"].">\n";	}

	if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST["coleccion"]."\">\n";
	if (isset($_REQUEST["alcance"])) echo "<input type=hidden name=alcance value=".$_REQUEST["alcance"].">\n";
	if (isset($_REQUEST["integrada"]))  echo "<input type=hidden name=integrada value=\"".$_REQUEST["integrada"]."\">";
	if (isset($_REQUEST["indice_base"])) echo "<input type=hidden name=indice_base value=\"".$_REQUEST["indice_base"]."\">\n";
	echo "<input type=hidden name=Formato value=\"";
	if (isset($_REQUEST["Formato"])) echo $_REQUEST["Formato"];
	echo "\">\n";
	echo "</form>\n";
}
?>
<form name=activarindice method=post action=alfabetico.php>
<input type="hidden" name="titulo">
<input type="hidden" name="columnas">
<input type="hidden" name="Opcion">
<input type="hidden" name="count">
<input type="hidden" name="posting">
<input type="hidden" name="prefijoindice">
<input type="hidden" name="base">
<?php
if (isset($_REQUEST["facetas"]))  	 echo "<input type=hidden name=facetas value=\"".$_REQUEST["facetas"]."\">\n";
echo "<input type=hidden name=prefijo value=\"";
if (isset($_REQUEST["prefijo"])) echo $_REQUEST["prefijo"];
echo "\">\n";
if (isset($_REQUEST["db_path"]))     echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
echo "<input type=hidden name=cipar value=";
if (isset($_REQUEST["cipar"])) echo $_REQUEST["cipar"];
echo ">\n";
if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST["coleccion"]."\">\n";
if (isset($_REQUEST["modo"]))
	echo "<input type=hidden name=modo value=\"".$_REQUEST["modo"]."\">\n";
if (isset($_REQUEST["Pft"]))
	echo "<input type=hidden name=Pft value=\"".$_REQUEST["Pft"]."\">\n";
if (isset($_REQUEST["integrada"]))  echo "<input type=hidden name=integrada value=\"".$_REQUEST["integrada"]."\">";
if (isset($_REQUEST["indice_base"])) echo "<input type=hidden name=indice_base value=\"".$_REQUEST["indice_base"]."\">\n";
if (isset($_REQUEST["alcance"])) echo "<input type=hidden name=alcance value=".$_REQUEST["alcance"].">\n";
echo "<input type=hidden name=Formato value=\"";
if (isset($_REQUEST["Formato"])) echo $_REQUEST["Formato"];
echo "\">\n";
echo "<input type=hidden name=lang value=\"";
if (isset($_REQUEST["lang"])) echo $_REQUEST["lang"];
echo "\">\n";
?>
</form>

<form name=diccio_libre action=diccionario_integrado.php method=post>
<input type=hidden name=lista_bases value="">
<input type=hidden name=prefijo value=TW_>
<input type=hidden name=Opcion value=libre>
<?php
if (isset($_REQUEST["facetas"]))  	 echo "<input type=hidden name=facetas value=\"".$_REQUEST["facetas"]."\">\n";
if (isset($_REQUEST["db_path"]))     echo "<input type=hidden name=db_path value=".$_REQUEST["db_path"].">\n";
echo "<input type=hidden name=alcance value=";
if (isset($_REQUEST["alcance"])) echo $_REQUEST["alcance"];
echo ">\n";
if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST["coleccion"]."\">\n";
echo "<input type=hidden name=cipar value=";
if (isset($_REQUEST["cipar"])) echo $_REQUEST["cipar"];
echo ">\n";
echo "<input type=hidden name=base value=";
if (isset($_REQUEST["base"])) echo $_REQUEST["base"];
echo ">\n";
if (isset($_REQUEST["modo"])) echo "<input type=hidden name=modo value=\"";
 echo $_REQUEST["modo"];
echo "\">\n";
if (isset($_REQUEST["Pft"]))
	echo "<input type=hidden name=Pft value=\"".$_REQUEST["Pft"]."\">\n";
if (isset($_REQUEST["integrada"]))  echo "<input type=hidden name=integrada value=\"".$_REQUEST["integrada"]."\">";
if (isset($_REQUEST["indice_base"])) echo "<input type=hidden name=indice_base value=\"".$_REQUEST["indice_base"]."\">\n";
echo "<input type=hidden name=Formato value=\"";
if (isset($_REQUEST["Formato"])) echo $_REQUEST["Formato"];
echo "\">\n";
if (isset($_REQUEST["lang"]))
		echo "<input type=hidden name=lang value=\"".$_REQUEST["lang"]."\">\n";
?>
</form>
<form name=changelanguage method=post action=index.php>

<?php
foreach ($_REQUEST as $key=>$value){	echo "<input type=hidden name=$key value='$value'>\n";}
if (!isset($_REQUEST["lang"]))
	echo "<input type=hidden name=lang value=''>\n";

?>
</form>

<form name=inicio_menu method=post action=index.php>
<?php if (isset($_REQUEST["lang"]))
		echo "<input type=hidden name=lang value=\"".$_REQUEST["lang"]."\">\n";
	if (isset($_REQUEST["db_path"]))
		echo "<input type=hidden name=db_path value=\"".$_REQUEST["db_path"]."\">\n";
	if (isset($_REQUEST["modo"]))
		echo "<input type=hidden name=modo value=\"".$_REQUEST["modo"]."\">\n";
?>
</form>
