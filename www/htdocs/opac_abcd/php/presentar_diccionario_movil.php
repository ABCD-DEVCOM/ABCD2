<?php
function PresentarDiccionario(){
	include("presentar_diccionario_inc.php");
	if (count($terms)>0) {
		foreach ($terms as $linea) 	{
			echo "<tr><td valign=top nowrap><input type=checkbox name=terminosChk value=\"".$linea."\" onclick=addTerm()></td><td>".$linea."</td></tr>\n";
			$LastKey=$linea;
		}


	}else{
		//echo "<font size=2>No hay más términos en este diccionario<p>

		//	</html>";
	}

}
?>

  <table xwidth="640" border="0" cellspacing="0" cellpadding="0">
  	<tr>
  		<td  bgcolor=#ffffff align=center width=20 valign=center><font size=1 face="arial">


  		</td>

  		<td width=250 valign=top>
  			<font class=titulo2 size=1>
 			<input type=text name="IR_A" size=15 placeholder="<?php echo $msgstr["search"]?> ..." >	<input type=button value=<?php echo $msgstr["ira"]?> onclick="javascript:NavegarDiccionarioMovil(this,3)" id=search-submit>
			<input type=hidden name=campo value="<?php if (isset($_REQUEST["campo"])) echo urldecode($_REQUEST["campo"])?>">
            <BR>
            <div id=terminos style="font-size:10px;width:330px;height:180px;margin-bottom:5px;overflow: auto; overflow-x: hidden;border:1px dotted;"  onDblClick="moveSelectedOptions(document.diccionario.terminos,document.diccionario.TerminosSeleccionados,false)">
            <table name=TerminosTbl id=TerminosTbl>
<?php
PresentarDiccionario();
?>
			</table>
			</div>
			<br>
			<input type=button value="<?php echo $msgstr["mas_terminos"]?>" id=search-submit onclick="javascript:NavegarDiccionarioMovil(this,4)">
			<div id=indice style="width:330px;font-size:12px;font-family:'courier new'">

			<a href=javascript:AbrirIndiceMovil('')>0-9</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('A')>A</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('B')>B</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('C')>C</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('D')>D</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('E')>E</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('F')>F</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('G')>G</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('H')>H</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('I')>I</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('J')>J</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('K')>K</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('L')>L</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('M')>M</a><br>&nbsp;&nbsp;&nbsp;&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('N')>N</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('O')>O</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('P')>P</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('Q')>Q</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('R')>R</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('S')>S</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('T')>T</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('U')>U</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('V')>V</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('W')>W</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('X')>X</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('Y')>Y</a>&nbsp;
	  		<a href=javascript:AbrirIndiceMovil('Z')>Z</a><br>
	  		</div>
   			<INPUT TYPE=HIDDEN VALUE="<?php echo $LastKey?>" NAME="LastKey">
   			<br>
   			</span>
   			</font>
 		</td>
 		<td   align=center valign=top width=30>
 		</td>
 		<td valign=top style="margin-top:4px" align=center>
  			<font class=titulo2>

 		  <?php echo $msgstr["terminos_b"]?><br>
 		 <div id=Terminos style="font-size:10px;width:300px;height:180px;margin-top:7px;margin-bottom:5px;overflow: auto; overflow-x: hidden;text-align:left;border:1px dotted;" >
         <table name=TerminosSeleccionadosTbl id=TerminosSeleccionadosTbl border=0>
<?php
if (isset($_REQUEST["Seleccionados"])){
	$s=Explode('"',$_REQUEST["Seleccionados"]);
	foreach ($s as $value){
		if (trim($value)!=""){
			echo "<tr><td valign=top><a href=# onclick=removeTerm(this)><img src=../images/buttonm.gif></a></td><td nowrap><input type=hidden name=TerminosSeleccionadosTxt id=TerminosSeleccionadosTxt value=\"".$value."\" >".$value."</td></tr>\n";
		}
	}
}
?>
 		  </table>
         </div>
          <p>

 	<?php if ($_REQUEST["Opcion"]!="libre"){
 		switch ($_REQUEST["llamado_desde"]){
 			case "buscar_integrada.php":
 				$accion=1;
 				break;
 			default:
 				$accion=2;
 				break;
 		}
  	?>


          	<input type=button id=search-submit value="Enviar al formulario" onclick="javascript:EjecutarBusquedaDiccionarioMovil(<?php echo $accion?>)"></a>
   <?php }
     if (!isset($_REQUEST["criterios"]) or $_REQUEST["criterios"]!="S"){
   ?>

 	&nbsp; <input type=button id=search-submit value=" <?php echo $msgstr["search"]?> " onclick="javascript:EjecutarBusquedaDiccionarioMovil(0,'')">
   <?php } ?>


  </td>
  </tr>

  </table>

<script>
function removeTerm(row){
            var parent = row.parentNode;
  			var tagName = "table";

  			while (parent) { //Loop through until you find the desired parent tag name
				if (parent.tagName && parent .tagName.toLowerCase() == tagName) {
      				tableID=(parent .id);
      				break;
    			}else{
          			parent = parent .parentNode;
      			}
			}

            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

    	var i=row.parentNode.parentNode.rowIndex;
    	document.getElementById(tableID).deleteRow(i);
}

function addTerm() {	var Ctrl = document.getElementsByName("terminosChk");
    for (i=0;i<Ctrl.length;i++){    	if (Ctrl[i].checked){
    		Termino=Ctrl[i].value    		Ctrl[i].checked=false        	table=document.getElementById("TerminosSeleccionadosTbl")
        	var rowCount = table.rows.length;
        	var newRow = table.insertRow(rowCount);
        	var newCell = newRow.insertCell(0);
        	newCell.vAlign = 'top';
        	newCell.innerHTML = '<a href=# onclick=removeTerm(this)><img src=../images/buttonm.gif></a>'
  			var newCell = newRow.insertCell(1);
  			newCell.innerHTML='<input type=hidden name=TerminosSeleccionadosTxt id=TerminosSeleccionadosTxt value="'+Termino+'" >'+Termino
        }

 	}
}

function ObtenerTerminosMovil(desde){
	Expresion=""
	Ctrl=document.getElementsByName(desde)
	ix=Ctrl.length
	if (Opcion=='libre')
		delimitador='"'
	else
		delimitador='"'

	for (i=0;i<ix;i++){
		Termino=Ctrl[i].value
		if (Expresion=="")
				Expresion=delimitador+Termino+delimitador
			else
				Expresion+=" "+delimitador+Termino+delimitador

	}
	return Expresion

}

function EjecutarBusquedaDiccionarioMovil(Accion){
	Expresion=""
	Seleccionados=ObtenerTerminosMovil("TerminosSeleccionadosTxt")
	if (Seleccionados==""){
		alert("Favor seleccionar los términos de búsqueda")
		return false
	}
	Expresion=Seleccionados
	document.diccionario.Seleccionados.value=Expresion;
	switch (Accion){

		case 0:
			document.diccionario.Opcion.value="buscar_diccionario"
			document.diccionario.Sub_Expresion.value=Expresion;
			document.diccionario.action="buscar_integrada.php"
			break
		case 1:
			document.diccionario.action="buscar_integrada.php"
			break
		case 2:
			document.diccionario.action="avanzada.php"
			break
	}
	document.diccionario.submit()
}

function NavegarDiccionarioMovil(F,desde){
	Seleccionados=""
 	Seleccionados=ObtenerTerminosMovil("TerminosSeleccionadosTxt")
 	if (Seleccionados!=""){
 		document.diccionario.Seleccionados.value=Seleccionados
 	}
	switch (desde){
		case 4:
/* Más términos */
			document.diccionario.Navegacion.value="mas terminos"
			document.diccionario.submit()
			break
		case 3:
/* Ir a */
			document.diccionario.Navegacion.value="ir a"
			document.diccionario.LastKey.value=document.diccionario.IR_A.value
			document.diccionario.submit()
			break
	}
}

function AbrirIndiceMovil(Letra){
  	document.diccionario.IR_A.value=Letra
  	NavegarDiccionarioMovil(this,3)
}
</script>