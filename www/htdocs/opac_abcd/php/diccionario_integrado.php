<?php
$mostrar_libre="N";
$_REQUEST["submenu"]="N";
include("config_opac.php");
include("leer_bases.php");
include("tope.php");

include("Mobile_Detect.php");
$detect = new Mobile_Detect();
//foreach ($_REQUEST as $key=>$value) echo "$key=". urldecode($value)."<br>";

//die;
if (isset($_REQUEST["criterios"])){
	$retorno="D";
}else{
	if (isset($_REQUEST["lista_bases"])){
		if ($_REQUEST["Opcion"]=="libre")
			$retorno="../index.php";
		else
			$retorno="A";

	 }else{
	 	if ($_REQUEST["Opcion"]=="libre")
			$retorno="B";
		else
			$retorno="C";
  	}
}
?>
<script>
document.onkeypress =
  function (evt) {
    var c = document.layers ? evt.which
            : document.all ? event.keyCode
            : evt.keyCode;
	if (c==13)
		NavegarDiccionario(this,3)

    return true;
  };

</script>

<?php



// ------------------------------------------------------
// INICIO DEL PROGRAMA
// ------------------------------------------------------

?>


    <form name=diccionario method=post action=diccionario_integrado.php>
    <div style=margin-top:20px;><input type=button id=search-submit value=" <?php echo $msgstr["back"]?>"  onclick="document.regresar.submit();"></div>
    <p><font class=titulo3><?php echo $msgstr["diccio"]." "?>
<?php if (isset($_REQUEST["campo"])) echo urldecode($_REQUEST["campo"]);
	echo "</font><br>";
//}
if ($_REQUEST["Opcion"]=="libre"){?>           <font class=titulo2><?php echo $msgstr["unir_con"] ?><br>
           <input type=radio value=and name=alcance id=and <?php if ($_REQUEST["alcance"]=="and") echo "checked"?>><font color=darkred><?php echo $msgstr["and"]?></font><br>
           <input type=radio value=or name=alcance id=or <?php if ($_REQUEST["alcance"]=="or") echo "checked"?>><font color=darkred><?php echo $msgstr["or"]?></font>
			<br>

<?php }else{	echo "<input type=hidden name=alcance>\n";}

echo "<p>";
	if (isset($_REQUEST["Sub_Expresion"])){
		$SE=explode('~~~',$_REQUEST["Sub_Expresion"]);
		if (!isset($_REQUEST["Seleccionados"]))
			if (isset($_REQUEST["Diccio"]))$_REQUEST["Seleccionados"]=trim($SE[$_REQUEST["Diccio"]]);
	}
if ($detect->isMobile()) {
	echo "<p>".$msgstr["clic_sobre"]." <input type=checkbox> ".$msgstr["para_sel"]."<br>".$msgstr["clic_sobre"]." <img src=../images/buttonm.gif> ".$msgstr["remover_sel"];
 	include("presentar_diccionario_movil.php");
}else{	echo "<p>".$msgstr["dbl_clic"];
	include("presentar_diccionario_nomovil.php");
}
?>

<?php
$_REQUEST["resaltar"]="S";
if(isset($_REQUEST["lista_bases"]))
	echo "<input type=hidden name=lista_bases value=\"".$_REQUEST["lista_bases"]."\">\n";
if(isset($_REQUEST["base"]))
	echo "<input type=hidden name=base value=\"".$_REQUEST["base"]."\">\n";
if(isset($_REQUEST["indice_base"]))
	echo "<input type=hidden name=indice_base value=\"".$_REQUEST["indice_base"]."\">\n";
if(isset($_REQUEST["cipar"]))
	echo "<input type=hidden name=cipar value=\"".$_REQUEST["cipar"]."\">\n";
if(isset($_REQUEST["lista"]))
	echo "<input type=hidden name=lista value=\"".$_REQUEST["lista"]."\">\n";
if(isset($_REQUEST["Diccio"]))
	echo "<input type=hidden name=Diccio value=\"".$_REQUEST["Diccio"]."\">\n";
echo "<input type=hidden name=Sub_Expresion value='";
if (isset($_REQUEST["Sub_Expresion"])) echo urldecode($_REQUEST['Sub_Expresion']);
echo "\'>\n";
echo "<input type=hidden name=Sub_Expresiones value=\"";
if (isset($_REQUEST["Sub_Expresiones"])) echo urlencode($_REQUEST['Sub_Expresiones']);
echo "\">\n";
echo "<input type=hidden name=Navegacion value=\"";
if (isset($_REQUEST["Navegacion"])) echo $_REQUEST['Navegacion'];
echo "\">\n";
echo "<input type=hidden name=Expresion value=\"";
if (isset($_REQUEST["Expresion"]))
	echo urlencode($_REQUEST['Expresion']);
echo "\">\n";
if (isset($_REQUEST["Campos"]))
	echo "<input type=hidden name=Campos value=\"".$_REQUEST['Campos']."\">\n";
if (isset($_REQUEST["Operadores"]))
	echo "<input type=hidden name=Operadores value=\"".$_REQUEST['Operadores']."\">\n";
if (isset($_REQUEST["coleccion"]))
	echo "<input type=hidden name=coleccion value=".urlencode($_REQUEST['coleccion']).">\n";
if (isset($_REQUEST["criterios"]))
	echo "<input type=hidden name=criterios value=".urlencode($_REQUEST['criterios']).">\n";
if (isset($_REQUEST["modo"]))
	echo "<input type=hidden name=modo value=".urlencode($_REQUEST['modo']).">\n";
if (isset($_REQUEST["llamado_desde"]))
	echo "<input type=hidden name=llamado_desde value=\"".$_REQUEST['llamado_desde']."\">\n";
if (isset($_REQUEST["Formato"])) echo "<input type=hidden name=Formato value=\"".$_REQUEST["Formato"]."\">\n";
if (isset($_REQUEST["db_path"]))
	echo "<input type=hidden name=db_path value=".urlencode($_REQUEST['db_path']).">\n";
if (isset($_REQUEST["lang"]))
	echo "<input type=hidden name=lang value=".urlencode($_REQUEST['lang']).">\n";
?>
<input type=hidden name=resaltar value="<?php echo $_REQUEST["resaltar"]?>">
<input type=hidden name=prefijo value="<?php echo $_REQUEST["prefijo"]?>">
<input type=hidden name=Opcion value="<?php echo $_REQUEST["Opcion"]?>">
<input type=hidden name=Seleccionados>
</form>

<?php
echo "<form name=regresar method=post action=avanzada.php>\n";
foreach ($_REQUEST as $var=>$value){	echo "<input type=hidden name=$var value=";
	if (trim($value)!='""') echo urlencode($value);
	echo ">\n";}
echo "</form>";
 include("footer.php");
echo "\n<script>Opcion='";
if (isset($_REQUEST["Opcion"])) echo $_REQUEST["Opcion"];
echo "'\n</script>\n";
?>

