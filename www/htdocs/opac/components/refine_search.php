	<?php
    if ($Expresion!='$'){
    ?>
	<div style="border:1px solid #CCCCCC; border-radius: 4px;margin-top:10px; padding:10px;">
	    <strong><?php echo $msgstr["su_consulta"];?></strong>

	    <?php echo str_replace('"','',PresentarExpresion($base));
		if (!isset($_REQUEST["indice_base"]) or $_REQUEST["indice_base"]==0 or $_REQUEST["indice_base"]==1 ){
            ?>

	    <br>
	    <div>
	        <a href="javascript:document.buscar.action='avanzada.php';document.buscar.submit();">
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

	    </div>
	</div>
	<?php
    }