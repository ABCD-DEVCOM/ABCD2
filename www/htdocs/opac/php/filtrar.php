
 				<div id="sidebar">
					<font class="tituloBase">Filtrar por colección</font><hr>
					<ul>
						<?php
						$archivo=$path."../data/colecciones.tab";
						$fp=file($archivo);
			          	foreach ($fp as $value){
			          		$value=trim($value);
			          		if ($value!=""){
			          			$v=explode('|',$value);
			          			echo "<li><input type=radio name=coleccion id=coleccion value='".$value."'>";
			          			echo "<label>".$v[1]."</label></li>";
			          		}
			          	}
			          	?>
					</ul>
				</div>