<?php
/**
 * This script displays a dropdown with the list of available databases.
 * 20230312 rogercgui Created
 */
?>

<div class="dropdown">
  <button class="btn btn-light dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    <?php echo $msgstr["front_catalog"];?>
  </button>
	<ul class="dropdown-menu w-100">

<?php
if (!isset($_REQUEST["existencias"]) or trim($_REQUEST["existencias"])=="" ){


    $primeravez="S";
     if (isset($_REQUEST["modo"]) and $_REQUEST["modo"]!=""){
}

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
				echo "**".$value_info."<br>";
			}
		}
		if (trim($value["nombre"])!=""){
			echo "<li><a class='dropdown-item' href='javascript:BuscarIntegrada(\"$key\",\"\",\"free\",\"\",\"\",\"\",\"\",\"\",\"\",\"$home_link\")'>";
			echo "<strong>".$value["titulo"]."</strong></a></li>\n";
	    	if (file_exists($archivo)){
	    		$fp=file($archivo);
				?>
	    		<ul class="list-unstyled">
				<?php
	    		foreach ($fp as $colec){
	          		$colec=trim($colec);
	          		if ($colec!=""){
	          			$v=explode('|',$colec);
	          			$ix=$ix+1;
	          			if ($v[0]!='<>'){
							if (isset($IndicePorColeccion) and $IndicePorColeccion=="Y")
								$cipar="_".strtolower($v[0]);
							else
								$cipar="";
							echo "<li>";
							//echo "<a class='dropdown-item' href='javascript:BuscarIntegrada(\"$key\",\"1B\",\"free\",\"\",\"$colec\",\"\",\"\",\"\",\"\",\"\")'>";
							echo "<a href=\"buscar_integrada.php?base=".$key."&cipar=".$key.$cipar."&coleccion=".$colec."&Opcion=free\">";
			          		echo $v[1]."</a></li>\n";
	          			}else{
		          				//echo "<li>".$v[1]."</i></label></a></li>\n";
		        		}
		          	}
	          	}
	          	echo "</ul>\n";
				echo '<li><hr class="dropdown-divider"></li>';
	    	}else{
	    		//echo "</li>\n";
	   		}
	     }

	}
?>

  </ul>
</div>

<?php } ?>