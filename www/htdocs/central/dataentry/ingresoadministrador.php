<?php
/*
20220207 fho4abcd improve html, remove old style buttons for default settings
*/
include("scripts_dataentry.php");
include("toolbar_record.php");
echo "<table border=0 width=100% bgcolor=white><tr><td width=1% bgcolor=white> </td><td width=99% bgcolor=white>" ;
if (isset($arrHttp["error"])) echo $arrHttp["error"];
$xnr="";
$xtl="";
$Rtl="";
$Rnr="";
if (isset($default_values)){
	echo "<span class=title><h2>".$msgstr["valdef"]."</h2></span>";

}else{
	if (isset($arrHttp["Formato"])) echo "<input type=hidden name=Formato value='".$arrHttp["Formato"]."'>\n";
}
if ($arrHttp["Opcion"]!="valdef"){
	if (!isset($fmt_test)){
		echo "<B>".$arrHttp["Mfn"];
		if ($arrHttp["Mfn"]!="New") {
	    	echo "/$maxmfn</B>";
	    }
	 }
}
	$xtt="";

if (isset($arrHttp["wks_a"])){
	$w=explode('|',$arrHttp["wks_a"]);
	echo "&nbsp; &nbsp; ".$msgstr["fmt"].":  (".$w[0].")";
}else{
	if (isset($arrHttp["wks"])){
		echo "&nbsp; &nbsp; ".$msgstr["fmt"].": ".$arrHttp['wks'];
	}
}
echo "&nbsp; <a href=JavaScript:OpenAll()>".$msgstr["expand_colapse"]."</a>";
// Se construye el Indice de acceso a la hoja de entrada
$ixIndice="S";
if ($ixIndice=="S"){
	$cuenta=0;
	$i=-1;
	for ($ix1=0;$ix1<count($vars);$ix1++){
		$linea=$vars[$ix1];
		$t=explode('|',$linea);
	}
    if ($i!=-1){
    	echo "</td></table>";
    	echo "</div><br>";
    }
}
	echo "<input type=hidden name=tag$Rtl value='".$xtl."'>";
	echo "<input type=hidden name=tag$Rnr value='".$xnr."'>";


// Se inicializa el arreglo con los tags a leer de la base de datos
PrepararFormato();
echo "<script>
is_marc='$is_marc'
</script>
";
if (!isset($fmt_test) and !isset($default_values)) {  //Para indicar que se esta haciendo el test de la hoja de entrada o creando valores por defecto

	$db=$arrHttp["base"];
	if (!$ver or isset($arrHttp["capturar"])){
		?>
		</div>
		<div style="margin-top: 30px;">
		<table border=0 cellspacing=5 cellpadding=10 bgcolor=white>
			<tr>
		<?php
		if (isset($arrHttp["capturar"]) and $arrHttp["capturar"]=="S"){
            echo "<td align=center bgcolor=white ><a href=\"javascript:CapturarRegistro()\"><img src=img/capturar.gif border=0 alt=\"".$msgstr["m_capturar"]."\"></a></td>\n";
		}else{

			if (!isset($arrHttp["encabezado"])){
				echo "<td align=center bgcolor=white><a class='bt-lg bt-green' href=\"javascript:EnviarForma()\"><img src=\"../../assets/svg/catalog/ic_fluent_document_save_24_regular.svg\" border=0 alt=\"".$msgstr["actualizar"]."\">".$msgstr["actualizar"]."</a></td>\n";
    			echo "<td align=center bgcolor=white><a class='bt-lg bt-gray' href=javascript:CancelarActualizacion()><img src=../../assets/svg/catalog/ic_fluent_pane_close_24_regular.svg border=0 alt=\"".$msgstr["cancelar"]."\">".$msgstr["cancelar"]."</a></td>\n";
				if (isset($_SESSION["permiso"]["CENTRAL_DELREC"]) or isset($_SESSION["permiso"][$db."_CENTRAL_DELREC"]) or isset($_SESSION["permiso"]["CENTRAL_ALL"]) or isset($_SESSION["permiso"][$db."_CENTRAL_ALL"])){
					echo "<td><a class='bt-lg bt-red' href=javascript:EliminarRegistro()><img src=../../assets/svg/catalog/ic_fluent_delete_dismiss_24_regular.svg border=0 alt=\"".$msgstr["eliminar"]."\">".$msgstr["eliminar"]."</a></td>\n";
				}
			}
		}
		?>
			</tr>
		</table>
		</div>
		<?php
	}
}
echo "</form>";// end of previous form. Not the correct place but protects next form
echo "<form method=post name=forma2 action=fmt.php >\n";
if (isset($arrHttp["encabezado"])) {
	 echo "<input type=hidden name=encabezado value=s>\n";
	 echo "<input type=hidden name=Formato value=".$arrHttp["base"].">\n";
}
echo "<input type=hidden name=IsisScript value=ingreso.xis>\n";
echo "<input type=hidden name=base value=".$arrHttp["base"].">\n";
echo "<input type=hidden name=cipar value=".$arrHttp["cipar"].">\n";
if ($arrHttp["Opcion"]=="capturar" || $arrHttp["Opcion"]=="nuevo" || $arrHttp["Opcion"]=="captura_bd") {
	$a="crear" ;
}else{
 	$a=$arrHttp["Opcion"];
}
echo "<input type=hidden name=Opcion value=$a>\n";
if (isset($arrHttp["ventana"])) echo "<input type=hidden name=ventana value=".$arrHttp["ventana"].">\n";
echo "<input type=hidden name=ValorCapturado value=\"\">\n";
echo "<input type=hidden name=NoVar>\n";
echo "<input type=hidden name=Indice value=\"\">\n";
if (isset($arrHttp["Mfn"])){
	echo "<input type=hidden name=Mfn value=".$arrHttp["Mfn"].">\n";
	echo "<input type=hidden name=from value=".$arrHttp["Mfn"].">\n";
}
echo "<input type=hidden name=ver value=S>\n";

echo "</form>";

?>