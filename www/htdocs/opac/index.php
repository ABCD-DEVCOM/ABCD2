<?php
/**************** Modifications ****************

2022-03-23 rogercgui change the folder /par to the variable $actparfolder

***********************************************/


include("../central/config_opac.php");
$primeraPagina="S";

include("head.php");
?>

<?php
// Iframe do site embedado
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
			} else {
				if (substr($value,0,6)=="[TEXT]"){
                    $archivo=trim($db_path."opac_conf/".$lang."/".trim(substr($value,6)));
					if (file_exists($archivo)){
						$fp_h=file($archivo);
						foreach ($fp_h as $linea){
							echo "$linea";
						}
					}
				}
			}
		}
	}

}
?>

<?php include("components/footer.php");?>

<script>
function resizer(id) {
    var doc = document.getElementById(id).contentWindow.document;
    var body_ = doc.body;
    html_ = doc.documentElement;
    var height = Math.max(body_.scrollHeight, body_.offsetHeight, html_.clientHeight, html_.scrollHeight, html_
        .offsetHeight);
    var width = Math.max(body_.scrollWidth, body_.offsetWidth, html_.clientWidth, html_.scrollWidth, html_.offsetWidth);
    document.getElementById(id).style.height = height;
    document.getElementById(id).style.width = width;
}
</script>