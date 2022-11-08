	<?php
    if ($Expresion!='$'){
    ?>
<div class="card">
  <div class="card-body">
	    <strong><?php echo $msgstr["su_consulta"];?></strong>

	    <?php echo str_replace('"','',PresentarExpresion($base));
		if (!isset($_REQUEST["indice_base"]) or $_REQUEST["indice_base"]==0 or $_REQUEST["indice_base"]==1 ){
            ?>

			<p>
	        <a href="javascript:document.buscar.action='search_advanced.php';document.buscar.submit();">
	            <i class="fa fa-filter"></i><?php echo $msgstr["afinar"];?>
	        </a>
	        <?php    
			if (!isset($_REQUEST["indice_base"]) or $_REQUEST["indice_base"]==1){
            ?>
	        <a
	            href="javascript:document.buscar.indice_base.value=0;document.buscar.integrada.value='';document.buscar.coleccion.value='';document.buscar.submit();">
	            <img src=../images/expansion.png height=20px> <?php echo $msgstr["buscar_en_todos"];?>
	        </a>
	        <?php
            }
		}
	    ?>
		</p>
  </div>
</div>

	<?php
    }