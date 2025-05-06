<?php
if (!isset($_REQUEST["modo"])) $_REQUEST["modo"] = "";

if (basename($_SERVER["SCRIPT_FILENAME"]) == "index.php"){
	$dir = "/";
} else {
	$dir = "";
}
?>

<form name="filtro" action="buscar_integrada.php" method="GET">
	<input type="hidden" name="page" value="startsearch" >
	<?php if (isset($_REQUEST["alcance"])) echo	'<input type="hidden" name="alcance" value="'.$_REQUEST["alcance"].'">';?>
<?php if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"" . $_REQUEST["Formato"] . "\">\n"; ?>
<?php if (isset($_REQUEST["pagina"])) echo "<input type=hidden name=pagina value=\"" . $_REQUEST["pagina"] . "\">\n"; ?>
<?php if (isset($_REQUEST["desde"])) echo "<input type=hidden name=desde value=\"" . $_REQUEST["desde"] . "\">\n"; ?>
<?php if (isset($_REQUEST["count"])) echo "<input type=hidden name=count value=\"" . $_REQUEST["count"] . "\">\n"; ?>

	<input type="hidden" name="integrada" value="<?php if (isset($_REQUEST["base"])) echo $_REQUEST["base"] ?>">
	<input type="hidden" name="modo" value="1B0" >

	<input type="hidden" name="base" value="<?php if (isset($_REQUEST["base"])) echo $_REQUEST["base"] ?>">

	<input type="hidden" name="Opcion" value="directa" >
	<input type="hidden" name="Expresion" value="<?php if (isset($_REQUEST["Expresion"])) echo urlencode($_REQUEST["Expresion"]) ?>" >
	<input type="hidden" name="count" value="<?php if (isset($count)) echo $count;?>" >
	<input type="hidden" name="coleccion" value="" >
	<input type="hidden" name="lang" value="<?php echo $lang;?>" >
</form>



<form name="buscar" action="buscar_integrada.php" method="POST">
	<input type="hidden" name="page" value="startsearch">

	<?php

		echo "<input type=hidden name=prefijo value=";
		if (isset($_REQUEST["prefijo"])) echo $_REQUEST["prefijo"];
		echo ">\n";


		echo "<input type=hidden name=Sub_Expresion value=\"";
		if (isset($_REQUEST["Sub_Expresion"])) echo urlencode($_REQUEST["Sub_Expresion"]);
		echo "\">\n";

		?>

	<input type="hidden" name="cookie">
	<input type="hidden" name="LastKey">
	<input type="hidden" name="resaltar">
	<input type="hidden" name="pagina">
	<input type="hidden" name="sendto">
	<input type="hidden" name="Accion">

	<?php if (isset($_REQUEST["db_path"])) echo	'<input type="hidden" name="db_path" value="'.$_REQUEST["db_path"].'">';?>
	<?php if (isset($_REQUEST["alcance"])) echo	'<input type="hidden" name="alcance" value="'.$_REQUEST["alcance"].'">';?>
	<?php if (isset($_REQUEST["integrada"])) echo '<input type="hidden" name="integrada" value="'.$_REQUEST["integrada"].'">';?>
	<?php if (isset($_REQUEST["modo"])) echo '<input type="hidden" name="modo" value="'.$_REQUEST["modo"].'">';?>
	<input type="hidden" name="indice_base" value="<?php if (isset($_REQUEST["indice_base"])) echo $_REQUEST["indice_base"];?>" >
	<?php
	if (isset($_REQUEST["lista_bases"])) echo "<input type=hidden name=lista_bases value=\"" . $_REQUEST["lista_bases"] . "\">\n";
	if (isset($_REQUEST["diccionario"])) echo "<input type=hidden name=diccionario value=DICCIONARIO>\n";
	if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"" . $_REQUEST["Formato"] . "\">\n";
	?> 
	<input type="hidden" name="base" value="<?php if (isset($_REQUEST["base"])) echo $_REQUEST["base"] ?>">
	<input type="hidden" name="Opcion" value="<?php if (isset($_REQUEST["Opcion"])) echo $_REQUEST["Opcion"] ?>">
	<input type="hidden" name="Expresion" value="<?php if (isset($_REQUEST["Expresion"])) echo urlencode($_REQUEST["Expresion"]) ?>">
	<?php
	echo  "<input type=hidden name=desde value=\"";
	if (isset($proximo)) echo $proximo;
	echo "\">\n";
	echo  "<input type=hidden name=count value=\"";
	if (isset($count)) echo $count;
	echo "\">\n";
	if (isset($_REQUEST["resaltar"])) echo "<input type=hidden name=resaltar value=\"" . $_REQUEST["resaltar"] . "\">\n";
	if (isset($_REQUEST["Incluir"])) echo "<input type=hidden name=Incluir value=" . $_REQUEST["Incluir"] . ">\n";
	if (isset($_REQUEST["titulo"])) echo "<input type=hidden name=titulo value=" . $_REQUEST["titulo"] . ">\n";
	if (isset($_REQUEST["Diccio"])) echo "<input type=hidden name=Diccio value=" . $_REQUEST["Diccio"] . ">\n";



	if (isset($_REQUEST["prefijoindice"])) echo "<input type=hidden name=prefijoindice value=" . $_REQUEST["prefijoindice"] . ">\n";
	if (isset($_REQUEST["iden"])) echo "<input type=hidden name=iden value=" . $_REQUEST["iden"] . ">\n";
	if (isset($_REQUEST["Campos"])) echo "<input type=hidden name=Campos value=\"" . $_REQUEST["Campos"] . "\">\n";
	if (isset($_REQUEST["Operadores"])) echo "<input type=hidden name=Operadores value=\"" . $_REQUEST["Operadores"] . "\">\n";
	



	echo "<input type=hidden name=coleccion value=\"";
	if (isset($_REQUEST["coleccion"])) echo $_REQUEST["coleccion"];
	echo "\">\n";
	if (isset($_REQUEST["prefijoindice"])) {
		echo "<input type=hidden name=letra value=\"";
		if (isset($_REQUEST["letra"])) {
			echo $_REQUEST["letra"];
		}
		echo "\">\n";
		echo "<input type=hidden name=columnas value=" . $_REQUEST["columnas"] . ">\n";
		echo "<input type=hidden name=posting value=" . $_REQUEST["posting"] . ">\n";
		if (isset($_REQUEST["cipar"]))
			echo "<input type=hidden name=cipar value=\"" . $_REQUEST["cipar"] . "\">\n";
	}

	if (isset($_REQUEST["Pft"]))
		echo "<input type=hidden name=Pft value=\"" . $_REQUEST["Pft"] . "\">\n";
	if (isset($lang))
		echo "<input type=hidden name=lang value=\"" . $lang . "\">\n";
	?>
</form>

<?php
if (isset($_REQUEST["prefijo"])) {
	echo "<form name=indice action=views/alfabetico.php method=post>\n";
	foreach ($_REQUEST as $var => $value) {
		if ($var != "letra" and $var != "count")
			echo "<input type=hidden name=$var value=\"$value\">\n";
	}
	echo "<input type=hidden name=count value=25>";
	echo "<input type=hidden name=letra value=\"";
	if (isset($_REQUEST["Expresion"]) and isset($_REQUEST["letra"])) {
		echo str_replace($_REQUEST["prefijo"], "", $_REQUEST["letra"]);
	}
	echo "\">\n";
	if (isset($_REQUEST["modo"]) and $_REQUEST["modo"] == "integrado") {
	} else {
		if (isset($_REQUEST["base"])) echo "<input type=hidden name= value=base" . $_REQUEST["base"] . ">\n";
	}

	if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"" . $_REQUEST["coleccion"] . "\">\n";
	if (isset($_REQUEST["alcance"])) echo "<input type=hidden name=alcance value=" . $_REQUEST["alcance"] . ">\n";
	if (isset($_REQUEST["integrada"]))  echo "<input type=hidden name=integrada value=\"" . $_REQUEST["integrada"] . "\">";
	if (isset($_REQUEST["indice_base"])) echo "<input type=hidden name=indice_base value=\"" . $_REQUEST["indice_base"] . "\">\n";
	echo "<input type=hidden name=Formato value=\"";
	if (isset($_REQUEST["Formato"])) echo $_REQUEST["Formato"];
	echo "\">\n";
	echo "</form>\n";
}

?>

<!--<form name="activarindice" method="post" action="<?php if (isset($scptpath)) echo $scptpath;?>views/alfabetico.php">-->
<form name="activarindice" method="post">
	<input type="hidden" name="indice" value="yes">
	<input type="hidden" name="titulo">
	<input type="hidden" name="columnas">
	<input type="hidden" name="Opcion">
	<input type="hidden" name="count">
	<input type="hidden" name="posting">
	<input type="hidden" name="prefijoindice">
	<input type="hidden" name="base">
	<?php
	if (isset($_REQUEST["facetas"])) echo "<input type=hidden name=facetas value=\"" . $_REQUEST["facetas"] . "\">\n";
	echo "<input type=hidden name=prefijo value=\"";
	if (isset($_REQUEST["prefijo"])) echo $_REQUEST["prefijo"];
	echo "\">\n";
	if (isset($_REQUEST["db_path"])) echo "<input type=hidden name=db_path value=" . $_REQUEST["db_path"] . ">\n";
	echo "<input type=hidden name=cipar value=";
	if (isset($_REQUEST["cipar"])) echo $_REQUEST["cipar"];
	echo ">\n";
	if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"" . $_REQUEST["coleccion"] . "\">\n";
	if (isset($_REQUEST["modo"]))
		echo "<input type=hidden name=modo value=\"" . $_REQUEST["modo"] . "\">\n";
	if (isset($_REQUEST["Pft"]))
		echo "<input type=hidden name=Pft value=\"" . $_REQUEST["Pft"] . "\">\n";
	if (isset($_REQUEST["integrada"]))  echo "<input type=hidden name=integrada value=\"" . $_REQUEST["integrada"] . "\">";
	if (isset($_REQUEST["indice_base"])) echo "<input type=hidden name=indice_base value=\"" . $_REQUEST["indice_base"] . "\">\n";
	if (isset($_REQUEST["alcance"])) echo "<input type=hidden name=alcance value=" . $_REQUEST["alcance"] . ">\n";
	echo "<input type=hidden name=Formato value=\"";
	if (isset($_REQUEST["Formato"])) echo $_REQUEST["Formato"];
	echo "\">\n";
	echo "<input type=hidden name=lang value=\"";
	if (isset($lang)) echo $lang;
	echo "\">\n";
	?>
</form>


<!-- Acionado pela função DiccionarioLibre() em scripts_b.js -->
<form name="diccio_free" action="diccionario_integrado.php" method="post">
	<input type="hidden" name="lista_bases" value="">
	<input type="hidden" name="prefijo" value="TW_">
	<input type="hidden" name="Opcion" value="free">
	<?php
	if (isset($_REQUEST["facetas"])) echo '<input type="hidden" name="facetas" value="'.$_REQUEST["facetas"].'">';
	if (isset($_REQUEST["db_path"])) echo '<input type="hidden" name="db_path" value="'.$_REQUEST["db_path"].'">\n';

	echo '<input type="hidden" name="alcance" value="';
	if (isset($_REQUEST["alcance"])) echo $_REQUEST["alcance"];
	echo "\">\n";
	if (isset($_REQUEST["coleccion"])) echo '<input type="hidden" name="coleccion" value="' . $_REQUEST["coleccion"] . '" >' . "\n";
	echo "<input type=hidden name=cipar value=";
	if (isset($_REQUEST["cipar"])) echo $_REQUEST["cipar"];
	echo ">\n";
	echo "<input type=hidden name=base value=";
	if (isset($_REQUEST["base"])) echo $_REQUEST["base"];
	echo ">\n";
	if (isset($_REQUEST["modo"])) echo "<input type=hidden name=modo value=\"";
	echo $_REQUEST["modo"];
	echo "\">\n";
	if (isset($_REQUEST["Pft"]))	echo "<input type=hidden name=Pft value=\"" . $_REQUEST["Pft"] . "\">\n";
	if (isset($_REQUEST["integrada"]))  echo "<input type=hidden name=integrada value=\"" . $_REQUEST["integrada"] . "\">";
	if (isset($_REQUEST["indice_base"])) echo "<input type=hidden name=indice_base value=\"" . $_REQUEST["indice_base"] . "\">\n";
	echo "<input type=hidden name=Formato value=\"";
	if (isset($_REQUEST["Formato"])) echo $_REQUEST["Formato"];
	echo "\">\n";
	if (isset($lang)) echo "<input type=hidden name=lang value=\"" . $lang . "\">\n";
	?>
</form>

<form name="changelanguage" method="POST">
	<?php
	foreach ($_REQUEST as $key => $value) {
		echo '<input type=hidden name="'.$key.'" value="'.$value.'">';
	}
	if (!isset($lang))
		echo "<input type='hidden' name='lang'>\n";
	?>
</form>

<form name="inicio_menu" method="post" action="<?php echo $link_logo ?>?lang=<?php echo $lang; ?>">
	<?php if (isset($lang))
		echo "<input type=hidden name=lang value=\"" . $lang . "\">\n";
	if (isset($_REQUEST["db_path"]))
		echo "<input type=hidden name=db_path value=\"" . $_REQUEST["db_path"] . "\">\n";
	if (isset($_REQUEST["modo"]))
		echo "<input type=hidden name=modo value=\"" . $_REQUEST["modo"] . "\">\n";
	?>
</form>

<form name="bi" action="buscar_integrada.php" method="post">
	<input type="hidden" name="page" value="startsearch">
	<input type="hidden" name="base">
	<input type="hidden" name="cipar">
	<input type="hidden" name="Opcion">
	<input type="hidden" name="coleccion">
	<input type="hidden" name="Expresion">
	<input type="hidden" name="titulo_c">
	<input type="hidden" name="resaltar">
	<input type="hidden" name="submenu">
	<input type="hidden" name="Pft">
	<input type="hidden" name="mostrar_exp">
	<input type="hidden" name="home">
	<?php
	echo "<input type=hidden name=modo value=\"";
	if (isset($_REQUEST["modo"])) echo $_REQUEST["modo"];
	echo "\">\n";
	if (isset($_REQUEST["integrada"]))
		echo "<input type=hidden name=integrada value=\"".str_replace('"','&quot;',$_REQUEST["integrada"])."\">\n";
	if (isset($_REQUEST["db_path"]))
		echo "<input type=hidden name=db_path value=\"".str_replace('"','&quot;',$_REQUEST["db_path"])."\">\n";
	if (isset($lang))
		echo "<input type=hidden name=lang value=\"".str_replace('"','&quot;',$lang)."\">\n";
	?>
</form>



	<form name="regresar" action="buscar_integrada.php" method="POST">
		<input type="hidden" name="page" value="startsearch">
		<?php 
		foreach ($_REQUEST as $key=>$value){
			echo "<input type='hidden' name='".$key."' value='".$value."'>\r\n";
		} ?>
	</form>


<form name="indiceAlfa" method="POST" action="alfabetico.php">
	<input type="hidden" name="page" value="startsearch">
	<input type="hidden" name="alfa" value="<?php if (isset($_REQUEST["alfa"]) and $_REQUEST["alfa"]!="") echo $_REQUEST["alfa"];?>">
	<input type="hidden" name="titulo" value="<?php if (isset($_REQUEST["titulo"])) echo $_REQUEST["titulo"];?>">
	<input type="hidden" name="columnas" value="<?php if (isset($_REQUEST["columnas"])) echo $_REQUEST["columnas"];?>">
	<input type="hidden" name="Opcion" value="<?php  if (isset($_REQUEST["Opcion"])) echo $_REQUEST["Opcion"];?>">
	<input type="hidden" name="count" value="25">
	<input type="hidden" name="posting" value="<?php if (isset($_REQUEST["posting"])) echo $_REQUEST["posting"];?>">
	<input type="hidden" name="prefijo" value="<?php if (isset($_REQUEST["prefijo"])) echo $_REQUEST["prefijo"];?>">
	<input type="hidden" name="prefijoindice" value="<?php if (isset($_REQUEST["prefijo"])) echo $_REQUEST["prefijo"]?>">
	<input type="hidden" name="ira" value="<?php if (isset($_REQUEST["ira"])) echo $_REQUEST["ira"]?>">
	<input type="hidden" name="Expresion">
	<input type="hidden" name="Sub_Expresion">
	<?php if (isset($primero)) { $letra=$primero; } else { $letra=""; } ?>
	<input type="hidden" name="letra" value="<?php if (isset($_REQUEST["prefijo"])) echo str_replace($_REQUEST["prefijo"],'',$letra) ?>">
	<input type="hidden" name="Existencias">
	<input type="hidden" name="Campos">
	<input type="hidden" name="coleccion" value="<?php if (isset($_REQUEST["coleccion"])) echo $_REQUEST["coleccion"]?>">
	<input type="hidden" name="lang" value="<?php if (isset($_REQUEST["lang"])) echo $_REQUEST["lang"]?>">
	<?php
	if (isset($_REQUEST["base"]))  	echo "<input type=hidden name=base value=".$_REQUEST["base"].">\n";
	if (isset($_REQUEST["indice_base"]))  echo "<input type=hidden name=indice_base value=".$_REQUEST["indice_base"].">\n";
	if (isset($_REQUEST["cipar"])) echo "<input type=hidden name=cipar value=".$_REQUEST["cipar"].">\n";
	if (isset($_REQUEST["modo"])) echo "<input type=hidden name=modo value=".$_REQUEST["modo"].">\n";
	if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"".$_REQUEST["Formato"]."\">\n";
	if (isset($_REQUEST["db_path"])) echo "<input type=hidden name=db_path value=\"".$_REQUEST["db_path"]."\">\n";
	if (isset($_REQUEST["lang"])) echo "<input type=hidden name=lang value=\"".$_REQUEST["lang"]."\">\n";
	?>
</form>

<script nonce="<?php echo $nonce; ?>" src="<?php echo $OpacHttp;?>assets/js/bootstrap.bundle.min.js"></script>

