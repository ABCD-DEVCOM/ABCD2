<?php
function PresentarDiccionario(){
include("presentar_diccionario_inc.php");
	if (count($terms)>0) {
		foreach ($terms as $linea) 	{
			//echo "$linea<br>";
			echo "<option value=$delimitador".$linea."$delimitador>".$linea."\n";
			$LastKey=$linea;
		}


	}else{
		//echo "<font size=2>No hay más términos en este diccionario<p>

		//	</html>";
	}

}
?>



			<div class="input-group mb-3">
 				<input class="form-control form-control-sm" type="text" name="IR_A" size="15" placeholder="<?php echo $msgstr["search"]?> ..." >
				<input class="btn btn-sm btn-success" type="button" value="<?php echo $msgstr["ira"]?>" onclick="javascript:NavegarDiccionario(this,3)" id="search-submit">
			</div>
				<input type=hidden name=campo value="<?php if (isset($_REQUEST["campo"])) echo urldecode($_REQUEST["campo"])?>">

			<div class="row col-auto">
			<div class="col-6">
				<select class="form-select form-select-sm" size="10" name="terminos"  multiple onDblClick="moveSelectedOptions(document.diccionario.terminos,document.diccionario.TerminosSeleccionados,false)">
					<?php PresentarDiccionario(); ?>
				</select>
			

			
				<input class="btn btn-sm btn-primary" type="button" value="<?php echo $msgstr["mas_terminos"]?>" id="search-submit" onclick="javascript:NavegarDiccionario(this,4)">
				<input type="hidden" value="<?php echo $LastKey?>" name="LastKey">

			</div>

			<div class="col-1">
				<button class="btn btn-secondary btn-sm" id="search-submit" onClick="moveSelectedOptions(document.diccionario.terminos,document.diccionario.TerminosSeleccionados,false)"><i class="fa fa-angle-right" id="search-submit"></i></button>
 				<br><br>
				<button class="btn btn-secondary btn-sm" id="search-submit" onclick="moveSelectedOptions(document.diccionario.TerminosSeleccionados,document.diccionario.terminos,false)"><i class="fa fa-angle-left" id="search-submit"></i></button>
			</div>

		<div class="col-5">	
 		 <label><?php echo $msgstr["terminos_b"]?></label>
 		  <select class="form-select form-select-sm" size="10" name="TerminosSeleccionados" multiple  onDblClick="moveSelectedOptions(document.diccionario.TerminosSeleccionados,document.diccionario.terminos,false)" >
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
	</div>
</div><!--./row-->
		  			<div id="indice" >

<nav aria-label="Page navigation example">
	<ul class="pagination pagination-sm">
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('')">0-9</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('A')">A</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('B')">B</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('C')">C</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('D')">D</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('E')">E</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('F')">F</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('G')">G</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('H')">H</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('I')">I</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('J')">J</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('K')">K</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('L')">L</a></li>
</ul>
</nav>
<nav aria-label="Page navigation example">
	<ul class="pagination pagination-sm">
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('M')">M</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('N')">N</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('O')">O</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('P')">P</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('Q')">Q</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('R')">R</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('S')">S</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('T')">T</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('U')">U</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('V')">V</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('W')">W</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('X')">X</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('Y')">Y</a></li>
		<li class="page-item"><a class="page-link" href="javascript:AbrirIndice('Z')">Z</a></li>
	</ul>
</nav>
	  		</div>
          <p>

 	<?php if ($_REQUEST["Opcion"]!="libre"){
 		switch ($_REQUEST["llamado_desde"]){
 			case "/opac/buscar_integrada.php":
 				$accion=1;
 				break;
 			default:
 				$accion=2;
 				break;
 		}
  	?>


          	<input class="btn btn-primary btn-sm" type="button" id="search-submit" value="<?php echo $msgstr["enviar_fb"]?>" onclick="javascript:EjecutarBusquedaDiccionario(<?php echo $accion?>)"></a>
   <?php }
     if (!isset($_REQUEST["criterios"]) or $_REQUEST["criterios"]!="S"){
   ?>

 	&nbsp; <input class="btn btn-success btn-sm" type=button id=search-submit value=" <?php echo $msgstr["search"]?> " onclick="javascript:EjecutarBusquedaDiccionario(0,'')">
   <?php } ?>
