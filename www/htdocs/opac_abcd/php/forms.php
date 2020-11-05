<?php
if (basename($_SERVER["SCRIPT_FILENAME"])=="index.php")
	$dir="php/";

else
	$dir="";

?>

<form name=buscar action=buscar_integrada.php method=post>
<?php if (isset($_REQUEST["alcance"])) echo "<input type=hidden name=alcance value=".$_REQUEST["alcance"].">" ?>
<input type=hidden name=base value="<?php if (isset($base)) echo $base?>">
<input type=hidden name=LastKey>
<input type=hidden name=resaltar>
<?php
if (isset($_REQUEST["integrada"]))
	echo "<input type=hidden name=integrada value=\"".str_replace('"','&quot;',$_REQUEST["integrada"])."\">\n";
echo "<input type=hidden name=indice_base value=\"";
if (isset($_REQUEST["indice_base"]))echo $_REQUEST["indice_base"];
echo "\">\n";
if (isset($_REQUEST["lista_bases"]))
	echo "<input type=hidden name=lista_bases value=\"".$_REQUEST["lista_bases"]."\">\n";

if (isset($_REQUEST["diccionario"])) echo "<input type=hidden name=diccionario value=DICCIONARIO>\n";
?>
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
if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST["coleccion"]."\">\n";
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
if (isset($_REQUEST["modo"]))
	echo "<input type=hidden name=modo value=\"".$_REQUEST["modo"]."\">\n";


?>
<input type=hidden name=alcance>
<input type=hidden name=pagina>
<?php
if (isset($_REQUEST["cipar"])) echo "<input type=hidden name=cipar value=".$_REQUEST["cipar"].">\n";
if (isset($_REQUEST["modo"]))
	echo "<input type=hidden name=modo value=\"".$_REQUEST["modo"]."\">\n";
?>
</form>
<?php
if (isset($_REQUEST["prefijoindice"])){
	echo "<form name=indice action=alfabetico.php method=post>\n";
	foreach ($_REQUEST as $var=>$value){
		if ($var!="letra" and $var!="count")
			echo "<input type=hidden name=$var value=\"$value\">\n";
	}
    echo "<input type=hidden name=count value=25>";
	echo "<input type=hidden name=letra value=\"";
	if (isset($_REQUEST["letra"])) {
		echo $_REQUEST["letra"];
	}
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
<input type="hidden" name="prefijo">
<input type="hidden" name="prefijoindice">
<input type="hidden" name="base">
<?php
echo "<input type=hidden name=cipar value=";
if (isset($_REQUEST["cipar"])) echo $_REQUEST["cipar"];
echo ">\n";
if (isset($_REQUEST["coleccion"])) echo "<input type=hidden name=coleccion value=\"".$_REQUEST["coleccion"]."\">\n";
if (isset($_REQUEST["modo"]))
	echo "<input type=hidden name=modo value=\"".$_REQUEST["modo"]."\">\n";
?>
</form>

<form name=diccio_libre action=diccionario_integrado.php method=post>
<input type=hidden name=lista_bases value="">
<input type=hidden name=prefijo value=TW_>
<input type=hidden name=Opcion value=libre>
<input type=hidden name=alcance>
<input type=hidden name=coleccion>
<?php
echo "<input type=hidden name=cipar value=";
if (isset($_REQUEST["cipar"])) echo $_REQUEST["cipar"];
echo ">\n";
echo "<input type=hidden name=modo value=\"integrado\">\n";
?>
</form>
