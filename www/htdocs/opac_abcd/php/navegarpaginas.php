<?php

function NavegarPaginas($totalRegistros,$count,$desde,$select_formato){
global $bd_list,$multiplesBases,$base,$msgstr;
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
		if ($prox_p>=20)
			$pagina=$pagina-7;
		else
			$pagina=1;
		$cuenta_p=0;
		$anterior=$prox_p-1;
		if ($anterior<=0){
			$anterior=1;
			$pg=1;
		}else{
			$pg=($anterior)*25+1;
		}
		echo "\n<div style='width:100%;margin:0 auto;text-align:center; font-size:12px;'>\n";
		echo  $bd_list[$base]["descripcion"]."<br>";
		echo $msgstr["pagina"]." ".$_REQUEST["pagina"]." ".$msgstr["de"]." $paginas <br>";
		echo $select_formato."<br>";
		echo "<ul class=pagination>\n";
		echo "<li><a href=javascript:ProximaPagina(1,1)><img src=../images/first.gif valign=middle alt='".$msgstr["primera_pag"]."' title='".$msgstr["primera_pag"]."'></a></li>\n";
        echo "<li><a href=javascript:ProximaPagina($anterior,$pg)><img src=../images/left.gif valign=middle alt='".$msgstr["anterior"]."' title='".$msgstr["anterior"]."'></a></li>\n";

  		if ($paginas>1){
			while ($cuenta_p<20){
				$cuenta_p=$cuenta_p+1;
				$pg=($pagina-1)*25+1;
				if ($pagina==$_REQUEST["pagina"])
					$active=" class=active";
				else
					$active="";

				echo "<li><a $active href=javascript:ProximaPagina($pagina,$pg)>".$pagina."</li>";
				$pagina=$pagina+1;
				if ($pagina>$paginas) break;
			}
        }

        $pagina=$_REQUEST["pagina"]+1;
        if ($pagina>$paginas) $pagina=$paginas;
        $pg=($pagina-1)*25+1;
        echo "<li><a href=javascript:ProximaPagina($pagina,$pg)><img src=../images/right.gif valign=middle alt='".$msgstr["proximo"]."' title='".$msgstr["proximo"]."'></a></li>\n";
		$pg=$totalRegistros-$count+1;
		while ($pg<=0) $pg=$pg+1;
		echo "<li><a href=javascript:ProximaPagina($paginas,$pg)><img src=../images/last.gif valign=middle alt='".$msgstr["ultima_pag"]."' title='".$msgstr["ultima_pag"]."'></a></li>\n";
		echo "</ul>";

		echo "<input type=hidden name=count value=".$_REQUEST["count"]." size=4>";


       // if ($multiplesBases=="N"){
       // 	$paginas=1;
       // 	$pg=1;       // 	echo "<p><br><input type=button id=search-submit value=\"Volver al inicio\" onclick=javascript:document.continuar.base.value='biblo';ProximaPagina($paginas,$pg)>";       // }
		echo "\n</div>\n";
		//echo "&nbsp; &nbsp;<input type=submit value='Continuar'>";
	}else{		echo $select_formato."<br>";	}

	if (isset($_REQUEST["prefijoindice"])) {
		echo "<p><br><input type=button id=search-submit value=\" &nbsp;".$msgstr["index_back"]."&nbsp; \" onclick=javascript:document.indice.submit()>\n";
	}
}

?>
