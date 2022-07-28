<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky"> 
		<ul class="nav flex-column">
<?php

include_once ('components/facets.php');

if (!isset($_REQUEST["existencias"]) or trim($_REQUEST["existencias"])=="" ){


    $primeravez="S";
    // if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]!=""){
?>		
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
          <span><?php echo $msgstr["catalog"]; ?></span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle" class="align-text-bottom"></span>
          </a>
        </h6>	
<?php
		//}

?>
       

<?php
		/*
	foreach ($bd_list as $key => $value){
		$archivo=$db_path.$key."/opac/".$lang."/".$key."_colecciones.tab";
		$ix=0;
		$value_info="";
		$home_link="*";
		if (file_exists($db_path."opac_conf/".$lang."/".$key."_home.info")){
			$home_info=file($db_path."opac_conf/".$lang."/".$key."_home.info");
			foreach ($home_info as $value_info){
				$value_info=trim($value_info);
				if ($value_info!=""){
					if (substr($value_info,0,6)=="[LINK]") $home_link=$value_info;
					if (substr($value_info,0,6)=="[TEXT]") $home_link=$value_info;
					if (substr($value_info,0,5)=="[MFN]")  $home_link="";
				}
				//echo "**$value_info<br>";
			}
		}
		if (trim($value["nombre"])!=""){
			echo "<a href='javascript:BuscarIntegrada(\"$key\",\"\",\"libre\",\"\$\",\"\",\"\",\"\",\"\",\"\",\"$home_link\")'>";
			echo "<strong>".$value["titulo"]."</strong></a><br>\n";
	    	if (file_exists($archivo)){
	    		$fp=file($archivo);
	    		echo "<ul>\n";

	    		foreach ($fp as $colec){
	          		$colec=trim($colec);
	          		if ($colec!=""){
	          			$v=explode('|',$colec);
	          			$ix=$ix+1;
	          			if ($v[0]!='<>'){
							if (isset($IndicePorColeccion) and $IndicePorColeccion=="S")
								$cipar="_".strtolower($v[0]);
							else
								$cipar="";
							echo "<li>";
							echo "<a href='javascript:BuscarIntegrada(\"$key\",\"1B\",\"libre\",\"\",\"$colec\",\"\",\"\",\"\",\"\",\"\")'>";
							//echo "<a href=\"buscar_integrada.php?base=$key&cipar=$key".$cipar."&coleccion=$colec&Opcion=libre\">"
			          		echo $v[1]."</a></li>\n";
	          			}else{
		          				//echo "<li>".$v[1]."</i></label></a></li>\n";
		        		}
		          	}
	          	}
	          	echo "</ul>\n";
	    	}else{
	    		//echo "</li>\n";
	   		}
	     }

	}
*/

	if (file_exists($db_path."opac_conf/".$lang."/side_bar.info")){
		$fp=file($db_path."opac_conf/".$lang."/side_bar.info");
		$sec_name="";
		foreach ($fp as $value){
			$value=trim($value);
			if ($value!=""){
				if (substr($value,0,9)=="[SECCION]"){
					if ($sec_name!="") 
					$sec_name=substr($value,9);
					echo '<li class="nav-item"><a class="nav-link">'.$sec_name.'</a></li>';
				}else{
					$l=explode('|',$value);
					echo '<li class="nav-item"><a class="nav-link"  href=\"'.$l[1].'\"';
					if (isset($l[2]) and $l[2]=="Y") echo " target=_blank";
					echo ">".$l[0]."</a></li>\n";
				}
			}

		}
		echo "</ul>\n";
	}
}
?>



<form name="bi" action="/opac/buscar_integrada.php" method="post">
<input type="hidden" name="base">
<input type="hidden" name="cipar">
<input type="hidden" name="Opcion">
<input type="hidden" name="coleccion">
<input type="hidden" name="Expresion">
<input type="hidden" name="titulo_c">
<input type="hidden" name="resaltar">
<input type="hidden" name="submenu">
<input type="hidden" name="Pft">
<input type="hidden" name="mostrar_exp">
<input type="hidden" name="home">
<?php
echo "<input type=hidden name=modo value=\"";
if (isset($_REQUEST["modo"])) echo $_REQUEST["modo"];
echo "\">\n";
if (isset($_REQUEST["integrada"]))
	echo "<input type=hidden name=integrada value=\"".str_replace('"','&quot;',$_REQUEST["integrada"])."\">\n";
if (isset($_REQUEST["db_path"]))
	echo "<input type=hidden name=db_path value=\"".str_replace('"','&quot;',$_REQUEST["db_path"])."\">\n";
if (isset($lang))
	echo "<input type=hidden name=lang value=\"".str_replace('"','&quot;',$lang)."\">\n";
?>
</form>
<script>
function BuscarIntegrada(base,modo,Opcion,Expresion,Coleccion,titulo_c,resaltar,submenu,Pft,mostrar_exp){

	if (mostrar_exp!="") document.bi.action="/opac/inicio_base.php"
	document.bi.base.value=base
	document.bi.Opcion.value=Opcion
	document.bi.modo.value=modo
	document.bi.home.value=mostrar_exp
	if (Opcion=="libre"){
		document.bi.coleccion.value=Coleccion
		document.bi.Expresion.value=Expresion
	}
	if (Opcion=="directa"){
		document.bi.Expresion.value=Expresion
		document.bi.titulo_c.value=titulo_c
		document.bi.resaltar.value=resaltar
		document.bi.submenu.value=submenu
		document.bi.Pft.value=Pft
		document.bi.mostrar_exp.value=mostrar_exp
	}
	document.bi.submit()
}
</script>

      </div>
    </nav>