<?php
function PresentarDiccionario(){
include("presentar_diccionario_inc.php");
	if (count($terms)>0) {
		foreach ($terms as $linea) 	{			//echo "$linea<br>";
			echo "<option value=$delimitador".$linea."$delimitador>".$linea."\n";
			$LastKey=$linea;
		}


	}else{
		//echo "<font size=2>No hay más términos en este diccionario<p>

		//	</html>";
	}

}
?>
  <table  border="0" cellspacing="0" cellpadding="0">
  	<tr>
  		<td  bgcolor=#ffffff align=center width=20 valign=center><font size=1 face="arial">


  		</td>

  		<td width=250 valign=top>
  			<font class=titulo2 size=1>
 			<input type=text name="IR_A" size=15 placeholder="<?php echo $msgstr["search"]?> ..." >	<input type=button value="<?php echo $msgstr["ira"]?>" onclick="javascript:NavegarDiccionario(this,3)" id=search-submit>
			<input type=hidden name=campo value="<?php if (isset($_REQUEST["campo"])) echo urldecode($_REQUEST["campo"])?>">
            <BR>
   			<select name=terminos  multiple=multiple style="font-size:11px;width:330px;height:180px;margin-bottom:5px"  onDblClick="moveSelectedOptions(document.diccionario.terminos,document.diccionario.TerminosSeleccionados,false)">

<?php
PresentarDiccionario();
?>
			</select>
			<br>
			<input type=button value="<?php echo $msgstr["mas_terminos"]?>" id=search-submit onclick="javascript:NavegarDiccionario(this,4)">
			<div id=indice style="width:250;font-size:12px;font-family:'courier new'">

			<a href=javascript:AbrirIndice('')>0-9</a>&nbsp;
	  		<a href=javascript:AbrirIndice('A')>A</a>&nbsp;
	  		<a href=javascript:AbrirIndice('B')>B</a>&nbsp;
	  		<a href=javascript:AbrirIndice('C')>C</a>&nbsp;
	  		<a href=javascript:AbrirIndice('D')>D</a>&nbsp;
	  		<a href=javascript:AbrirIndice('E')>E</a>&nbsp;
	  		<a href=javascript:AbrirIndice('F')>F</a>&nbsp;
	  		<a href=javascript:AbrirIndice('G')>G</a>&nbsp;
	  		<a href=javascript:AbrirIndice('H')>H</a>&nbsp;
	  		<a href=javascript:AbrirIndice('I')>I</a>&nbsp;
	  		<a href=javascript:AbrirIndice('J')>J</a>&nbsp;
	  		<a href=javascript:AbrirIndice('K')>K</a>&nbsp;
	  		<a href=javascript:AbrirIndice('L')>L</a>&nbsp;
	  		<a href=javascript:AbrirIndice('M')>M</a>&nbsp;<br>&nbsp;&nbsp;&nbsp;&nbsp;
	  		<a href=javascript:AbrirIndice('N')>N</a>&nbsp;
	  		<a href=javascript:AbrirIndice('O')>O</a>&nbsp;
	  		<a href=javascript:AbrirIndice('P')>P</a>&nbsp;
	  		<a href=javascript:AbrirIndice('Q')>Q</a>&nbsp;
	  		<a href=javascript:AbrirIndice('R')>R</a>&nbsp;
	  		<a href=javascript:AbrirIndice('S')>S</a>&nbsp;
	  		<a href=javascript:AbrirIndice('T')>T</a>&nbsp;
	  		<a href=javascript:AbrirIndice('U')>U</a>&nbsp;
	  		<a href=javascript:AbrirIndice('V')>V</a>&nbsp;
	  		<a href=javascript:AbrirIndice('W')>W</a>&nbsp;
	  		<a href=javascript:AbrirIndice('X')>X</a>&nbsp;
	  		<a href=javascript:AbrirIndice('Y')>Y</a>&nbsp;
	  		<a href=javascript:AbrirIndice('Z')>Z</a><br>
	  		</div>
   			<INPUT TYPE=HIDDEN VALUE="<?php echo $LastKey?>" NAME="LastKey">
   			<br>
   			</span>
   			</font>
 		</td>
 		<td   align=center width=50 valign=center>
 			<input type=button value="&minus;&gt;" id=search-submit onClick="moveSelectedOptions(document.diccionario.terminos,document.diccionario.TerminosSeleccionados,false)" style="width:30px;">
 			<br><br>
 			<input type=button value="&lt;&minus;" id=search-submit onclick="moveSelectedOptions(document.diccionario.TerminosSeleccionados,document.diccionario.terminos,false)" style="width:30px;">&nbsp;
 		</td>
 		<td width=250 valign=top style="margin-top:4px" align=center>
  			<font class=titulo2>

 		 <?php echo $msgstr["terminos_b"]?><br>
 		  <select name=TerminosSeleccionados multiple=multiple style="font-size:11px;width:280px;height:180px;margin-bottom:5px"  onDblClick="moveSelectedOptions(document.diccionario.TerminosSeleccionados,document.diccionario.terminos,false)" style="font-size:11px;width:250px">
<?php
if (isset($_REQUEST["Seleccionados"])){
	$s=Explode('"',$_REQUEST["Seleccionados"]);
	foreach ($s as $value){
		if (trim($value)!=""){
			echo "<option value=\"".$value."\">$value</option>\n";
		}
	}
}
?>
 		  </select>

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


          	<input type=button id=search-submit value="<?php echo $msgstr["enviar_fb"]?>" onclick="javascript:EjecutarBusquedaDiccionario(<?php echo $accion?>)"></a>
   <?php }
     if (!isset($_REQUEST["criterios"]) or $_REQUEST["criterios"]!="S"){
   ?>

 	&nbsp; <input type=button id=search-submit value=" <?php echo $msgstr["search"]?> " onclick="javascript:EjecutarBusquedaDiccionario(0,'')">
   <?php } ?>


  </td>
  </tr>

  </table>