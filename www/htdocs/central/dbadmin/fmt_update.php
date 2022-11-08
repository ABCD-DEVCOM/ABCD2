<?php
/*
** 20220112 fho4abcd backbutton+helper+clean html+improve message
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
include("../common/header.php");
?>
<body>
<?php
$backtoscript="../dbadmin/fmt_adm.php"; // The default return script
include("../common/institutional_info.php");
?>
<div class="sectionInfo">
	<div class="breadcrumb">
    <?php echo $msgstr["fmt"].": ". $arrHttp["nombre"]."-".$arrHttp["descripcion"]." (".$arrHttp["base"].")"?>
	</div>
	<div class="actions">
    <?php 
    include "../common/inc_back.php";
    include "../common/inc_home.php";
    ?>
    </div>
    <div class="spacer">&#160;</div>
</div>
<?php include "../common/inc_div-helper.php";?>
<div class="middle form">
<div class="formContent">

<?php
$fmtfilename        = $db_path.$arrHttp["base"]."/def/".$lang."/".$arrHttp["nombre"].".fmt";
$formatosfilename   = $db_path.$arrHttp["base"]."/def/".$lang."/formatos.wks";
$formatosdeffilename= $db_path.$arrHttp["base"]."/def/".$lang_db."/formatos.wks";

$fp=fopen($fmtfilename,"w",0);
if (!$fp){
    echo "<p style='color:red'>".$fmtfilename." &rarr; ".$msgstr["nopudoseractualizado"]."<p>";
	die;
}
if (isset($arrHttp["wks"])){
	$fmt=ConstruyeWorksheetFMT();
	foreach ($fmt as $value){
	    $value=trim($value);
	    if ($value!="") $res=fwrite($fp,$value."\n");
	}
	fclose($fp); #close the file
    ?>
    <h4 style="text-align:center"><?php echo $msgstr["fmtupdated"]?>: &nbsp;<?php echo $fmtfilename?></h4>
    <?php
}

if (file_exists($formatosfilename)){
	$fp=file($db_path.$arrHttp["base"]."/def/".$_SESSION["lang"]."/formatos.wks");
} else {
    if (file_exists($formatosdeffilename)) {
        $fp=file($formatosdeffilename);
    }
}
$fex="N";
if (isset($arrHttp["fmt"])){
	$name=explode('|',$arrHttp["fmt"]);
	$arrHttp["nombre"]=trim($name[0]);
}
if ($fp){
	foreach ($fp as $linea){
		$linea=trim($linea);
		if ($linea!=""){
			$l=explode('|',$linea);
			if (isset($arrHttp["fmt"])) $arrHttp["descripcion"]=$l[1];
			if (trim($l[0])==trim($arrHttp["nombre"])){
				$fex="S";
				$lfmt=$l[0].'|'.trim($arrHttp["descripcion"]);
				if (isset($arrHttp["sel_oper"])) $lfmt.='|'.$arrHttp["sel_oper"];
				$salida[]=$lfmt;
			}else{
				$salida[]=$linea;
			}
		}
	}
}

//IF IS A NEW FORMAT
if ($fex=="N"){
	$wks=$arrHttp["nombre"].'|'.$arrHttp["descripcion"]."|";
	if (isset($arrHttp["sel_oper"])) $wks.=$arrHttp["sel_oper"];
	$salida[]=$wks;
}
$fp=fopen($formatosfilename,"w");
foreach ($salida as $arch) $res=fwrite($fp,$arch."\n");
fclose($fp);
?>
<h4 style="text-align:center"><?php echo $msgstr["updated"]?>: &nbsp;<?php echo $formatosfilename?></h4>

</div></div>
<?php include("../common/footer.php");
/*==========================================*/
function ConstruyeWorksheetFMT(){
global $arrHttp,$vars,$db_path,$lang_db;
	$base=$arrHttp["base"];
	$fpDb_fdt = $db_path.$base."/def/".$_SESSION["lang"]."/"."$base.fdt";
	if (!file_exists($fpDb_fdt)) {
		$fpDb_fdt = $db_path.$base."/def/".$lang_db."/"."$base.fdt";
		if (!file_exists($fpDb_fdt)){
   			echo $db_path.$base."/def/".$_SESSION["lang"]."/$base.fdt"." no existe";
			die;
		}
	}
	$fpDb=file($fpDb_fdt);
	// se lee la estructura de la base de datos (dbn.fdt)
	foreach ($fpDb as $var=>$value){
		$base_fdt[]=$value;
	}
	$fp=explode("\n",$arrHttp["wks"]);
	$ix=-1;
	echo "<p>";
	foreach ($fp as $value){
		$value=trim($value);
		if ($value!=""){
			unset($tx);
			$tx=explode('|',$value) ;
			if (count($tx)>1) {
				if ($tx[0]=="H" or $tx[0]=="L"){
					$ix=$ix+1;
					$vars[$ix]=$value;
					continue;
				}
				$ix=$ix+1;
				$vars[$ix]=$value;
				reset($base_fdt);
				$entro="";
				$primeravez="S";
				foreach ($base_fdt as $lin){ //COPY THE SUBFIELD OF THE SELECTED FIELD, IF ANY
					$vx=explode('|',$lin);
					if ($vx[1]==$tx[1] or $entro=="S"){
 						$entro="S";
						if (trim($vx[0])!="S" ){       //S IN THE FIRST COLUMN INDICATES SUBFIELD
							if ($primeravez=="S"){
								$primeravez="";
							}else{
								break;
							}
						}else{
							$ix=$ix+1;
							$vars[$ix]=$lin;
						}
					}
				}
			}
		}
	}
	return $vars;
}
?>

