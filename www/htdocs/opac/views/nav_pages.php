<?php

function NavegarPaginas($totalRegistros,$count,$desde,$select_formato){
global $bd_list,$multiplesBases,$base,$msgstr, $npages;
	if (!isset($_REQUEST["pagina"]) or $_REQUEST["pagina"]=="" ){
      	$pagina=1;
      	$_REQUEST["pagina"]=1;
    }else{
      	$pagina=$_REQUEST["pagina"];
    }
	$prox_p=$pagina;
	echo "<input type=hidden name=desde size=4 value=$desde id=desde>&nbsp; &nbsp; ";
  	echo "<input type=hidden name=pagina value=".$prox_p.">\n";
  	 foreach ($_REQUEST as $key=>$value){
			if ($key=="integrada") $value=urlencode($value);
			if ($key!="desde" and
			    $key!="existencias" and
			    $key!="count" and
			    $key!="Expresion" and
			    $key!="pagina" and
			    $key!="Campos" and
			    $key!="Operadores" and
			    $key!="Sub_Expresion") echo "<input type=hidden name=$key value=\"".urlencode($value)."\">\n";
		}
	if ($totalRegistros>$count){
		$paginas=$totalRegistros/$count;
		$leftover = $paginas - floor($paginas);
		$paginas=intval($paginas);
		if ($leftover>0) $paginas=$paginas+1;
		if ($prox_p>=5)
			$pagina=$pagina;
		else
			$pagina=1;
		$cuenta_p=0;
		$anterior=$prox_p-1;
		if ($anterior<=0){
			$anterior=1;
			$pg=1;
		}else{
			$pg=($anterior)*$npages+1;
		}
		?>



<div class="row">
	<div class="col-md-6 offset-md-3">

<nav aria-label="Page navigation example">


			<ul class="pagination">

				<li class="page-item">
					<a class="page-link" href="javascript:ProximaPagina(1,1)"> <i class="fas fa-angle-double-left" title="<?php echo $msgstr["front_primera_pag"];?>" alt="<?php echo $msgstr["front_primera_pag"];?>"></i>
					</a>
				</li>
        		<li class="page-item">
        			<a class="page-link" href=javascript:ProximaPagina(<?php echo $anterior;?>,<?php echo $pg;?>)>
        				<i class="fas fa-chevron-left" title="<?php echo $msgstr["front_anterior"];?>" alt="<?php echo $msgstr["front_anterior"];?>"></i>
        			</a>
        		</li>



<?php
if ($paginas>1){
while ($cuenta_p<5){
	$cuenta_p=$cuenta_p+1;
	$pg=($pagina-1)*$npages+1;
	if ($pagina==$_REQUEST["pagina"])
		$active=" active";
	else
		$active="";

	echo "<li class='page-item'><a class='page-link $active'  href=javascript:ProximaPagina($pagina,$pg)>".$pagina."</a></li>";
	$pagina=$pagina+1;
	if ($pagina>$paginas) break;
}
}

$pagina=$_REQUEST["pagina"]+1;
if ($pagina>$paginas) $pagina=$paginas;
$pg=($pagina-1)*$npages+1;?>

<li class="page-item">
	<a class="page-link" href="javascript:ProximaPagina(<?php echo $pagina; ?>,<?php echo $pg;?>)">
		<i class="fas fa-chevron-right" title="<?php echo $msgstr["front_proximo"];?>" alt="<?php echo $msgstr["front_proximo"];?>"></i>
	</a>
</li>

<?php
$pg=$totalRegistros-$count+1;
while ($pg<=0) $pg=$pg+1;
?>

<li class="page-item">
	<a class="page-link" href=javascript:ProximaPagina(<?php echo $paginas;?>,<?php echo $pg;?>)>
		<i class="fas fa-angle-double-right" title="<?php echo $msgstr["front_ultima_pag"];?>" alt="<?php echo $msgstr["front_ultima_pag"];?>"></i>			
	</a>
</li>

	</ul>
</nav>

	<input type="hidden" name="count" value="<?php echo $_REQUEST["count"];?>" size="4">

	</div>
<div>

<div class="row justify-content-around mb-3  custom-searchbox">

<div class="col-3">
	<h6  class="text-dark"><?php echo  $bd_list[$base]["descripcion"];?></h6>
</div>

<div class="col-3">
	<p><?php echo $msgstr["front_pagina"]." ".$_REQUEST["pagina"]." ".$msgstr["front_de"]." ".$paginas;?></p>
</div>

<div class="col-3">
	<?php echo $select_formato;?>
</div>

</div>

<?php

       // if ($multiplesBases=="N"){
       // 	$paginas=1;
       // 	$pg=1;
       // 	echo "<br><input type=button id=search-submit value=\"Volver al inicio\" onclick=javascript:document.continuar.base.value='biblo';ProximaPagina($paginas,$pg)>";
       // }
		echo "\n</div>\n";
		//echo "&nbsp; &nbsp;<input type=submit value='Continuar'>";
	}else{
		echo $select_formato."<br>";
	}

	if (isset($_REQUEST["prefijoindice"])) { ?>
		<input  class="btn btn-secondary" type="button" id="search-submit" value="<?php echo $msgstr["front_index_back"];?>" onclick="javascript:document.indice.submit()">
	<?php
	}
}

?>
