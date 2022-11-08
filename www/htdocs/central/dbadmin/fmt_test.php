<?php
/*
** 20220112 fho4abcd remove non-existent include+error messages+improve html_entity_decode+ script moved to dbadmin
*/
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}
include("../common/get_post.php");
include("../config.php");
$lang=$_SESSION["lang"];
include("../lang/dbadmin.php");
include("../lang/admin.php");

$base=$arrHttp["base"];
include("../common/header.php");

?>
<body>
<div class="sectionInfo">
    <div class="breadcrumb">
    <?php echo $msgstr["credfmt"]." &rarr; ".$msgstr["preview"]?>
    </div>
    <div class="actions">
    <?php
    include "../common/inc_close.php";
    ?>
	</div>
    <div class="spacer">&#160;</div>
</div>

<?php
include "../common/inc_div-helper.php";

//Se lee el archivo .fdt de la base de datos para construir la hoja de ingreso

$fpTm = file($db_path.$base."/def/".$_SESSION["lang"]."/$base.fdt");
if (!$fpTm) {
	$fpTm = file($db_path.$base."/def/".$lang_db."/$base.fdt");
}
if (!$fpTm) {
   	echo $base."/$base.fdt".$msgstr["ne"];
	die;
}
$base_fdt=array();
foreach ($fpTm as $linea){
	if (trim($linea)!="") {
		$base_fdt[]=$linea;
	}
}

$t=explode("\n",urldecode($arrHttp["fmt"]));

$ix=-1;
global $vars;
$fdt=array();

//Se construye el formato de entrada tomando los valores de la FDT
foreach ($t as $value){
	if (trim($value)!=""){		$tx=explode('|',$value) ;
		if (trim($tx[1])=="") {			$ix=$ix+1;
//			$fdt[$ix]=$value;
			$vars[$ix]=$value;		}else{
			$primeravez="S";			foreach ($base_fdt as $lin){
				$vx=array();				$vx=explode('|',$lin);
				if ($vx[1]==$tx[1] or $primeravez=="N"){
					if ($primeravez=="S" and trim($vx[1])!=""){
						$ix=$ix+1;
//						$fdt[$ix]=$lin;
						$vars[$ix]=$lin;						$primeravez="N";					}else{						if (trim($vx[1])!="" or trim($vx[0])=="H"){       //Si la columna de tag no tiene un blanco se termina la lista de los subcampos							break;						}else{							$ix=$ix+1;
//							$fdt[$ix]=$lin;
							$vars[$ix]=$lin;						}					}				}			}		}
	}
}
// required by included files
$fmt_test="S";
$arrHttp["cipar"]="$base.par";
$arrHttp["Mfn"]=0;
include("../dataentry/dibujarhojaentrada.php");
include("../dataentry/ingresoadministrador.php");

?>


