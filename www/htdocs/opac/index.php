<?php
/**************** Modifications ****************
2022-03-23 rogercgui change the folder /par to the variable $actparfolder
***********************************************/
include realpath(__DIR__ . '/../central/config_opac.php');

/*
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
*/


$primeraPagina="Y";


if (isset($_REQUEST["primeravez"]) and $_REQUEST["primeravez"]=="Y"){ ?>
<script>
	document.cookie = 'ABCD=;';
</script>

<?php 
}

include("head.php");

if (isset($_REQUEST["cookie"])) {
	include("views/view_selection.php");
}  elseif (isset($_REQUEST["k"])) {
	include("components/permalink.php");
}  elseif ((isset($_REQUEST["indice"])) and  $_REQUEST["indice"]==="yes" ){
	$startpage="N";
	include("views/alfabetico.php");
} else {
	include("views/content_home.php");
}
?>

<?php include("views/footer.php");?>
