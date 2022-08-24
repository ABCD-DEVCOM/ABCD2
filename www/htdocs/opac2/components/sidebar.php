<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky"> 
		<ul class="nav flex-column">
<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/opac/components/facets.php');

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




      </div>
    </nav>