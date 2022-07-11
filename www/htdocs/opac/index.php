<?php
/**************** Modifications ****************

2022-03-23 rogercgui change the folder /par to the variable $actparfolder

***********************************************/

$_REQUEST["modo"]="integrado";
if (file_exists("opac_dbpath.dat")){
	$fp=file("opac_dbpath.dat");
	foreach ($fp as $linea){
		$linea=trim($linea);
		if ($linea!=""){
			$l=explode('|',$linea);
			if (isset($l[2]) and $l[2]!=""){
				if ($_REQUEST["db_path"]==$l[0]){
					$lang=$l[2];
				}
			}
		}
	}
}

include("../central/config_opac.php");

include("leer_bases.php");
$primeraPagina="S";
include("head.php");

?>

<div class="post">
    <div style="clear: both;">&nbsp;</div>
    <div class="entry">
        <?php 
			if (isset($_REQUEST["primeravez"]) and $_REQUEST["primeravez"]=="Y"){
		?>
        <script>
        	document.cookie = 'ORBITA=;';
        </script>
        <?php
}
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
    </div>
</div>

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