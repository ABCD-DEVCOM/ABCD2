<div id="sidebar">
	<ul>
		<li>
			<h2>Colecciones</h2>
			<ul>
			<?php
          	foreach ($bd_list as $key => $value){
          		if (trim($value["nombre"])!=""){
          			echo "<li><a href=php/otras_busquedas.php?base=$key&Opcion=detalle>".$value["titulo"]."</a><p>".$value["descripcion"]."</p></li>\n";
          		}
          	}
          	?>
			</ul>
		</li>
	</ul>
</div>