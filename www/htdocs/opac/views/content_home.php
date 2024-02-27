<?php 

if (file_exists($db_path."opac_conf/".$lang."/sitio.info")){
	$fp=file($db_path."opac_conf/".$lang."/sitio.info");

	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			if (substr($value,0,6)=="[LINK]"){
				$home_link=substr($value,6);
				$hl=explode('|||',$home_link);
				$home_link=$hl[0];
				if (isset($hl[1]))
					$height_link=$hl[1];
				else
					$height_link=800;
				echo "<iframe frameborder=\"0\"  width=100% height=\"".$height_link  ."\"src=\"".$home_link."\")></iframe>";
	            break;
			}else{
				if (substr($value,0,6)=="[TEXT]"){
	?>
		<div class="post card rounded-0 bg-white">
			<div class="entry card-body p-5">
			<?php
                    $archivo=trim($db_path."opac_conf/".$lang."/".trim(substr($value,6)));
					if (file_exists($archivo)){
						$fp_h=file($archivo);
						foreach ($fp_h as $linea){
							echo $linea;
						}
					}
				}
				?>
				</div>
			</div>

			<?php
			}
		}
	}
 } ?>