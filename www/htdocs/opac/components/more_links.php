	
	<?php
	/**
	 * This script displays links added in the file opac_conf/[lang]/side_bar.info
	 * 
	 * 20230313 rogercgui File created
	 */
	
	if (file_exists($db_path."opac_conf/".$lang."/side_bar.info")){
		$fp=file($db_path."opac_conf/".$lang."/side_bar.info");
		$sec_name="";
		foreach ($fp as $value){
			$value=trim($value);
			if ($value!=""){
				if (substr($value,0,9)=="[SECCION]"){
					if ($sec_name!="")  echo "</ul><hr>";
					$sec_name=substr($value,9);
				?>
					<h6><?php echo $sec_name;?></h6>
					<ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
				<?php
				}else{
				
					$l=explode('|',$value);
					echo "<li class='nav-item'><a class='nav-link' href=\"".$l[1]."\"";
					if (isset($l[2]) and $l[2]=="Y") echo " target=_blank";
					echo ">".$l[0]."</a></li>\n";
				}
				
			}

		}
	}