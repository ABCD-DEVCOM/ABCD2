
<script language=javascript>
<?php
	if (isset($arrHttp["Tabla"]))
		echo "\nTabla=\"".$arrHttp["Tabla"]."\"\n";
	else
		echo "\nTabla=\"\"\n";

?>
function EjecutarBusqueda(F,desde){
	switch (desde){
		case 1:
/* buscar los terminos de este diccionario*/
			TerminosSeleccionados=""
			document.forma1.Opcion.value="buscar_en_este"
			for (i=0;i<document.forma1.terminos.length;i++){
				if (document.forma1.terminos.options[i].selected==true){
					Termino="\""+document.forma1.terminos.options[i].value+"\""
					if (TerminosSeleccionados==""){
						TerminosSeleccionados=Termino
					}else{
						TerminosSeleccionados=TerminosSeleccionados+" or "+Termino
					}
				}
			}
       		re = / /g
/*'       	TerminosSeleccionados=TerminosSeleccionados.replace(re,"+") */
			document.forma1.Expresion.value=TerminosSeleccionados

			document.forma1.action="buscar.php"
<?

	if (isset($arrHttp["Tabla"])){
  		if ($arrHttp["Tabla"]=="cGlobal")
  			echo "document.forma1.action=\"c_global.php\"\n";
  		if ($arrHttp["Tabla"]=="imprimir")
			echo "document.forma1.action=\"imprimir.php\"\n";
		if ($arrHttp["Tabla"]=="browse_search"){
			echo "document.forma1.action=\"browse_search.php\"\n";
			echo "window.opener.document.forma1.Expre.value=TerminosSeleccionados\n
			window.opener.document.diccionario.from.value=1;
			window.opener.EjecutarBusqueda()
			self.close()
			";
		}
	}
?>
			document.forma1.submit()
<?php if (isset($arrHttp["prestamo"]) or isset($arrHttp["Target"])) {
       echo " self.close()\n";
   }
?>
			break
		case 2:
/* Pasar los términos seleccionados */
			TerminosSeleccionados=""
			for (i=0;i<document.forma1.terminos.length;i++){
				if (document.forma1.terminos.options[i].selected==true){

					Termino=document.forma1.terminos.options[i].value
					len_t=<?php echo strlen($arrHttp["prefijo"])."\n"?>
					Termino="\""+Termino+"\""
					if (TerminosSeleccionados==""){
						TerminosSeleccionados=Termino
					}else{
						TerminosSeleccionados=TerminosSeleccionados+" or "+Termino
					}
				}
			}
			if  (Tabla=="browse_search" || Tabla=="browse"){				window.opener.document.forma1.expre.value=TerminosSeleccionados
				self.close()
				break;			}
			a=window.opener.document.forma1.expre[document.forma1.Diccio.value].value
			if (a==""){
				window.opener.document.forma1.expre[document.forma1.Diccio.value].value=TerminosSeleccionados
			}else{
				window.opener.document.forma1.expre[document.forma1.Diccio.value].value=a+" or "+TerminosSeleccionados
			}
   			self.close()
			break
		case 4:
/* Más términos */
			document.forma1.Opcion.value="mas_terminos"
			document.forma1.submit()
			break
		case 3:
/* Continuar */
			document.forma1.Opcion.value="mas_terminos"
			document.forma1.LastKey.value=document.forma1.prefijo.value+document.forma1.IR_A.value
			document.forma1.submit()
			break
	}
}
?>
</script>

<body>
<?php
echo "Índice de: ".urldecode($arrHttp["campo"]);
?>
<basefont=2> <Font face="Arial">

<FORM METHOD="Post" name=forma1 action=diccionario.php onSubmit="Javascript:return false">
<input type=hidden name=Opcion value='<?php echo $arrHttp["Opcion"]?>'>
<input type=hidden name=session_id value='<?php echo $arrHttp["session_id"]?>'>
<input type=hidden name=base value='<?php echo $arrHttp["base"]?>'>
<input type=hidden name=cipar value='<?php echo $arrHttp["cipar"]?>'>
<input type=hidden name=Formato value='<?php echo $arrHttp["Formato"]?>'>
<input type=hidden name=prologo value='<?php echo $arrHttp["prologo"]?>'>
<input type=hidden name=epilogo value='<?php echo $arrHttp["epilogo"]?>'>
<input type=hidden name=Expresion value="">
<input type=hidden name=prefijo value='<?php echo $arrHttp["prefijo"]?>'>
<input type=hidden name=Diccio value='<?php echo $arrHttp["Diccio"]?>'>
<input type=hidden name=desde value=<?php if (isset($arrHttp["desde"])) echo $arrHttp["desde"]?>>
<input type=hidden name=id value=<?php echo $arrHttp["id"]?>>
<?php if (isset($arrHttp["prestamo"])) {
	echo "<input type=hidden name=prestamo value=".$arrHttp["prestamo"].">";

  }
 if (isset($arrHttp["Tabla"])) {
	echo "<input type=hidden name=Tabla value=".$arrHttp["Tabla"].">";
 }
if (isset($arrHttp["Target"])) {
	echo "<input type=hidden name=Target value=".$arrHttp["Target"].">";
}

 ?>

<input type=hidden name=campo value="<?php echo urldecode($arrHttp["campo"])?>">
  <table xwidth="640" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="20">&nbsp;</td>
      <td colspan="2" valign="top" class="menusec1">
		<?php // echo $msgstr["selmultiple"];?>
      </td>
      <td width="15" height="9">&nbsp;</td>
    </tr>
    <tr>
      <td width="20">&nbsp;</td>
      <td rowspan="2" width="5" align="left" valign="top">&nbsp;</td>
      <td rowspan="2" xwidth="585" valign=top>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td xwidth=250>
              <select name=terminos  size=16 multiple xwidth=250>
              <OPTION VALUE="">
